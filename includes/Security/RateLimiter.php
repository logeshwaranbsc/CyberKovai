<?php
declare(strict_types=1);

namespace CyberKovai\Security;

use RuntimeException;

/**
 * File-backed sliding-window rate limiter using exclusive locks and atomic writes.
 */
class RateLimiter
{
    private string $dataPath;
    private string $lockPath;
    private bool $explicitDir;
    private bool $degraded = false;

    public function __construct(?string $storageDir = null)
    {
        $dir = TwoFactorStorage::resolveStorageDirectory($storageDir);
        $this->explicitDir = $storageDir !== null && trim($storageDir) !== '';

        try {
            TwoFactorStorage::ensureDirectory($dir);
            if (!$this->explicitDir) {
                $probeFp = @fopen($dir . DIRECTORY_SEPARATOR . 'rate_limits.lock', 'c+b');
                if ($probeFp === false) {
                    throw new RuntimeException('Primary rate-limit lock file is not writable.');
                }
                fclose($probeFp);
            }
        } catch (RuntimeException $e) {
            if ($this->explicitDir) {
                throw $e;
            }
            $fallbackDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ck_ratelimit_' . substr(hash('sha256', dirname(__DIR__, 2)), 0, 12);
            try {
                TwoFactorStorage::ensureDirectory($fallbackDir);
                $probeFp = @fopen($fallbackDir . DIRECTORY_SEPARATOR . 'rate_limits.lock', 'c+b');
                if ($probeFp === false) {
                    throw new RuntimeException('Fallback rate-limit lock file is not writable.');
                }
                fclose($probeFp);
                $dir = $fallbackDir;
                error_log('CyberKovai RateLimiter fell back to temp dir: ' . $e->getMessage());
            } catch (RuntimeException $fallbackErr) {
                $this->degraded = true;
                error_log('CyberKovai RateLimiter storage unavailable, running degraded: ' . $fallbackErr->getMessage());
            }
        }

        $this->dataPath = $dir . DIRECTORY_SEPARATOR . 'rate_limits.json';
        $this->lockPath = $dir . DIRECTORY_SEPARATOR . 'rate_limits.lock';
    }

    /**
     * Inspect current limit status without recording an attempt.
     *
     * @return array{allowed: bool, limited: bool, attempts: int, remaining: int, retry_after: int}
     */
    public function check(string $bucketKey, int $maxAttempts, int $windowSeconds, ?int $now = null): array
    {
        $now = $now ?? time();
        if ($this->degraded) {
            return $this->buildStatus([], $maxAttempts, $windowSeconds, $now);
        }
        $hashed = hash('sha256', $bucketKey);

        return $this->withLock(function () use ($hashed, $maxAttempts, $windowSeconds, $now): array {
            $store = $this->readStore();
            $attempts = $this->pruneTimestamps($store[$hashed] ?? [], $windowSeconds, $now);
            return $this->buildStatus($attempts, $maxAttempts, $windowSeconds, $now);
        }, $this->buildStatus([], $maxAttempts, $windowSeconds, $now));
    }

    /**
     * Record a failed attempt and return the updated limit status.
     *
     * @return array{allowed: bool, limited: bool, attempts: int, remaining: int, retry_after: int}
     */
    public function hit(string $bucketKey, int $maxAttempts, int $windowSeconds, ?int $now = null): array
    {
        $now = $now ?? time();
        if ($this->degraded) {
            return $this->buildStatus([], $maxAttempts, $windowSeconds, $now);
        }
        $hashed = hash('sha256', $bucketKey);

        return $this->withLock(function () use ($hashed, $maxAttempts, $windowSeconds, $now): array {
            $store = $this->readStore();
            $store = $this->pruneAllBuckets($store, max($windowSeconds, 3600), $now);

            $attempts = $this->pruneTimestamps($store[$hashed] ?? [], $windowSeconds, $now);
            $attempts[] = $now;
            $store[$hashed] = $attempts;

            $this->writeStore($store);

            return $this->buildStatus($attempts, $maxAttempts, $windowSeconds, $now);
        }, $this->buildStatus([], $maxAttempts, $windowSeconds, $now));
    }

