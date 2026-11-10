<?php
declare(strict_types=1);

namespace CyberKovai\Security;

use InvalidArgumentException;
use RuntimeException;

/**
 * Authenticated encryption (AES-256-GCM) for persistent TOTP secrets.
 */
class CryptoService
{
    private const CIPHER = 'aes-256-gcm';
    private const VERSION = 'v1';
    private const IV_LENGTH = 12;
    private const TAG_LENGTH = 16;

    private string $key;

    public function __construct(?string $encodedKey = null)
    {
        if (!extension_loaded('openssl')) {
            throw new RuntimeException('The OpenSSL PHP extension is required for 2FA secret encryption.');
        }

        $raw = $encodedKey;
        if ($raw === null || trim($raw) === '') {
            $raw = function_exists('env')
                ? (string) (env('CK_APP_KEY') ?: env('APP_KEY') ?: '')
                : (string) (getenv('CK_APP_KEY') ?: getenv('APP_KEY') ?: '');
        }

        $this->key = $this->parseKey($raw);
    }

    /**
     * Check whether an encryption key is configured without throwing.
     */
    public static function isConfigured(?string $encodedKey = null): bool
    {
        try {
            new self($encodedKey);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Encrypt plaintext using AES-256-GCM with optional Additional Authenticated Data (AAD).
     */
    public function encrypt(string $plaintext, string $aad = ''): string
    {
        $iv = random_bytes(self::IV_LENGTH);
        $tag = '';
        $ciphertext = openssl_encrypt(
            $plaintext,
            self::CIPHER,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            $aad,
            self::TAG_LENGTH
        );

        if ($ciphertext === false || strlen($tag) !== self::TAG_LENGTH) {
            throw new RuntimeException('Failed to encrypt sensitive 2FA secret.');
        }

        return implode(':', [
            self::VERSION,
            base64_encode($iv),
            base64_encode($tag),
            base64_encode($ciphertext),
        ]);
    }

    /**
     * Decrypt an authenticated AES-256-GCM payload and verify AAD.
     */
    public function decrypt(string $payload, string $aad = ''): string
    {
        $parts = explode(':', $payload);
        if (count($parts) !== 4 || $parts[0] !== self::VERSION) {
            throw new RuntimeException('Invalid encrypted 2FA payload format.');
        }

        $iv = base64_decode($parts[1], true);
        $tag = base64_decode($parts[2], true);
        $ciphertext = base64_decode($parts[3], true);

        if (
            $iv === false ||
            $tag === false ||
            $ciphertext === false ||
            strlen($iv) !== self::IV_LENGTH ||
            strlen($tag) !== self::TAG_LENGTH
        ) {
            throw new RuntimeException('Malformed encrypted 2FA payload components.');
        }

        $plaintext = openssl_decrypt(
            $ciphertext,
            self::CIPHER,
            $this->key,
            OPENSSL_RAW_DATA,
            $iv,
            $tag,
            $aad
        );

        if ($plaintext === false) {
            throw new RuntimeException('Failed to decrypt or authenticate 2FA secret.');
        }

        return $plaintext;
    }

    private function parseKey(string $raw): string
    {
        $raw = trim($raw);
        if ($raw === '') {
            throw new InvalidArgumentException('CK_APP_KEY is not configured. Generate a 256-bit key in .env.');
        }

        if (strpos($raw, 'base64:') === 0) {
            $decoded = base64_decode(substr($raw, 7), true);
            if ($decoded === false || strlen($decoded) !== 32) {
                throw new InvalidArgumentException('CK_APP_KEY base64 value must decode to exactly 32 bytes.');
            }
            return $decoded;
        }

        if (preg_match('/^[0-9a-fA-F]{64}$/', $raw) === 1) {
            $decoded = hex2bin($raw);
            if ($decoded !== false && strlen($decoded) === 32) {
                return $decoded;
            }
        }

        throw new InvalidArgumentException('CK_APP_KEY must be a 32-byte key formatted as base64:... or 64 hex chars.');
    }
}

