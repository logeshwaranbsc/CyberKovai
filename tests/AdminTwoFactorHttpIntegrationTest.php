<?php
declare(strict_types=1);

namespace CyberKovai\Tests;

use PHPUnit\Framework\TestCase;
use PragmaRX\Google2FA\Google2FA;

/**
 * End-to-end HTTP integration tests against an isolated PHP built-in server
 * using temporary data/ and storage/security/ directories.
 */
class AdminTwoFactorHttpIntegrationTest extends TestCase
{
    private string $tempRoot;
    private string $dataDir;
    private string $secDir;
    private string $cookieJar;
    private string $baseUrl;
    /** @var resource|null */
    private $serverProc = null;
    private string $testAdminUser = 'testadmin@example.test';
    private string $testAdminPass = 'TestPass#2026!';
    private string $normalUser = 'normaluser@example.test';
    private string $normalUserPass = 'UserPass#2026!';

    protected function setUp(): void
    {
        parent::setUp();
        if (!extension_loaded('curl')) {
            $this->markTestSkipped('ext-curl is required for HTTP integration tests.');
        }

        $this->tempRoot  = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ck_http_int_' . bin2hex(random_bytes(6));
        $this->dataDir   = $this->tempRoot . DIRECTORY_SEPARATOR . 'data';
        $this->secDir    = $this->tempRoot . DIRECTORY_SEPARATOR . 'sec';
        $this->cookieJar = $this->tempRoot . DIRECTORY_SEPARATOR . 'cookies.txt';

        mkdir($this->dataDir, 0755, true);
        mkdir($this->secDir, 0700, true);

        $admins = [
            $this->testAdminUser => [
                'username'      => $this->testAdminUser,
                'name'          => 'Test Admin',
                'email'         => $this->testAdminUser,
                'password_hash' => password_hash($this->testAdminPass, PASSWORD_DEFAULT),
                'role'          => 'superadmin',
                'created_at'    => '2026-01-01 00:00:00',
            ],
            $this->normalUser => [
                'username'      => $this->normalUser,
                'name'          => 'Normal Employee',
                'email'         => $this->normalUser,
                'password_hash' => password_hash($this->normalUserPass, PASSWORD_DEFAULT),
                'role'          => 'employee',
                'created_at'    => '2026-01-01 00:00:00',
            ],
        ];
        file_put_contents($this->dataDir . DIRECTORY_SEPARATOR . 'admins.json', json_encode($admins, JSON_PRETTY_PRINT));

        $port = $this->findFreePort();
        $this->baseUrl = 'http://127.0.0.1:' . $port;

        $testKey = 'base64:' . base64_encode(hash('sha256', 'http-integration-test-key', true));
        $baseEnv = getenv();
        $env = array_merge(is_array($baseEnv) ? $baseEnv : [], [
            'CK_APP_KEY'            => $testKey,
            'CK_DATA_DIR'           => $this->dataDir,
            'CK_SECURE_STORAGE_DIR' => $this->secDir,
            'CK_2FA_ISSUER'         => 'Cyber Kovai Test',
            'CK_2FA_WINDOW'         => '1',
            'CK_2FA_CHALLENGE_TTL'  => '300',
        ]);
        $cleanEnv = [];
        foreach ($env as $k => $v) {
            if (is_string($k) && (is_string($v) || is_int($v))) {
                $cleanEnv[$k] = (string) $v;
            }
        }

        $docRoot = realpath(__DIR__ . '/..');
        $router = $docRoot . DIRECTORY_SEPARATOR . 'router.php';
        $cmd = [PHP_BINARY, '-S', '127.0.0.1:' . $port, '-t', $docRoot, $router];

        $descriptors = [
            0 => ['pipe', 'r'],
            1 => ['file', $this->tempRoot . DIRECTORY_SEPARATOR . 'server.out.log', 'a'],
            2 => ['file', $this->tempRoot . DIRECTORY_SEPARATOR . 'server.err.log', 'a'],
        ];

        $this->serverProc = proc_open($cmd, $descriptors, $pipes, $docRoot, $cleanEnv, ['bypass_shell' => true]);
        $this->assertIsResource($this->serverProc);
        fclose($pipes[0]);

        $ready = false;
        for ($i = 0; $i < 40; $i++) {
            $resp = @$this->httpGet('/admin/login.php');
            if ($resp['status'] === 200) {
                $ready = true;
                break;
            }
            usleep(100000);
        }
        $this->assertTrue($ready, 'Built-in test HTTP server did not start in time.');
    }

