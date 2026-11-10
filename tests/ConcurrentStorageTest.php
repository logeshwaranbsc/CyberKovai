<?php
declare(strict_types=1);

namespace CyberKovai\Tests;

use CyberKovai\Security\AuditLogger;
use CyberKovai\Security\CryptoService;
use CyberKovai\Security\TwoFactorService;
use CyberKovai\Security\TwoFactorStorage;
use PHPUnit\Framework\TestCase;
use PragmaRX\Google2FA\Google2FA;

class ConcurrentStorageTest extends TestCase
{
    private string $tempDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ck_2fa_conc_' . bin2hex(random_bytes(6));
        mkdir($this->tempDir, 0700, true);
    }

    protected function tearDown(): void
    {
        $this->removeDirectory($this->tempDir);
        parent::tearDown();
    }

    public function testConcurrentSameStepOtpVerificationAllowsOnlySingleSuccess(): void
    {
        $testKey = 'base64:' . base64_encode(hash('sha256', 'concurrent-test-key-v1', true));
        $crypto = new CryptoService($testKey);
        $storage = new TwoFactorStorage($this->tempDir);
        $logger = new AuditLogger($this->tempDir);
        $g2fa = new Google2FA();
        $service = new TwoFactorService($storage, $crypto, $logger, $g2fa, 'Cyber Kovai Test', 1);

        $admin = [
            'username' => 'concurrent_admin@example.test',
            'email'    => 'concurrent_admin@example.test',
            'role'     => 'superadmin',
        ];

        $setup = $service->initiateSetup($admin);
        $t0 = 1700010000;
        $otp0 = $g2fa->oathTotp($setup['secret_manual'], (int) floor($t0 / 30));
        $service->confirmSetup($admin, $otp0, $t0);

        // Next 30s time step OTP
        $t1 = $t0 + 30;
        $otp1 = $g2fa->oathTotp($setup['secret_manual'], (int) floor($t1 / 30));

        $workerScript = $this->tempDir . DIRECTORY_SEPARATOR . 'worker.php';
        $autoloadPath = realpath(__DIR__ . '/../vendor/autoload.php');
        $scriptBody = sprintf(
            "<?php\nrequire %s;\nputenv('CK_APP_KEY=' . %s);\nputenv('CK_SECURE_STORAGE_DIR=' . %s);\n\$svc = new \\CyberKovai\\Security\\TwoFactorService();\n\$res = \$svc->verifyLoginOtp(['username' => %s, 'role' => 'superadmin'], %s, %d);\necho json_encode(\$res);\n",
            var_export($autoloadPath, true),
            var_export($testKey, true),
            var_export($this->tempDir, true),
            var_export($admin['username'], true),
            var_export($otp1, true),
            $t1
        );
        file_put_contents($workerScript, $scriptBody);

        $workers = 5;
        $procs = [];
        $pipesList = [];
        $cmd = [PHP_BINARY, $workerScript];

        for ($i = 0; $i < $workers; $i++) {
            $descriptors = [
                0 => ['pipe', 'r'],
                1 => ['pipe', 'w'],
                2 => ['pipe', 'w'],
            ];
            $proc = proc_open($cmd, $descriptors, $pipes, dirname(__DIR__), null, ['bypass_shell' => true]);
            $this->assertIsResource($proc);
            fclose($pipes[0]);
            $procs[] = $proc;
            $pipesList[] = $pipes;
        }

        $successCount = 0;
        $failureCount = 0;

        foreach ($procs as $idx => $proc) {
            $stdout = stream_get_contents($pipesList[$idx][1]);
            $stderr = stream_get_contents($pipesList[$idx][2]);
            fclose($pipesList[$idx][1]);
            fclose($pipesList[$idx][2]);
            $exitCode = proc_close($proc);

            $this->assertSame(0, $exitCode, 'Worker stderr: ' . $stderr);
            $decoded = json_decode((string) $stdout, true);
            $this->assertIsArray($decoded, 'Invalid worker JSON: ' . $stdout);

            if (!empty($decoded['success'])) {
                $successCount++;
            } else {
                $failureCount++;
            }
        }

        $this->assertSame(1, $successCount, 'Exactly 1 concurrent worker may accept the OTP for a given 30s step.');
        $this->assertSame($workers - 1, $failureCount);

        $storage->validateIntegrity();
        $record = $storage->getRecord($admin['username']);
        $this->assertSame((int) floor($t1 / 30), $record['last_totp_timeslice']);
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) {
            return;
        }
        $it = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($it as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($dir);
    }
}
