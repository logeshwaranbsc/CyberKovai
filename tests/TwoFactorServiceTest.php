<?php
declare(strict_types=1);

namespace CyberKovai\Tests;

use CyberKovai\Security\AuditLogger;
use CyberKovai\Security\CorruptedStorageException;
use CyberKovai\Security\CryptoService;
use CyberKovai\Security\RateLimiter;
use CyberKovai\Security\TwoFactorService;
use CyberKovai\Security\TwoFactorStorage;
use PHPUnit\Framework\TestCase;
use PragmaRX\Google2FA\Google2FA;
use RuntimeException;

class TwoFactorServiceTest extends TestCase
{
    private string $tempDir;
    private CryptoService $crypto;
    private TwoFactorStorage $storage;
    private AuditLogger $logger;
    private TwoFactorService $service;
    private Google2FA $g2fa;

    /** @var array<string, string> */
    private array $testAdmin = [
        'username' => 'test_admin@example.test',
        'email'    => 'test_admin@example.test',
        'name'     => 'Test Admin',
        'role'     => 'superadmin',
    ];

    protected function setUp(): void
    {
        parent::setUp();
        $this->tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ck_2fa_unit_' . bin2hex(random_bytes(6));
        mkdir($this->tempDir, 0700, true);

        $testKey = 'base64:' . base64_encode(hash('sha256', 'deterministic-unit-test-key-v1', true));
        $this->crypto  = new CryptoService($testKey);
        $this->storage = new TwoFactorStorage($this->tempDir);
        $this->logger  = new AuditLogger($this->tempDir);
        $this->g2fa    = new Google2FA();
        $this->service = new TwoFactorService($this->storage, $this->crypto, $this->logger, $this->g2fa, 'Cyber Kovai Test', 1);

        $_SESSION = [];
    }

    protected function tearDown(): void
    {
        $_SESSION = [];
        $this->removeDirectory($this->tempDir);
        parent::tearDown();
    }

    public function testCryptoRoundTripAndAadTamperRejection(): void
    {
        $secret = 'JBSWY3DPEHPK3PXPJBSWY3DPEHPK3PXP';
        $encrypted = $this->crypto->encrypt($secret, 'admin_a');

        $this->assertStringStartsWith('v1:', $encrypted);
        $this->assertStringNotContainsString($secret, $encrypted);
        $this->assertSame($secret, $this->crypto->decrypt($encrypted, 'admin_a'));

        $this->expectException(RuntimeException::class);
        $this->crypto->decrypt($encrypted, 'admin_b');
    }

    public function testAdminWithoutTwoFactorDoesNotRequireChallenge(): void
    {
        $this->assertFalse($this->service->requiresTwoFactor($this->testAdmin));
        ck_admin_complete_login($this->testAdmin, false);
        $this->assertTrue(ck_admin_is_logged_in($this->service));
    }

    public function testNormalUserRolesAreNotForcedOrAllowedTwoFactor(): void
    {
        foreach (['user', 'customer', 'student', 'employee', ''] as $role) {
            $nonAdmin = [
                'username' => 'normal_' . ($role ?: 'empty') . '@example.test',
                'role'     => $role,
            ];
            $this->assertFalse($this->service->requiresTwoFactor($nonAdmin));
            $this->assertFalse(TwoFactorService::isEligibleAdminRole($role));
        }

        $this->expectException(RuntimeException::class);
        $this->service->initiateSetup([
            'username' => 'student1',
            'role'     => 'student',
        ]);
    }

