<?php
declare(strict_types=1);

namespace CyberKovai\Security;

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use PragmaRX\Google2FA\Google2FA;
use RuntimeException;

/**
 * Core Two-Factor Authentication (TOTP) service for Admin accounts.
 */
class TwoFactorService
{
    private const ALLOWED_ADMIN_ROLES = ['superadmin', 'admin'];
    private const TIME_STEP_SECONDS = 30;

    private TwoFactorStorage $storage;
    private ?CryptoService $crypto;
    private AuditLogger $logger;
    private Google2FA $google2fa;
    private string $issuer;
    private int $window;

    public function __construct(
        ?TwoFactorStorage $storage = null,
        ?CryptoService $crypto = null,
        ?AuditLogger $logger = null,
        ?Google2FA $google2fa = null,
        ?string $issuer = null,
        ?int $window = null
    ) {
        $this->storage = $storage ?? new TwoFactorStorage();
        $this->crypto = $crypto;
        $this->logger = $logger ?? new AuditLogger($this->storage->getStorageDir());
        $this->google2fa = $google2fa ?? new Google2FA();

        $envIssuer = function_exists('env') ? (string) (env('CK_2FA_ISSUER') ?: 'Cyber Kovai') : 'Cyber Kovai';
        $this->issuer = trim($issuer ?? $envIssuer) ?: 'Cyber Kovai';

        $envWindow = function_exists('env') ? (int) (env('CK_2FA_WINDOW') ?? 1) : 1;
        $resolvedWindow = $window ?? $envWindow;
        $this->window = max(0, min(2, $resolvedWindow));
        $this->google2fa->setWindow($this->window);
    }

    /**
     * Only administrator roles are eligible for or subject to 2FA.
     */
    public static function isEligibleAdminRole(?string $role): bool
    {
        $normalized = strtolower(trim((string) $role));
        return in_array($normalized, self::ALLOWED_ADMIN_ROLES, true);
    }

    public function assertAdminAccount(array $admin): string
    {
        $role = (string) ($admin['role'] ?? '');
        if (!self::isEligibleAdminRole($role)) {
            throw new RuntimeException('Two-factor authentication is restricted to administrator accounts.');
        }

        $adminId = trim((string) ($admin['username'] ?? ''));
        if ($adminId === '') {
            throw new RuntimeException('Invalid administrator account identifier.');
        }

        return $adminId;
    }

    /**
     * Determine if login for this account requires a 2FA challenge.
     * Non-admin roles are never forced into 2FA.
     *
     * @throws CorruptedStorageException
     */
    public function requiresTwoFactor(array $admin): bool
    {
        if (!self::isEligibleAdminRole((string) ($admin['role'] ?? ''))) {
            return false;
        }

        $adminId = trim((string) ($admin['username'] ?? ''));
        if ($adminId === '') {
            return false;
        }

        $record = $this->storage->getRecord($adminId);
        if ($record === null) {
            return false;
        }

        if (!empty($record['enabled']) && !empty($record['confirmed'])) {
            // Verify decryption works before claiming healthy state (fail closed if corrupted or key invalid)
            $this->decryptSecret($record, $adminId);
            return true;
        }

        return false;
    }

    /**
     * Safe status summary for Admin Profile UI (never includes secret keys).
     *
     * @return array<string, mixed>
     */
    public function getStatus(string $adminId): array
    {
        try {
            $record = $this->storage->getRecord($adminId);
        } catch (CorruptedStorageException $e) {
            $this->logger->log('2fa_storage_error', $adminId, ['reason' => $e->getMessage()]);
            return [
                'enabled'       => false,
                'confirmed'     => false,
                'pending_setup' => false,
                'confirmed_at'  => null,
                'corrupted'     => true,
            ];
        }

        if ($record === null) {
            return [
                'enabled'       => false,
                'confirmed'     => false,
                'pending_setup' => false,
                'confirmed_at'  => null,
                'corrupted'     => false,
            ];
        }

        return [
            'enabled'       => !empty($record['enabled']),
            'confirmed'     => !empty($record['confirmed']),
            'pending_setup' => empty($record['enabled']) && empty($record['confirmed']) && !empty($record['secret_encrypted']),
            'confirmed_at'  => $record['confirmed_at'] ?? null,
            'corrupted'     => false,
        ];
    }

