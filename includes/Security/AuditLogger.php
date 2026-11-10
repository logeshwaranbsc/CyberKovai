<?php
declare(strict_types=1);

namespace CyberKovai\Security;

/**
 * Security audit logger that records 2FA and authentication events as JSONL
 * while automatically redacting sensitive fields (secrets, OTPs, passwords, recovery codes).
 */
class AuditLogger
{
    private string $logPath;

    public function __construct(?string $storageDir = null)
    {
        $dir = TwoFactorStorage::resolveStorageDirectory($storageDir);
        TwoFactorStorage::ensureDirectory($dir);
        $this->logPath = $dir . DIRECTORY_SEPARATOR . 'security_audit.log';
    }

    /**
     * Record a security event safely without ever logging secrets, OTPs, or passwords.
     *
     * @param array<string, mixed> $context
     */
    public function log(string $event, ?string $adminId = null, array $context = []): bool
    {
        $entry = [
            'timestamp' => gmdate('c'),
            'event'     => $event,
            'admin_id'  => $adminId,
            'ip'        => $this->resolveClientIp(),
            'ua_hash'   => $this->resolveUserAgentHash(),
            'context'   => $this->sanitizeContext($context),
        ];

        $line = json_encode($entry, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        if ($line === false) {
            return false;
        }

        $fp = @fopen($this->logPath, 'ab');
        if ($fp === false) {
            return false;
        }

        try {
            if (!flock($fp, LOCK_EX)) {
                return false;
            }
            $written = fwrite($fp, $line . "\n");
            fflush($fp);
            flock($fp, LOCK_UN);
            @chmod($this->logPath, 0600);
            return $written !== false;
        } finally {
            fclose($fp);
        }
    }

    public function getLogPath(): string
    {
        return $this->logPath;
    }

    /**
     * @param array<string, mixed> $context
     * @return array<string, mixed>
     */
    private function sanitizeContext(array $context): array
    {
        $sanitized = [];
        foreach ($context as $key => $value) {
            $keyLower = strtolower((string) $key);
            if (preg_match('/(password|secret|otp|totp|recovery_code|plaintext|csrf|token|private_key|app_key)/', $keyLower) === 1
                && strpos($keyLower, 'count') === false
                && strpos($keyLower, 'remaining') === false
            ) {
                $sanitized[$key] = '[REDACTED]';
                continue;
            }

            if (is_array($value)) {
                $sanitized[$key] = $this->sanitizeContext($value);
            } elseif (is_scalar($value) || $value === null) {
                $sanitized[$key] = $value;
            } else {
                $sanitized[$key] = '[OBJECT]';
            }
        }

        return $sanitized;
    }

    private function resolveClientIp(): string
    {
        return (string) ($_SERVER['REMOTE_ADDR'] ?? 'cli');
    }

    private function resolveUserAgentHash(): string
    {
        $ua = (string) ($_SERVER['HTTP_USER_AGENT'] ?? '');
        return $ua === '' ? '' : substr(hash('sha256', $ua), 0, 16);
    }
}