    public function testFailedSetupConfirmationDoesNotEnableTwoFactor(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $this->assertStringStartsWith('otpauth://totp/', $setup['provisioning_uri']);

        $svg = $this->service->renderQrSvg($setup['provisioning_uri']);
        $this->assertStringContainsString('<svg', $svg);

        $statusBefore = $this->service->getStatus($this->testAdmin['username']);
        $this->assertFalse($statusBefore['enabled']);
        $this->assertFalse($statusBefore['confirmed']);
        $this->assertTrue($statusBefore['pending_setup']);
        $this->assertFalse($this->service->requiresTwoFactor($this->testAdmin));

        $res = $this->service->confirmSetup($this->testAdmin, '000000', 1700000000);
        $this->assertFalse($res['success']);

        $statusAfterFail = $this->service->getStatus($this->testAdmin['username']);
        $this->assertFalse($statusAfterFail['enabled']);
        $this->assertFalse($this->service->requiresTwoFactor($this->testAdmin));
    }

    public function testSuccessfulSetupConfirmationLoginOtpReplayAndClockSkew(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $secret = $setup['secret_manual'];

        $t0 = 1700000000;
        $slice0 = (int) floor($t0 / 30);
        $otp0 = $this->g2fa->oathTotp($secret, $slice0);

        $confirm = $this->service->confirmSetup($this->testAdmin, $otp0, $t0);
        $this->assertTrue($confirm['success']);
        $this->assertTrue($this->service->requiresTwoFactor($this->testAdmin));

        $this->assertNull($this->service->getPendingProvisioningData($this->testAdmin));

        $rawStore = file_get_contents($this->storage->getStorePath());
        $this->assertIsString($rawStore);
        $this->assertStringNotContainsString($secret, $rawStore);

        // Replaying setup OTP inside same 30s window during login must be rejected
        $replayFromSetup = $this->service->verifyLoginOtp($this->testAdmin, $otp0, $t0 + 5);
        $this->assertFalse($replayFromSetup['success']);
        $this->assertSame('replay', $replayFromSetup['reason']);

        // Next 30s window succeeds
        $t1 = $t0 + 30;
        $otp1 = $this->g2fa->oathTotp($secret, $slice0 + 1);
        $verify1 = $this->service->verifyLoginOtp($this->testAdmin, $otp1, $t1);
        $this->assertTrue($verify1['success']);

        // Replaying otp1 inside the same time window must be rejected
        $replay1 = $this->service->verifyLoginOtp($this->testAdmin, $otp1, $t1 + 10);
        $this->assertFalse($replay1['success']);
        $this->assertSame('replay', $replay1['reason']);

        // Clock skew (+1 step ahead within configured window=1) works
        $t2 = $t1 + 30;
        $otpFuture = $this->g2fa->oathTotp($secret, $slice0 + 3);
        $verifySkew = $this->service->verifyLoginOtp($this->testAdmin, $otpFuture, $t2);
        $this->assertTrue($verifySkew['success']);

        // After slice0+3 is accepted, older slice0+2 is rejected (monotonic replay guard)
        $otpOlder = $this->g2fa->oathTotp($secret, $slice0 + 2);
        $olderAttempt = $this->service->verifyLoginOtp($this->testAdmin, $otpOlder, $t2);
        $this->assertFalse($olderAttempt['success']);
    }