    protected function tearDown(): void
    {
        if (is_resource($this->serverProc)) {
            proc_terminate($this->serverProc);
            proc_close($this->serverProc);
            $this->serverProc = null;
        }
        $this->removeDirectory($this->tempRoot);
        parent::tearDown();
    }

    public function testSensitiveRoutesAndFilesAreBlockedOverHttp(): void
    {
        foreach (['/data/admins.json', '/.env', '/composer.json', '/storage/security/admin_2fa.json', '/assets/../.env'] as $path) {
            $resp = $this->httpGet($path);
            $this->assertSame(403, $resp['status'], "Expected 403 for {$path}, got {$resp['status']}");
        }

        $qrResp = $this->httpGet('/admin/two-factor-qr.php');
        $this->assertContains($qrResp['status'], [302, 401, 403]);
        $this->assertStringNotContainsString('<svg', $qrResp['body']);
    }

    public function testNonAdminRoleCannotAuthenticateOrAccessAdminTwoFactorSettings(): void
    {
        $loginPage = $this->httpGet('/admin/login.php');
        $csrf = $this->extractCsrf($loginPage['body']);

        $res = $this->httpPost('/admin/login.php', [
            'csrf_token' => $csrf,
            'username'   => $this->normalUser,
            'password'   => $this->normalUserPass,
        ]);

        $this->assertSame(200, $res['status']);
        $this->assertStringContainsString('Invalid credentials', $res['body']);
    }

