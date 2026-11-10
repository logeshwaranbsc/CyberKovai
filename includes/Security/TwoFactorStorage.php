<?php
declare(strict_types=1);

namespace CyberKovai\Security;

use RuntimeException;

/**
 * File-based persistent storage for Admin 2FA records.
 * Uses exclusive flock() across read-modify-write transactions, atomic temp-file renames,
 * automatic rotating backups, restrictive permissions, and strict schema validation.
 */
class TwoFactorStorage
{
    private const STORE_VERSION = 1;
    private const MAX_BACKUPS = 10;

    private string $storageDir;
    private string $storePath;
    private string $lockPath;
    private string $backupDir;

    public function __construct(?string $storageDir = null)
    {
        $this->storageDir = self::resolveStorageDirectory($storageDir);

        $this->storePath = $this->storageDir . DIRECTORY_SEPARATOR . 'admin_2fa.json';
        $this->lockPath  = $this->storageDir . DIRECTORY_SEPARATOR . 'admin_2fa.lock';
        $this->backupDir = $this->storageDir . DIRECTORY_SEPARATOR . 'backups';
    }

    public static function resolveStorageDirectory(?string $override = null): string
    {
        if ($override !== null && trim($override) !== '') {
            return rtrim(trim($override), "/\\");
        }

        $configured = function_exists('env')
            ? (string) (env('CK_SECURE_STORAGE_DIR') ?: '')
            : (string) (getenv('CK_SECURE_STORAGE_DIR') ?: '');

        if (trim($configured) !== '') {
            return rtrim(trim($configured), "/\\");
        }

        return dirname(__DIR__, 2) . DIRECTORY_SEPARATOR . 'storage' . DIRECTORY_SEPARATOR . 'security';
    }