    public function testDisableTwoFactorRequiresValidTotpVerification(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $t0 = 1700002000;
        $otp0 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t0 / 30));
        $this->service->confirmSetup($this->testAdmin, $otp0, $t0);

        // Invalid code fails
        $failDisable = $this->service->disableTwoFactor($this->testAdmin, '999999', $t0 + 30);
        $this->assertFalse($failDisable['success']);
        $this->assertTrue($this->service->requiresTwoFactor($this->testAdmin));

        // Replaying setup OTP inside same slice fails
        $replayDisable = $this->service->disableTwoFactor($this->testAdmin, $otp0, $t0 + 5);
        $this->assertFalse($replayDisable['success']);

        // Valid fresh OTP succeeds
        $t1 = $t0 + 60;
        $otp1 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t1 / 30));
        $okDisable = $this->service->disableTwoFactor($this->testAdmin, $otp1, $t1);
        $this->assertTrue($okDisable['success']);
        $this->assertFalse($this->service->requiresTwoFactor($this->testAdmin));
    }

    public function testPendingChallengeBlocksAdminAccessAndExpires(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $t0 = 1700003000;
        $otp0 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t0 / 30));
        $this->service->confirmSetup($this->testAdmin, $otp0, $t0);

        $challenge = ck_admin_start_2fa_challenge($this->testAdmin, $t0);
        $this->assertNotEmpty($challenge['challenge_id']);

        $this->assertFalse(ck_admin_is_logged_in($this->service));
        $this->assertNull(ck_admin_current_user());

        $_SESSION['ck_admin_user'] = ['username' => $this->testAdmin['username'], 'role' => 'superadmin', 'auth_complete' => true];
        $this->assertFalse(ck_admin_is_logged_in($this->service));
        unset($_SESSION['ck_admin_user']);

        $this->assertNotNull(ck_admin_get_pending_2fa_challenge($t0 + 120));
        $this->assertNull(ck_admin_get_pending_2fa_challenge($t0 + 305));
        $this->assertArrayNotHasKey('ck_2fa_pending', $_SESSION);
    }

    public function testCorruptedStorageFailsClosed(): void
    {
        file_put_contents($this->storage->getStorePath(), '{corrupted-json');

        $this->expectException(CorruptedStorageException::class);
        $this->service->requiresTwoFactor($this->testAdmin);
    }

    public function testTamperedEncryptedSecretFailsClosed(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $t0 = 1700004000;
        $otp0 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t0 / 30));
        $this->service->confirmSetup($this->testAdmin, $otp0, $t0);

        $data = json_decode((string) file_get_contents($this->storage->getStorePath()), true);
        $data['records'][$this->testAdmin['username']]['secret_encrypted'] = 'v1:AAAAAAAAAAAAAAAA:AAAAAAAAAAAAAAAAAAAAAA==:AAAA';
        file_put_contents($this->storage->getStorePath(), json_encode($data));

        $this->expectException(CorruptedStorageException::class);
        $this->service->requiresTwoFactor($this->testAdmin);
    }

    public function testRateLimiterTriggersAndResetsOnClear(): void
    {
        $limiter = new RateLimiter($this->tempDir);
        $bucket = 'otp_test_bucket';
        $t = 1700005000;

        for ($i = 0; $i < 5; $i++) {
            $status = $limiter->check($bucket, 5, 300, $t + $i);
            $this->assertFalse($status['limited']);
            $limiter->hit($bucket, 5, 300, $t + $i);
        }

        $blocked = $limiter->check($bucket, 5, 300, $t + 10);
        $this->assertTrue($blocked['limited']);
        $this->assertGreaterThan(0, $blocked['retry_after']);

        $expired = $limiter->check($bucket, 5, 300, $t + 305);
        $this->assertFalse($expired['limited']);

        $limiter->hit($bucket, 5, 300, $t + 310);
        $limiter->clear($bucket);
        $afterClear = $limiter->check($bucket, 5, 300, $t + 311);
        $this->assertSame(0, $afterClear['attempts']);
    }

    public function testUsernameMigrationPreservesEncryptedTwoFactorSecret(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $t0 = 1700007000;
        $otp0 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t0 / 30));
        $this->service->confirmSetup($this->testAdmin, $otp0, $t0);

        $newAdmin = $this->testAdmin;
        $newAdmin['username'] = 'renamed_admin@example.test';
        $this->storage->migrateAdminIdentifier($this->testAdmin['username'], $newAdmin['username'], $this->crypto);

        $this->assertFalse($this->service->requiresTwoFactor($this->testAdmin));
        $this->assertTrue($this->service->requiresTwoFactor($newAdmin));

        $t1 = $t0 + 30;
        $otp1 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t1 / 30));
        $verify = $this->service->verifyLoginOtp($newAdmin, $otp1, $t1);
        $this->assertTrue($verify['success']);
    }

    public function testAuditLogNeverRecordsPlaintextSecretsOrOtps(): void
    {
        $setup = $this->service->initiateSetup($this->testAdmin);
        $t0 = 1700006000;
        $otp0 = $this->g2fa->oathTotp($setup['secret_manual'], (int) floor($t0 / 30));
        $this->service->confirmSetup($this->testAdmin, $otp0, $t0);

        $this->logger->log('custom_test', $this->testAdmin['username'], [
            'password'  => 'SuperSecretPass123!',
            'otp'       => $otp0,
            'secret'    => $setup['secret_manual'],
            'safe_note' => 'ok',
        ]);

        $logContent = (string) file_get_contents($this->logger->getLogPath());
        $this->assertStringContainsString('2fa_setup_initiated', $logContent);
        $this->assertStringContainsString('2fa_setup_confirmed', $logContent);
        $this->assertStringNotContainsString($setup['secret_manual'], $logContent);
        $this->assertStringNotContainsString($otp0, $logContent);
        $this->assertStringNotContainsString('SuperSecretPass123!', $logContent);
        $this->assertStringContainsString('[REDACTED]', $logContent);
    }

    public function testSecurityAutoloaderAndTotpWorkWithoutVendorDirectory(): void
    {
        $sandboxDir = $this->tempDir . DIRECTORY_SEPARATOR . 'novendor';
        $secCodeDir = $sandboxDir . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'Security';
        $dataDir    = $sandboxDir . DIRECTORY_SEPARATOR . 'data';
        $storeDir   = $sandboxDir . DIRECTORY_SEPARATOR . 'sec_store';
        mkdir($secCodeDir, 0755, true);
        mkdir($dataDir, 0755, true);
        mkdir($storeDir, 0700, true);

        copy(__DIR__ . '/../includes/env.php', $sandboxDir . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'env.php');
        foreach (glob(__DIR__ . '/../includes/Security/*.php') ?: [] as $srcFile) {
            copy($srcFile, $secCodeDir . DIRECTORY_SEPARATOR . basename($srcFile));
        }

        $t0 = 1700008000;
        $testKey = 'base64:' . base64_encode(hash('sha256', 'no-vendor-test-key', true));
        $probeScript = $sandboxDir . DIRECTORY_SEPARATOR . 'probe.php';
        $script = sprintf(
            <<<'PHP'
<?php
putenv('CK_APP_KEY=' . %s);
putenv('CK_SECURE_STORAGE_DIR=' . %s);
require %s;

$limiter = new \CyberKovai\Security\RateLimiter();
$status = $limiter->check('ip:127.0.0.1', 5, 300);
$logger = new \CyberKovai\Security\AuditLogger();
$logger->log('no_vendor_probe', 'admin@example.test');
$svc = new \CyberKovai\Security\TwoFactorService();
$admin = ['username' => 'admin@example.test', 'email' => 'admin@example.test', 'role' => 'superadmin'];
$before = $svc->requiresTwoFactor($admin);
$setup = $svc->initiateSetup($admin);

echo json_encode([
    'google2fa_loaded' => class_exists(\PragmaRX\Google2FA\Google2FA::class),
    'allowed' => $status['allowed'],
    'requires_before' => $before,
    'secret' => $setup['secret_manual'],
    'uri' => $setup['provisioning_uri'],
]);
PHP,
            var_export($testKey, true),
            var_export($storeDir, true),
            var_export($sandboxDir . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'env.php', true)
        );
        file_put_contents($probeScript, $script);

        $proc = proc_open(
            [PHP_BINARY, $probeScript],
            [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes,
            $sandboxDir,
            null,
            ['bypass_shell' => true]
        );
        $this->assertIsResource($proc);
        fclose($pipes[0]);
        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $code = proc_close($proc);

        $this->assertSame(0, $code, 'Subprocess failed: ' . $stderr);
        $payload = json_decode((string) $stdout, true);
        $this->assertIsArray($payload, 'Invalid output: ' . $stdout);
        $this->assertFalse($payload['google2fa_loaded']);
        $this->assertTrue($payload['allowed']);
        $this->assertFalse($payload['requires_before']);
        $this->assertSame(32, strlen($payload['secret']));
        $expectedIssuer = (string) (function_exists('env') ? (env('CK_2FA_ISSUER') ?: 'Cyber Kovai') : 'Cyber Kovai');
        $this->assertSame(
            $this->g2fa->getQRCodeUrl($expectedIssuer, 'admin@example.test', $payload['secret']),
            $payload['uri']
        );

        // Now confirm and verify OTP in the no-vendor subprocess using an OTP generated by Google2FA
        $otp0 = $this->g2fa->oathTotp($payload['secret'], (int) floor($t0 / 30));
        $otp1 = $this->g2fa->oathTotp($payload['secret'], (int) floor(($t0 + 30) / 30));
        $verifyScript = $sandboxDir . DIRECTORY_SEPARATOR . 'verify.php';
        $verifyBody = sprintf(
            <<<'PHP'
<?php
putenv('CK_APP_KEY=' . %s);
putenv('CK_SECURE_STORAGE_DIR=' . %s);
require %s;

$svc = new \CyberKovai\Security\TwoFactorService();
$admin = ['username' => 'admin@example.test', 'email' => 'admin@example.test', 'role' => 'superadmin'];
$confirm = $svc->confirmSetup($admin, %s, %d);
$reqAfter = $svc->requiresTwoFactor($admin);
$replay = $svc->verifyLoginOtp($admin, %s, %d + 5);
$next = $svc->verifyLoginOtp($admin, %s, %d + 30);

echo json_encode([
    'confirm' => $confirm['success'] ?? false,
    'requires_after' => $reqAfter,
    'replay_reason' => $replay['reason'] ?? null,
    'next_ok' => $next['success'] ?? false,
]);
PHP,
            var_export($testKey, true),
            var_export($storeDir, true),
            var_export($sandboxDir . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'env.php', true),
            var_export($otp0, true),
            $t0,
            var_export($otp0, true),
            $t0,
            var_export($otp1, true),
            $t0
        );
        file_put_contents($verifyScript, $verifyBody);

        $proc2 = proc_open(
            [PHP_BINARY, $verifyScript],
            [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes2,
            $sandboxDir,
            null,
            ['bypass_shell' => true]
        );
        $this->assertIsResource($proc2);
        fclose($pipes2[0]);
        $stdout2 = stream_get_contents($pipes2[1]);
        $stderr2 = stream_get_contents($pipes2[2]);
        fclose($pipes2[1]);
        fclose($pipes2[2]);
        $code2 = proc_close($proc2);

        $this->assertSame(0, $code2, 'Verify subprocess failed: ' . $stderr2);
        $res2 = json_decode((string) $stdout2, true);
        $this->assertIsArray($res2, 'Invalid verify output: ' . $stdout2);
        $this->assertTrue($res2['confirm']);
        $this->assertTrue($res2['requires_after']);
        $this->assertSame('replay', $res2['replay_reason']);
        $this->assertTrue($res2['next_ok']);

        // Also test actual admin/login.php POST execution without vendor/
        $adminDir = $sandboxDir . DIRECTORY_SEPARATOR . 'admin';
        $adminIncDir = $adminDir . DIRECTORY_SEPARATOR . 'includes';
        mkdir($adminIncDir, 0755, true);
        mkdir($sandboxDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'assets', 0755, true);
        file_put_contents($sandboxDir . DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'admin.css', '');
        copy(__DIR__ . '/../includes/storage.php', $sandboxDir . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'storage.php');
        copy(__DIR__ . '/../admin/includes/auth.php', $adminIncDir . DIRECTORY_SEPARATOR . 'auth.php');
        copy(__DIR__ . '/../admin/login.php', $adminDir . DIRECTORY_SEPARATOR . 'login.php');

        $adminsFile = $dataDir . DIRECTORY_SEPARATOR . 'admins.json';
        file_put_contents($adminsFile, json_encode([
            'Kovaicyber@gmail.com' => [
                'username'      => 'Kovaicyber@gmail.com',
                'name'          => 'Cyber Kovai Administrator',
                'email'         => 'Kovaicyber@gmail.com',
                'password_hash' => password_hash('SecretPass#2026!', PASSWORD_DEFAULT),
                'role'          => 'superadmin',
            ],
        ], JSON_PRETTY_PRINT));

        $loginProbe = $sandboxDir . DIRECTORY_SEPARATOR . 'login_probe.php';
        $loginProbeBody = sprintf(
            <<<'PHP'
<?php
putenv('CK_DATA_DIR=' . %s);
putenv('CK_SECURE_STORAGE_DIR=' . %s);
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SESSION['ck_csrf_token'] = 'test-csrf-token';
$_POST = [
    'csrf_token' => 'test-csrf-token',
    'username'   => 'Kovaicyber@gmail.com',
    'password'   => 'WrongPassword!',
];
require %s;
PHP,
            var_export($dataDir, true),
            var_export($storeDir, true),
            var_export($adminDir . DIRECTORY_SEPARATOR . 'login.php', true)
        );
        file_put_contents($loginProbe, $loginProbeBody);

        $proc3 = proc_open(
            [PHP_BINARY, $loginProbe],
            [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes3,
            $adminDir,
            null,
            ['bypass_shell' => true]
        );
        $this->assertIsResource($proc3);
        fclose($pipes3[0]);
        $stdout3 = stream_get_contents($pipes3[1]);
        $stderr3 = stream_get_contents($pipes3[2]);
        fclose($pipes3[1]);
        fclose($pipes3[2]);
        $code3 = proc_close($proc3);

        $this->assertSame(0, $code3, 'Login probe failed: ' . $stderr3);
        $this->assertStringContainsString('Invalid credentials. Access denied.', (string) $stdout3);

        // Test valid password login POST without vendor/
        $loginSuccessProbe = $sandboxDir . DIRECTORY_SEPARATOR . 'login_success_probe.php';
        $loginSuccessBody = sprintf(
            <<<'PHP'
<?php
putenv('CK_DATA_DIR=' . %s);
putenv('CK_SECURE_STORAGE_DIR=' . %s);
$_SERVER['REQUEST_METHOD'] = 'POST';
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';
$_SESSION['ck_csrf_token'] = 'test-csrf-token-2';
$_POST = [
    'csrf_token' => 'test-csrf-token-2',
    'username'   => 'Kovaicyber@gmail.com',
    'password'   => 'SecretPass#2026!',
];
register_shutdown_function(static function (): void {
    echo json_encode([
        'logged_in' => function_exists('ck_admin_is_logged_in') ? ck_admin_is_logged_in() : false,
        'user'      => $_SESSION['ck_admin_user']['username'] ?? null,
    ]);
});
require %s;
PHP,
            var_export($dataDir, true),
            var_export($storeDir, true),
            var_export($adminDir . DIRECTORY_SEPARATOR . 'login.php', true)
        );
        file_put_contents($loginSuccessProbe, $loginSuccessBody);

        $proc4 = proc_open(
            [PHP_BINARY, $loginSuccessProbe],
            [0 => ['pipe', 'r'], 1 => ['pipe', 'w'], 2 => ['pipe', 'w']],
            $pipes4,
            $adminDir,
            null,
            ['bypass_shell' => true]
        );
        $this->assertIsResource($proc4);
        fclose($pipes4[0]);
        $stdout4 = stream_get_contents($pipes4[1]);
        $stderr4 = stream_get_contents($pipes4[2]);
        fclose($pipes4[1]);
        fclose($pipes4[2]);
        $code4 = proc_close($proc4);

        $this->assertSame(0, $code4, 'Login success probe failed: ' . $stderr4);
        $loginPayload = json_decode((string) $stdout4, true);
        $this->assertIsArray($loginPayload, 'Invalid login success output: ' . $stdout4);
        $this->assertTrue($loginPayload['logged_in']);
        $this->assertSame('Kovaicyber@gmail.com', $loginPayload['user']);
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
