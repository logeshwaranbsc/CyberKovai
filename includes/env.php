<?php
/**
 * Cyber Kovai - Environment & Autoload Bootstrap
 * Loads .env variables, defines env() helper, and registers Composer autoloading.
 */

if (!function_exists('loadEnv')) {
    function loadEnv($path = __DIR__ . '/../.env') {
        if (!file_exists($path)) {
            return false;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($lines === false) {
            return false;
        }
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);
                $len = strlen($val);
                if ($len >= 2 && (($val[0] === '"' && $val[$len - 1] === '"') || ($val[0] === "'" && $val[$len - 1] === "'"))) {
                    $val = substr($val, 1, -1);
                }
                if (getenv($key) === false) {
                    putenv("{$key}={$val}");
                }
                if (!isset($_ENV[$key])) {
                    $_ENV[$key] = $val;
                }
                if (!isset($_SERVER[$key])) {
                    $_SERVER[$key] = $val;
                }
            }
        }
        return true;
    }
}

loadEnv(__DIR__ . '/../.env');

if (!function_exists('env')) {
    function env($key, $default = null) {
        $val = getenv($key);
        if ($val !== false) {
            return $val;
        }
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
}

$ckAutoloader = __DIR__ . '/../vendor/autoload.php';
if (file_exists($ckAutoloader)) {
    require_once $ckAutoloader;
}