    /**
     * Clear recorded attempts for a bucket after successful authentication.
     */
    public function clear(string $bucketKey): void
    {
        if ($this->degraded) {
            return;
        }
        $hashed = hash('sha256', $bucketKey);

        $this->withLock(function () use ($hashed): void {
            $store = $this->readStore();
            if (isset($store[$hashed])) {
                unset($store[$hashed]);
                $this->writeStore($store);
            }
        }, null);
    }

    /**
     * @template T
     * @param callable(): T $callback
     * @param T $fallbackResult
     * @return T
     */
    private function withLock(callable $callback, $fallbackResult = null)
    {
        $lockFp = @fopen($this->lockPath, 'c+b');
        if ($lockFp === false) {
            if (!$this->explicitDir) {
                $this->degraded = true;
                error_log('CyberKovai RateLimiter unable to open lock file, running degraded.');
                return $fallbackResult;
            }
            throw new RuntimeException('Unable to open rate-limit lock file.');
        }

        try {
            if (!flock($lockFp, LOCK_EX)) {
                if (!$this->explicitDir) {
                    $this->degraded = true;
                    error_log('CyberKovai RateLimiter unable to acquire flock, running degraded.');
                    return $fallbackResult;
                }
                throw new RuntimeException('Unable to acquire rate-limit lock.');
            }
            @chmod($this->lockPath, 0600);
            return $callback();
        } finally {
            flock($lockFp, LOCK_UN);
            fclose($lockFp);
        }
    }

    /**
     * @return array<string, array<int, int>>
     */
    private function readStore(): array
    {
        if (!file_exists($this->dataPath)) {
            return [];
        }
        $raw = @file_get_contents($this->dataPath);
        if ($raw === false || trim($raw) === '') {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param array<string, array<int, int>> $store
     */
    private function writeStore(array $store): void
    {
        $json = json_encode($store, JSON_PRETTY_PRINT);
        if ($json === false) {
            return;
        }
        TwoFactorStorage::atomicWriteFile($this->dataPath, $json);
    }

    /**
     * @param array<int, mixed> $timestamps
     * @return array<int, int>
     */
    private function pruneTimestamps(array $timestamps, int $windowSeconds, int $now): array
    {
        $cutoff = $now - $windowSeconds;
        $valid = [];
        foreach ($timestamps as $ts) {
            $intTs = (int) $ts;
            if ($intTs > $cutoff && $intTs <= $now + 60) {
                $valid[] = $intTs;
            }
        }
        sort($valid);
        return $valid;
    }

    /**
     * @param array<string, mixed> $store
     * @return array<string, array<int, int>>
     */
    private function pruneAllBuckets(array $store, int $maxAgeSeconds, int $now): array
    {
        $cleaned = [];
        foreach ($store as $key => $timestamps) {
            if (!is_array($timestamps)) {
                continue;
            }
            $kept = $this->pruneTimestamps($timestamps, $maxAgeSeconds, $now);
            if (!empty($kept)) {
                $cleaned[(string) $key] = $kept;
            }
        }
        return $cleaned;
    }

    /**
     * @param array<int, int> $attempts
     * @return array{allowed: bool, limited: bool, attempts: int, remaining: int, retry_after: int}
     */
    private function buildStatus(array $attempts, int $maxAttempts, int $windowSeconds, int $now): array
    {
        $count = count($attempts);
        $limited = $count >= $maxAttempts;
        $retryAfter = 0;

        if ($limited && !empty($attempts)) {
            $oldest = $attempts[0];
            $retryAfter = max(1, ($oldest + $windowSeconds) - $now);
        }

        return [
            'allowed'     => !$limited,
            'limited'     => $limited,
            'attempts'    => $count,
            'remaining'   => max(0, $maxAttempts - $count),
            'retry_after' => $retryAfter,
        ];
    }
}