    public function testFullEndToEndAdminTwoFactorSetupLoginOtpReplayAndDisableFlow(): void
    {
        // 1. Admin login without 2FA enabled succeeds directly & regenerates session ID
        $loginPage = $this->httpGet('/admin/login.php');
        $csrf1 = $this->extractCsrf($loginPage['body']);
        $sidBefore = $this->readCookieValue('PHPSESSID');

        $loginRes = $this->httpPost('/admin/login.php', [
            'csrf_token' => $csrf1,
            'username'   => $this->testAdminUser,
            'password'   => $this->testAdminPass,
        ]);
        $this->assertSame(302, $loginRes['status']);
        $this->assertStringContainsString('index.php', $loginRes['headers']['location'] ?? '');

        $sidAfterNo2fa = $this->readCookieValue('PHPSESSID');
        $this->assertNotSame($sidBefore, $sidAfterNo2fa, 'Session ID must regenerate on login.');

        // 2. Open admin/profile.php -> 2FA initially Disabled
        $profilePage = $this->httpGet('/admin/profile.php');
        $this->assertSame(200, $profilePage['status']);
        $this->assertStringContainsString('Disabled', $profilePage['body']);
        $this->assertStringNotContainsString('Recovery Code', $profilePage['body']);
        $csrfProfile = $this->extractCsrf($profilePage['body']);

        // 3. Initiate 2FA setup (requires current password)
        $initRes = $this->httpPost('/admin/profile.php', [
            'csrf_token'       => $csrfProfile,
            'action'           => '2fa_initiate',
            'current_password' => $this->testAdminPass,
        ]);
        $this->assertSame(302, $initRes['status']);

        $profilePending = $this->httpGet('/admin/profile.php');
        $this->assertSame(200, $profilePending['status']);
        $this->assertStringContainsString('Pending Confirmation', $profilePending['body']);
        $this->assertStringContainsString('two-factor-qr.php', $profilePending['body']);

        $this->assertSame(1, preg_match('/id="totpManualKey">([^<]+)</', $profilePending['body'], $m));
        $secret = preg_replace('/\s+/', '', html_entity_decode($m[1], ENT_QUOTES, 'UTF-8'));
        $this->assertNotEmpty($secret);

        $qrResp = $this->httpGet('/admin/two-factor-qr.php');
        $this->assertSame(200, $qrResp['status']);
        $this->assertStringContainsString('<svg', $qrResp['body']);
        $this->assertStringContainsString('no-store', $qrResp['headers']['cache-control'] ?? '');

        // 4. Failed setup confirmation does NOT enable 2FA
        $csrfSetup = $this->extractCsrf($profilePending['body']);
        $badConfirm = $this->httpPost('/admin/profile.php', [
            'csrf_token' => $csrfSetup,
            'action'     => '2fa_confirm',
            'otp_code'   => '000000',
        ]);
        $this->assertSame(302, $badConfirm['status']);

        $stillPending = $this->httpGet('/admin/profile.php');
        $this->assertStringContainsString('Pending Confirmation', $stillPending['body']);

        // 5. Valid OTP confirms setup cleanly (without recovery codes)
        $g2fa = new Google2FA();
        $setupSlice = $g2fa->getTimestamp();
        $validOtpSetup = $g2fa->oathTotp($secret, $setupSlice);
        $csrfConfirm2 = $this->extractCsrf($stillPending['body']);

        $goodConfirm = $this->httpPost('/admin/profile.php', [
            'csrf_token' => $csrfConfirm2,
            'action'     => '2fa_confirm',
            'otp_code'   => $validOtpSetup,
        ]);
        $this->assertSame(302, $goodConfirm['status']);

        $enabledProfile = $this->httpGet('/admin/profile.php');
        $this->assertStringContainsString('Active &amp; Enforced on Admin Login', $enabledProfile['body']);
        $this->assertStringNotContainsString('Recovery Code', $enabledProfile['body']);

        // 6. Logout & test 2FA login challenge flow
        $this->httpGet('/admin/logout.php');
        $freshLogin = $this->httpGet('/admin/login.php');
        $csrfLogin2 = $this->extractCsrf($freshLogin['body']);

        $stage1 = $this->httpPost('/admin/login.php', [
            'csrf_token' => $csrfLogin2,
            'username'   => $this->testAdminUser,
            'password'   => $this->testAdminPass,
        ]);
        $this->assertSame(302, $stage1['status']);
        $this->assertStringContainsString('verify-2fa.php', $stage1['headers']['location'] ?? '');

        // Critical: Admin routes MUST be inaccessible while challenge is pending
        foreach (['/admin/index.php', '/admin/profile.php', '/admin/settings.php', '/admin/two-factor-qr.php'] as $protectedPath) {
            $blocked = $this->httpGet($protectedPath);
            $this->assertSame(302, $blocked['status'], "Expected 302 redirect on {$protectedPath} while pending.");
            $this->assertStringContainsString('verify-2fa.php', $blocked['headers']['location'] ?? '');
        }

        // Stage 2 page renders Verify Your Identity without recovery code tabs
        $verifyPage = $this->httpGet('/admin/verify-2fa.php');
        $this->assertSame(200, $verifyPage['status']);
        $this->assertStringContainsString('Verify Your Identity', $verifyPage['body']);
        $this->assertStringNotContainsString('Recovery Code', $verifyPage['body']);
        $csrfChallenge = $this->extractCsrf($verifyPage['body']);

        // Replaying setup OTP inside same 30s step is rejected
        $replayRes = $this->httpPost('/admin/verify-2fa.php', [
            'csrf_token' => $csrfChallenge,
            'action'     => 'verify_otp',
            'otp_code'   => $validOtpSetup,
        ]);
        $this->assertSame(200, $replayRes['status']);
        $this->assertStringContainsString('Verification Failed', $replayRes['body']);

        // Cancel Challenge action returns safely to login.php
        $cancelRes = $this->httpPost('/admin/verify-2fa.php', [
            'csrf_token' => $this->extractCsrf($replayRes['body']),
            'action'     => 'cancel',
        ]);
        $this->assertSame(302, $cancelRes['status']);
        $this->assertStringContainsString('login.php', $cancelRes['headers']['location'] ?? '');

        // Re-login Stage 1 and test valid Stage 2 TOTP login (next slice within window=1)
        $login2b = $this->httpGet('/admin/login.php');
        $sidBeforeTotpLogin = $this->readCookieValue('PHPSESSID');
        $this->httpPost('/admin/login.php', [
            'csrf_token' => $this->extractCsrf($login2b['body']),
            'username'   => $this->testAdminUser,
            'password'   => $this->testAdminPass,
        ]);
        $verify2b = $this->httpGet('/admin/verify-2fa.php');
        $nextSliceOtp = $g2fa->oathTotp($secret, $setupSlice + 1);

        $totpLoginRes = $this->httpPost('/admin/verify-2fa.php', [
            'csrf_token' => $this->extractCsrf($verify2b['body']),
            'action'     => 'verify_otp',
            'otp_code'   => $nextSliceOtp,
        ]);
        $this->assertSame(302, $totpLoginRes['status']);
        $this->assertStringContainsString('index.php', $totpLoginRes['headers']['location'] ?? '');
        $this->assertNotSame($sidBeforeTotpLogin, $this->readCookieValue('PHPSESSID'));

        // Dashboard is now accessible
        $dash = $this->httpGet('/admin/index.php');
        $this->assertSame(200, $dash['status']);
        $this->assertStringContainsString('Security Operations Center Dashboard', $dash['body']);

        // Disable 2FA via password + OTP
        // Update stored last_totp_timeslice in isolated temp storage to setupSlice - 1 so current OTP can test disable immediately without sleeping 30s
        $storeFile = $this->secDir . DIRECTORY_SEPARATOR . 'admin_2fa.json';
        $storeJson = json_decode((string) file_get_contents($storeFile), true);
        $storeJson['records'][$this->testAdminUser]['last_totp_timeslice'] = $setupSlice - 1;
        file_put_contents($storeFile, json_encode($storeJson, JSON_PRETTY_PRINT));

        $profileEnabled = $this->httpGet('/admin/profile.php');
        $disableRes = $this->httpPost('/admin/profile.php', [
            'csrf_token'       => $this->extractCsrf($profileEnabled['body']),
            'action'           => '2fa_disable',
            'current_password' => $this->testAdminPass,
            'otp_code'         => $g2fa->oathTotp($secret, $setupSlice),
            'confirm_disable'  => '1',
        ]);
        $this->assertSame(302, $disableRes['status']);

        $profileDisabled = $this->httpGet('/admin/profile.php');
        $this->assertStringContainsString('Disabled', $profileDisabled['body']);

        // Verify login works without 2FA challenge again
        $this->httpGet('/admin/logout.php');
        $login4 = $this->httpGet('/admin/login.php');
        $directAfterDisable = $this->httpPost('/admin/login.php', [
            'csrf_token' => $this->extractCsrf($login4['body']),
            'username'   => $this->testAdminUser,
            'password'   => $this->testAdminPass,
        ]);
        $this->assertSame(302, $directAfterDisable['status']);
        $this->assertStringContainsString('index.php', $directAfterDisable['headers']['location'] ?? '');
    }