    /**
     * Step 1 of Enable 2FA: generate unique encrypted TOTP secret and provisioning URI.
     * Does NOT mark 2FA as enabled until confirmSetup() verifies a valid OTP.
     *
     * @return array{secret_manual: string, provisioning_uri: string}
     */
    public function initiateSetup(array $admin): array
    {
        $adminId = $this->assertAdminAccount($admin);
        $crypto = $this->getCrypto();

        $secret = $this->google2fa->generateSecretKey(32);
        $encryptedSecret = $crypto->encrypt($secret, $adminId);
        $nowIso = gmdate('c');

        $this->storage->mutate(function (array $store) use ($adminId, $encryptedSecret, $nowIso): array {
            $existing = $store['records'][$adminId] ?? null;
            if ($existing !== null && !empty($existing['enabled']) && !empty($existing['confirmed'])) {
                throw new RuntimeException('Two-factor authentication is already enabled on this account.');
            }

            $store['records'][$adminId] = [
                'admin_id'            => $adminId,
                'secret_encrypted'    => $encryptedSecret,
                'enabled'             => false,
                'confirmed'           => false,
                'confirmed_at'        => null,
                'last_totp_timeslice' => $existing['last_totp_timeslice'] ?? null,
                'updated_at'          => $nowIso,
            ];

            return ['store' => $store, 'result' => true, 'write' => true];
        });

        $label = trim((string) ($admin['email'] ?? '')) ?: $adminId;
        $uri = $this->google2fa->getQRCodeUrl($this->issuer, $label, $secret);

        $this->logger->log('2fa_setup_initiated', $adminId, ['role' => $admin['role'] ?? 'admin']);

        return [
            'secret_manual'    => $secret,
            'provisioning_uri' => $uri,
        ];
    }

    /**
     * Retrieve provisioning data ONLY while setup is pending (not yet confirmed/enabled).
     *
     * @return array{secret_manual: string, provisioning_uri: string}|null
     */
    public function getPendingProvisioningData(array $admin): ?array
    {
        $adminId = $this->assertAdminAccount($admin);
        $record = $this->storage->getRecord($adminId);

        if (
            $record === null ||
            !empty($record['enabled']) ||
            !empty($record['confirmed']) ||
            empty($record['secret_encrypted'])
        ) {
            return null;
        }

        $secret = $this->decryptSecret($record, $adminId);
        $label = trim((string) ($admin['email'] ?? '')) ?: $adminId;

        return [
            'secret_manual'    => $secret,
            'provisioning_uri' => $this->google2fa->getQRCodeUrl($this->issuer, $label, $secret),
        ];
    }

    /**
     * Render a crisp SVG QR code for the otpauth:// provisioning URI without requiring ext-gd.
     */
    public function renderQrSvg(string $provisioningUri): string
    {
        $options = new QROptions([
            'version'       => QRCode::VERSION_AUTO,
            'outputType'    => QRCode::OUTPUT_MARKUP_SVG,
            'eccLevel'      => QRCode::ECC_M,
            'imageBase64'   => false,
            'quietzoneSize' => 4,
            'markupDark'    => '#0a0a1f',
            'markupLight'   => '#ffffff',
            'cssClass'      => 'ck-totp-qr',
        ]);

        return (string) (new QRCode($options))->render($provisioningUri);
    }

    /**
     * Cancel an unconfirmed pending 2FA setup.
     */
    public function cancelSetup(array $admin): bool
    {
        $adminId = $this->assertAdminAccount($admin);

        $cancelled = $this->storage->mutate(function (array $store) use ($adminId): array {
            $record = $store['records'][$adminId] ?? null;
            if ($record === null || !empty($record['enabled'])) {
                return ['write' => false, 'result' => false];
            }
            unset($store['records'][$adminId]);
            return ['store' => $store, 'result' => true, 'write' => true];
        });

        if ($cancelled) {
            $this->logger->log('2fa_setup_cancelled', $adminId);
        }

        return $cancelled;
    }