    public static function ensureDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            if (!@mkdir($dir, 0700, true) && !is_dir($dir)) {
                throw new RuntimeException('Unable to initialize secure storage directory.');
            }
        }
        @chmod($dir, 0700);
    }

    public static function atomicWriteFile(string $targetPath, string $content): bool
    {
        $dir = dirname($targetPath);
        self::ensureDirectory($dir);

        $tmpPath = $targetPath . '.tmp.' . getmypid() . '.' . bin2hex(random_bytes(6));
        $fp = @fopen($tmpPath, 'wb');
        if ($fp === false) {
            return false;
        }

        try {
            @chmod($tmpPath, 0600);
            $len = strlen($content);
            $written = fwrite($fp, $content);
            if ($written !== $len) {
                return false;
            }
            if (!fflush($fp)) {
                return false;
            }
        } finally {
            fclose($fp);
        }

        for ($attempt = 0; $attempt < 5; $attempt++) {
            if (@rename($tmpPath, $targetPath)) {
                @chmod($targetPath, 0600);
                return true;
            }
            usleep(5000);
        }

        @unlink($tmpPath);
        return false;
    }

    public function getStorageDir(): string
    {
        return $this->storageDir;
    }

    public function getStorePath(): string
    {
        return $this->storePath;
    }

    /**
     * Read a single admin's 2FA record under a shared lock.
     *
     * @return array<string, mixed>|null
     * @throws CorruptedStorageException
     */
    public function getRecord(string $adminId): ?array
    {
        $adminId = trim($adminId);
        if ($adminId === '') {
            return null;
        }

        $lockFp = $this->openLockFile();
        try {
            if (!flock($lockFp, LOCK_SH)) {
                throw new CorruptedStorageException('Unable to acquire shared lock on 2FA storage.');
            }
            $store = $this->readAndValidateStore();
            return $store['records'][$adminId] ?? null;
        } finally {
            flock($lockFp, LOCK_UN);
            fclose($lockFp);
        }
    }

    /**
     * Verify whether the store file is readable and structurally valid.
     */
    public function validateIntegrity(): void
    {
        $lockFp = $this->openLockFile();
        try {
            if (!flock($lockFp, LOCK_SH)) {
                throw new CorruptedStorageException('Unable to acquire shared lock on 2FA storage.');
            }
            $this->readAndValidateStore();
        } finally {
            flock($lockFp, LOCK_UN);
            fclose($lockFp);
        }
    }

    /**
     * Perform an exclusive locked atomic read-modify-write on the 2FA store.
     *
     * Callback receives array $store and must return:
     *   ['store' => array, 'result' => mixed, 'write' => bool (optional, default true)]
     *
     * @template T
     * @param callable(array<string, mixed>): array{store?: array<string, mixed>, result: T, write?: bool} $mutator
     * @return T
     * @throws CorruptedStorageException
     */
    public function mutate(callable $mutator)
    {
        $lockFp = $this->openLockFile();
        try {
            if (!flock($lockFp, LOCK_EX)) {
                throw new CorruptedStorageException('Unable to acquire exclusive lock on 2FA storage.');
            }

            $store = $this->readAndValidateStore();
            $outcome = $mutator($store);

            $shouldWrite = $outcome['write'] ?? true;
            if ($shouldWrite) {
                $newStore = $outcome['store'] ?? $store;
                $this->assertValidStoreStructure($newStore);

                $json = json_encode($newStore, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                if ($json === false) {
                    throw new RuntimeException('Failed to encode 2FA configuration store.');
                }

                $this->createBackupIfExists();

                if (!self::atomicWriteFile($this->storePath, $json)) {
                    throw new RuntimeException('Failed to persist 2FA configuration atomically.');
                }
            }

            return $outcome['result'];
        } finally {
            flock($lockFp, LOCK_UN);
            fclose($lockFp);
        }
    }

    /**
     * Migrate a 2FA record when an admin username changes, re-encrypting AAD cleanly.
     */
    public function migrateAdminIdentifier(string $oldAdminId, string $newAdminId, CryptoService $crypto): void
    {
        $oldAdminId = trim($oldAdminId);
        $newAdminId = trim($newAdminId);
        if ($oldAdminId === '' || $newAdminId === '' || $oldAdminId === $newAdminId) {
            return;
        }

        $this->mutate(function (array $store) use ($oldAdminId, $newAdminId, $crypto): array {
            if (!isset($store['records'][$oldAdminId])) {
                return ['write' => false, 'result' => null];
            }

            $record = $store['records'][$oldAdminId];
            if (!empty($record['secret_encrypted']) && is_string($record['secret_encrypted'])) {
                $plaintextSecret = $crypto->decrypt($record['secret_encrypted'], $oldAdminId);
                $record['secret_encrypted'] = $crypto->encrypt($plaintextSecret, $newAdminId);
            }
            $record['admin_id'] = $newAdminId;
            $record['updated_at'] = gmdate('c');

            unset($store['records'][$oldAdminId]);
            $store['records'][$newAdminId] = $record;

            return ['store' => $store, 'result' => null, 'write' => true];
        });
    }

    /**
     * @return resource
     */
    private function openLockFile()
    {
        try {
            self::ensureDirectory($this->storageDir);
        } catch (RuntimeException $e) {
            throw new CorruptedStorageException('Unable to initialize 2FA storage directory.', 0, $e);
        }
        $fp = @fopen($this->lockPath, 'c+b');
        if ($fp === false) {
            throw new CorruptedStorageException('Unable to open 2FA storage lock file.');
        }
        @chmod($this->lockPath, 0600);
        return $fp;
    }

    /**
     * @return array<string, mixed>
     */
    private function readAndValidateStore(): array
    {
        if (!file_exists($this->storePath)) {
            return [
                'version' => self::STORE_VERSION,
                'records' => [],
            ];
        }

        $raw = @file_get_contents($this->storePath);
        if ($raw === false || trim($raw) === '') {
            throw new CorruptedStorageException('2FA configuration file exists but is unreadable or empty.');
        }

        $decoded = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            throw new CorruptedStorageException('2FA configuration file contains malformed JSON.');
        }

        $this->assertValidStoreStructure($decoded);
        return $decoded;
    }

    /**
     * @param mixed $data
     */
    private function assertValidStoreStructure($data): void
    {
        if (!is_array($data)) {
            throw new CorruptedStorageException('2FA storage root must be an object.');
        }

        if (($data['version'] ?? null) !== self::STORE_VERSION) {
            throw new CorruptedStorageException('Unsupported or missing 2FA storage schema version.');
        }

        if (!isset($data['records']) || !is_array($data['records'])) {
            throw new CorruptedStorageException('2FA storage records map is missing or invalid.');
        }

        foreach ($data['records'] as $adminId => $record) {
            if (!is_string($adminId) || trim($adminId) === '' || !is_array($record)) {
                throw new CorruptedStorageException('Corrupted 2FA record entry detected.');
            }

            if (!isset($record['enabled']) || !is_bool($record['enabled']) ||
                !isset($record['confirmed']) || !is_bool($record['confirmed'])) {
                throw new CorruptedStorageException('2FA record flags are invalid or corrupted.');
            }

            if ($record['enabled'] === true) {
                if ($record['confirmed'] !== true) {
                    throw new CorruptedStorageException('Enabled 2FA record is not confirmed.');
                }
                if (empty($record['secret_encrypted']) || !is_string($record['secret_encrypted'])) {
                    throw new CorruptedStorageException('Enabled 2FA record is missing encrypted secret.');
                }
            }

            if (isset($record['recovery_codes']) && !is_array($record['recovery_codes'])) {
                throw new CorruptedStorageException('Corrupted 2FA recovery codes structure.');
            }
        }
    }

    private function createBackupIfExists(): void
    {
        if (!file_exists($this->storePath)) {
            return;
        }

        self::ensureDirectory($this->backupDir);
        $raw = @file_get_contents($this->storePath);
        if ($raw === false) {
            return;
        }

        $backupName = sprintf(
            'admin_2fa_%s_%s.json',
            gmdate('Ymd_His'),
            bin2hex(random_bytes(4))
        );
        $backupPath = $this->backupDir . DIRECTORY_SEPARATOR . $backupName;
        self::atomicWriteFile($backupPath, $raw);

        $backups = glob($this->backupDir . DIRECTORY_SEPARATOR . 'admin_2fa_*.json');
        if (is_array($backups) && count($backups) > self::MAX_BACKUPS) {
            sort($backups);
            $excess = array_slice($backups, 0, count($backups) - self::MAX_BACKUPS);
            foreach ($excess as $oldFile) {
                @unlink($oldFile);
            }
        }
    }
}