    public function testRateLimitsTriggerHttp429OnFailedLoginsAndOtpAttempts(): void
    {
        // 1. Login password brute force rate limit
        $loginPage = $this->httpGet('/admin/login.php');
        $csrf = $this->extractCsrf($loginPage['body']);

        for ($i = 0; $i < 5; $i++) {
            $res = $this->httpPost('/admin/login.php', [
                'csrf_token' => $csrf,
                'username'   => $this->testAdminUser,
                'password'   => 'WrongPassword' . $i,
            ]);
            $this->assertSame(200, $res['status']);
            $csrf = $this->extractCsrf($res['body']);
        }

        $limited = $this->httpPost('/admin/login.php', [
            'csrf_token' => $csrf,
            'username'   => $this->testAdminUser,
            'password'   => 'WrongPasswordFinal',
        ]);
        $this->assertSame(429, $limited['status']);
        $this->assertArrayHasKey('retry-after', $limited['headers']);

        // 2. OTP verification rate limit (429) on verify-2fa.php
        // Clear login limiter via valid wait/new admin or direct seed of 2FA record for testAdmin
        @unlink($this->secDir . DIRECTORY_SEPARATOR . 'rate_limits.json');
        $g2fa = new Google2FA();
        $secret = $g2fa->generateSecretKey(32);
        $crypto = new \CyberKovai\Security\CryptoService('base64:' . base64_encode(hash('sha256', 'http-integration-test-key', true)));
        $store = [
            'version' => 1,
            'records' => [
                $this->testAdminUser => [
                    'admin_id'            => $this->testAdminUser,
                    'secret_encrypted'    => $crypto->encrypt($secret, $this->testAdminUser),
                    'enabled'             => true,
                    'confirmed'           => true,
                    'confirmed_at'        => gmdate('c'),
                    'last_totp_timeslice' => $g2fa->getTimestamp() - 1,
                    'updated_at'          => gmdate('c'),
                ],
            ],
        ];
        file_put_contents($this->secDir . DIRECTORY_SEPARATOR . 'admin_2fa.json', json_encode($store));

        $freshLogin = $this->httpGet('/admin/login.php');
        $stage1 = $this->httpPost('/admin/login.php', [
            'csrf_token' => $this->extractCsrf($freshLogin['body']),
            'username'   => $this->testAdminUser,
            'password'   => $this->testAdminPass,
        ]);
        $this->assertSame(302, $stage1['status']);

        $verifyPage = $this->httpGet('/admin/verify-2fa.php');
        $csrfOtp = $this->extractCsrf($verifyPage['body']);
        $got429 = false;
        for ($i = 0; $i < 6; $i++) {
            $badOtp = $this->httpPost('/admin/verify-2fa.php', [
                'csrf_token' => $csrfOtp,
                'action'     => 'verify_otp',
                'otp_code'   => '999999',
            ]);
            if ($badOtp['status'] === 429) {
                $got429 = true;
                $this->assertArrayHasKey('retry-after', $badOtp['headers']);
                break;
            }
            $csrfOtp = $this->extractCsrf($badOtp['body']);
        }
        $this->assertTrue($got429, 'Expected HTTP 429 rate limit on repeated invalid OTP attempts.');
    }