    /**
     * Step 2 of Enable 2FA: verify first 6-digit OTP and only then enable 2FA.
     *
     * @return array{success: bool, error?: string, timeslice?: int}
     */
    public function confirmSetup(array $admin, string $otp, ?int $now = null): array
    {
        $adminId = $this->assertAdminAccount($admin);
        $otp = $this->normalizeOtp($otp);
        if ($otp === null) {
            $this->logger->log('2fa_setup_failed', $adminId, ['reason' => 'invalid_format']);
            return ['success' => false, 'error' => 'Please enter a valid six-digit numeric authenticator code.'];
        }

        $now = $now ?? time();
        $slice = $this->timeSlice($now);
        $nowIso = gmdate('c', $now);

        $outcome = $this->storage->mutate(function (array $store) use ($adminId, $otp, $slice, $nowIso): array {
            $record = $store['records'][$adminId] ?? null;
            if ($record === null || empty($record['secret_encrypted'])) {
                return [
                    'write' => false,
                    'result' => ['success' => false, 'error' => 'No pending 2FA setup found. Please initiate setup again.'],
                ];
            }

            if (!empty($record['enabled']) && !empty($record['confirmed'])) {
                return [
                    'write' => false,
                    'result' => ['success' => false, 'error' => 'Two-factor authentication is already active.'],
                ];
            }

            $secret = $this->decryptSecret($record, $adminId);
            $oldSlice = isset($record['last_totp_timeslice']) && is_int($record['last_totp_timeslice'])
                ? $record['last_totp_timeslice']
                : -1;

            $matchedSlice = $this->google2fa->verifyKeyNewer($secret, $otp, $oldSlice, $this->window, $slice);
            if ($matchedSlice === false || !is_int($matchedSlice)) {
                return [
                    'write' => false,
                    'result' => ['success' => false, 'error' => 'Invalid or expired six-digit code. Ensure your device clock is synchronized.'],
                ];
            }

            $store['records'][$adminId] = [
                'admin_id'            => $adminId,
                'secret_encrypted'    => $record['secret_encrypted'],
                'enabled'             => true,
                'confirmed'           => true,
                'confirmed_at'        => $nowIso,
                'last_totp_timeslice' => $matchedSlice,
                'updated_at'          => $nowIso,
            ];

            return [
                'store'  => $store,
                'write'  => true,
                'result' => [
                    'success'   => true,
                    'timeslice' => $matchedSlice,
                ],
            ];
        });

        if ($outcome['success']) {
            $this->logger->log('2fa_setup_confirmed', $adminId, [
                'timeslice' => $outcome['timeslice'],
            ]);
        } else {
            $this->logger->log('2fa_setup_failed', $adminId, ['reason' => 'otp_mismatch']);
        }

        return $outcome;
    }

    /**
     * Verify a 6-digit TOTP code during admin login challenge with replay protection.
     *
     * @return array{success: bool, error?: string, reason?: string, timeslice?: int}
     * @throws CorruptedStorageException
     */
    public function verifyLoginOtp(array $admin, string $otp, ?int $now = null): array
    {
        $adminId = $this->assertAdminAccount($admin);
        $otp = $this->normalizeOtp($otp);
        if ($otp === null) {
            $this->logger->log('2fa_verify_failed', $adminId, ['reason' => 'invalid_format']);
            return ['success' => false, 'reason' => 'invalid_format', 'error' => 'Enter a valid six-digit verification code.'];
        }

        $now = $now ?? time();
        $slice = $this->timeSlice($now);
        $nowIso = gmdate('c', $now);

        $outcome = $this->storage->mutate(function (array $store) use ($adminId, $otp, $slice, $nowIso): array {
            $record = $store['records'][$adminId] ?? null;
            if ($record === null || empty($record['enabled']) || empty($record['confirmed'])) {
                throw new CorruptedStorageException('2FA record is missing or inactive during verification.');
            }

            $secret = $this->decryptSecret($record, $adminId);
            $oldSlice = isset($record['last_totp_timeslice']) && is_int($record['last_totp_timeslice'])
                ? $record['last_totp_timeslice']
                : -1;

            $matchedSlice = $this->google2fa->verifyKeyNewer($secret, $otp, $oldSlice, $this->window, $slice);
            if ($matchedSlice === false || !is_int($matchedSlice)) {
                $matchesUsedSlice = (bool) $this->google2fa->verifyKey($secret, $otp, $this->window, $slice);
                $reason = $matchesUsedSlice ? 'replay' : 'invalid';
                return [
                    'write'  => false,
                    'result' => [
                        'success' => false,
                        'reason'  => $reason,
                        'error'   => 'Invalid or already used verification code. Please wait for a fresh code and try again.',
                    ],
                ];
            }

            $store['records'][$adminId]['last_totp_timeslice'] = $matchedSlice;
            $store['records'][$adminId]['updated_at'] = $nowIso;

            return [
                'store'  => $store,
                'write'  => true,
                'result' => [
                    'success'   => true,
                    'timeslice' => $matchedSlice,
                ],
            ];
        });

        if ($outcome['success']) {
            $this->logger->log('2fa_verify_success', $adminId, ['timeslice' => $outcome['timeslice']]);
        } elseif (($outcome['reason'] ?? '') === 'replay') {
            $this->logger->log('2fa_replay_blocked', $adminId);
        } else {
            $this->logger->log('2fa_verify_failed', $adminId, ['reason' => $outcome['reason'] ?? 'invalid']);
        }

        return $outcome;
    }

