<?php
declare(strict_types=1);

$testBase = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'cyberkovai_test_boot_' . getmypid();
if (!is_dir($testBase . DIRECTORY_SEPARATOR . 'data')) {
    @mkdir($testBase . DIRECTORY_SEPARATOR . 'data', 0755, true);
}
if (!is_dir($testBase . DIRECTORY_SEPARATOR . 'sec')) {
    @mkdir($testBase . DIRECTORY_SEPARATOR . 'sec', 0700, true);
}

register_shutdown_function(static function () use ($testBase): void {
    if (!is_dir($testBase)) {
        return;
    }
    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($testBase, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );
    foreach ($it as $file) {
        $file->isDir() ? @rmdir($file->getPathname()) : @unlink($file->getPathname());
    }
    @rmdir($testBase);
});

$testKey = 'base64:' . base64_encode(hash('sha256', 'cyberkovai-unit-test-key-material', true));
putenv('CK_APP_KEY=' . $testKey);
putenv('CK_DATA_DIR=' . $testBase . DIRECTORY_SEPARATOR . 'data');
putenv('CK_SECURE_STORAGE_DIR=' . $testBase . DIRECTORY_SEPARATOR . 'sec');
putenv('CK_2FA_ISSUER=Cyber Kovai Test');
putenv('CK_2FA_WINDOW=1');
putenv('CK_2FA_CHALLENGE_TTL=300');

require_once __DIR__ . '/../includes/env.php';
require_once __DIR__ . '/../includes/storage.php';
require_once __DIR__ . '/../admin/includes/auth.php';