    /**
     * @return array{status: int, headers: array<string, string>, body: string}
     */
    private function httpGet(string $path): array
    {
        return $this->request('GET', $path);
    }

    /**
     * @param array<string, string> $postFields
     * @return array{status: int, headers: array<string, string>, body: string}
     */
    private function httpPost(string $path, array $postFields): array
    {
        return $this->request('POST', $path, $postFields);
    }

    /**
     * @param array<string, string>|null $postFields
     * @return array{status: int, headers: array<string, string>, body: string}
     */
    private function request(string $method, string $path, ?array $postFields = null): array
    {
        $ch = curl_init($this->baseUrl . $path);
        $headers = [];
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HEADER         => false,
            CURLOPT_COOKIEJAR      => $this->cookieJar,
            CURLOPT_COOKIEFILE     => $this->cookieJar,
            CURLOPT_TIMEOUT        => 5,
            CURLOPT_HEADERFUNCTION => static function ($curl, string $headerLine) use (&$headers): int {
                $len = strlen($headerLine);
                $parts = explode(':', $headerLine, 2);
                if (count($parts) === 2) {
                    $headers[strtolower(trim($parts[0]))] = trim($parts[1]);
                }
                return $len;
            },
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields ?? []));
        }

        $body = curl_exec($ch);
        $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
        curl_close($ch);

        return [
            'status'  => $status,
            'headers' => $headers,
            'body'    => is_string($body) ? $body : '',
        ];
    }

    private function extractCsrf(string $html): string
    {
        $matched = preg_match('/name="csrf_token"\s+value="([^"]+)"/', $html, $m);
        $this->assertSame(1, $matched, 'CSRF token input not found in HTML response.');
        return $m[1];
    }

    private function readCookieValue(string $name): string
    {
        if (!file_exists($this->cookieJar)) {
            return '';
        }
        $lines = file($this->cookieJar, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) ?: [];
        foreach ($lines as $line) {
            if (strpos($line, '#') === 0 && strpos($line, '#HttpOnly_') !== 0) {
                continue;
            }
            $cols = explode("\t", $line);
            if (count($cols) >= 7 && $cols[5] === $name) {
                return trim($cols[6]);
            }
        }
        return '';
    }

    private function findFreePort(): int
    {
        $socket = stream_socket_server('tcp://127.0.0.1:0', $errno, $errstr);
        $this->assertIsResource($socket, "Unable to allocate local TCP port: {$errstr}");
        $name = stream_socket_get_name($socket, false);
        fclose($socket);
        $parts = explode(':', (string) $name);
        return (int) end($parts);
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