    /**
     * Disable 2FA safely after verifying a fresh 6-digit authenticator OTP code.
     *
     * @return array{success: bool, error?: string}
     */
    public function disableTwoFactor(array $admin, string $otp, ?int $now = null): array
    {
        $adminId = $this->assertAdminAccount($admin);
        $otp = $this->normalizeOtp($otp);
        if ($otp === null) {
            $this->logger->log('2fa_disable_failed', $adminId, ['reason' => 'invalid_format']);
            return ['success' => false, 'error' => 'Enter a valid six-digit code from your authenticator app to disable 2FA.'];
        }

        $now = $now ?? time();
        $slice = $this->timeSlice($now);

        $outcome = $this->storage->mutate(function (array $store) use ($adminId, $otp, $slice): array {
            $record = $store['records'][$adminId] ?? null;
            if ($record === null || empty($record['enabled'])) {
                return [
                    'write'  => false,
                    'result' => ['success' => false, 'error' => 'Two-factor authentication is not currently enabled.'],
                ];
            }

            $secret = $this->decryptSecret($record, $adminId);
            $oldSlice = isset($record['last_totp_timeslice']) && is_int($record['last_totp_timeslice'])
                ? $record['last_totp_timeslice']
                : -1;

            $matchedSlice = $this->google2fa->verifyKeyNewer($secret, $otp, $oldSlice, $this->window, $slice);
            if (!is_int($matchedSlice)) {
                return [
                    'write'  => false,
                    'result' => ['success' => false, 'error' => 'Invalid or already used authenticator code. 2FA remains enabled.'],
                ];
            }

            unset($store['records'][$adminId]);

            return [
                'store'  => $store,
                'write'  => true,
                'result' => ['success' => true],
            ];
        });

        if ($outcome['success']) {
            $this->logger->log('2fa_disabled', $adminId);
        } else {
            $this->logger->log('2fa_disable_failed', $adminId);
        }

        return $outcome;
    }

    public function getStorage(): TwoFactorStorage
    {
        return $this->storage;
    }

    public function getLogger(): AuditLogger
    {
        return $this->logger;
    }

    public function getCrypto(): CryptoService
    {
        if ($this->crypto === null) {
            $this->crypto = new CryptoService();
        }
        return $this->crypto;
    }

    /**
     * @param array<string, mixed> $record
     */
    private function decryptSecret(array $record, string $adminId): string
    {
        $encrypted = $record['secret_encrypted'] ?? null;
        if (!is_string($encrypted) || trim($encrypted) === '') {
            throw new CorruptedStorageException('Encrypted TOTP secret is missing.');
        }

        try {
            return $this->getCrypto()->decrypt($encrypted, $adminId);
        } catch (\Throwable $e) {
            throw new CorruptedStorageException('Failed to decrypt stored TOTP secret.', 0, $e);
        }
    }

    private function normalizeOtp(string $otp): ?string
    {
        $clean = preg_replace('/\s+/', '', trim($otp));
        if ($clean === null || preg_match('/^\d{6}$/', $clean) !== 1) {
            return null;
        }
        return $clean;
    }

    private function timeSlice(int $unixTimestamp): int
    {
        return (int) floor($unixTimestamp / self::TIME_STEP_SECONDS);
    }
}
