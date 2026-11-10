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
