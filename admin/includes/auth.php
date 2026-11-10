<?php
/**
 * Cyber Kovai - Admin Authentication, 2FA Challenge & Session Security Handler
 */

require_once __DIR__ . '/../../includes/env.php';
require_once __DIR__ . '/../../includes/storage.php';

use CyberKovai\Security\AuditLogger;
use CyberKovai\Security\CorruptedStorageException;
use CyberKovai\Security\RateLimiter;
use CyberKovai\Security\TwoFactorService;

if (!function_exists('ck_is_https_request')) {
    function ck_is_https_request(): bool
    {
        if (!empty($_SERVER['HTTPS']) && strtolower((string) $_SERVER['HTTPS']) !== 'off') {
            return true;
        }
        return (int) ($_SERVER['SERVER_PORT'] ?? 0) === 443;
    }
}

if (PHP_SAPI !== 'cli' && session_status() === PHP_SESSION_NONE && !headers_sent()) {
    if (!ob_get_level()) {
        ob_start();
    }
    @ini_set('session.use_strict_mode', '1');
    @ini_set('session.use_only_cookies', '1');

    $params = session_get_cookie_params();
    $secureCookie = ck_is_https_request() || filter_var(env('SESSION_SECURE_COOKIE', false), FILTER_VALIDATE_BOOLEAN);

    session_set_cookie_params([
        'lifetime' => 86400 * 7,
        'path'     => '/',
        'domain'   => $params['domain'],
        'secure'   => $secureCookie,
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

function ck_two_factor_service(): TwoFactorService
{
    static $service = null;
    if ($service === null) {
        $service = new TwoFactorService();
    }
    return $service;
}

function ck_rate_limiter(): RateLimiter
{
    static $limiter = null;
    if ($limiter === null) {
        $limiter = new RateLimiter();
    }
    return $limiter;
}

function ck_audit_logger(): AuditLogger
{
    static $logger = null;
    if ($logger === null) {
        $logger = new AuditLogger();
    }
    return $logger;
}

function ck_client_ip(): string
{
    return trim((string) ($_SERVER['REMOTE_ADDR'] ?? 'unknown')) ?: 'unknown';
}

function ck_admin_has_admin_role(?string $role = null): bool
{
    if ($role === null) {
        $user = ck_admin_current_user();
        $role = is_array($user) ? (string) ($user['role'] ?? '') : '';
    }
    return TwoFactorService::isEligibleAdminRole($role);
}

/**
 * Check if admin has completed full authentication (including 2FA when enabled).
 * Pending 2FA challenges NEVER qualify as logged in.
 */
function ck_admin_is_logged_in(?TwoFactorService $twoFactor = null): bool
{
    if (!empty($_SESSION['ck_2fa_pending'])) {
        return false;
    }

    $user = $_SESSION['ck_admin_user'] ?? null;
    if (!is_array($user) || empty($user['auth_complete']) || empty($user['username'])) {
        return false;
    }

    if (!ck_admin_has_admin_role((string) ($user['role'] ?? ''))) {
        return false;
    }

    $twoFactor = $twoFactor ?? ck_two_factor_service();
    try {
        if ($twoFactor->requiresTwoFactor($user)) {
            return !empty($user['2fa_verified']);
        }
    } catch (CorruptedStorageException $e) {
        // Fail closed if 2FA store is corrupted
        return false;
    }

    return true;
}

/**
 * Enforce admin authentication guard across all protected admin pages & endpoints.
 */
function ck_admin_require_login(?TwoFactorService $twoFactor = null): void
{
    if (!ck_admin_is_logged_in($twoFactor)) {
        $isAjax = !empty($_POST['ajax']) ||
            stripos((string) ($_SERVER['HTTP_ACCEPT'] ?? ''), 'application/json') !== false;

        if ($isAjax) {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'error' => 'Authentication required.']);
            exit;
        }

        if (!empty($_SESSION['ck_2fa_pending'])) {
            header('Location: verify-2fa.php');
            exit;
        }

        header('Location: login.php');
        exit;
    }
}

/**
 * Verify server-side role from persistent admins.json for sensitive 2FA management endpoints.
 */
function ck_admin_require_admin_role(): array
{
    ck_admin_require_login();
    $sessionUser = ck_admin_current_user();
    $username = (string) ($sessionUser['username'] ?? '');
    $admins = ck_get_admins();
    $freshAdmin = $admins[$username] ?? null;

    if (!is_array($freshAdmin) || !ck_admin_has_admin_role((string) ($freshAdmin['role'] ?? ''))) {
        ck_audit_logger()->log('admin_role_denied', $username ?: null);
        ck_admin_logout();
        http_response_code(403);
        exit('Forbidden: Administrator privileges required.');
    }

    return $freshAdmin;
}

/**
 * Get currently authenticated admin user info (only when fully authenticated).
 */
function ck_admin_current_user(): ?array
{
    if (!empty($_SESSION['ck_2fa_pending'])) {
        return null;
    }
    $user = $_SESSION['ck_admin_user'] ?? null;
    return is_array($user) && !empty($user['auth_complete']) ? $user : null;
}

/**
 * Start a short-lived restricted pending 2FA challenge after valid password verification.
 * Does NOT issue an authenticated admin session.
 */
function ck_admin_start_2fa_challenge(array $user, ?int $now = null): array
{
    unset(
        $_SESSION['ck_admin_user'],
        $_SESSION['ck_2fa_setup_unlocked']
    );

    if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
        @session_regenerate_id(true);
    }
    $_SESSION['ck_csrf_token'] = bin2hex(random_bytes(32));

    $now = $now ?? time();
    $ttl = max(60, (int) env('CK_2FA_CHALLENGE_TTL', 300));

    $challenge = [
        'challenge_id' => bin2hex(random_bytes(32)),
        'admin_id'     => (string) ($user['username'] ?? ''),
        'username'     => (string) ($user['username'] ?? ''),
        'name'         => (string) ($user['name'] ?? 'Administrator'),
        'email'        => (string) ($user['email'] ?? ''),
        'role'         => (string) ($user['role'] ?? 'admin'),
        'created_at'   => $now,
        'expires_at'   => $now + $ttl,
        'consumed'     => false,
    ];

    $_SESSION['ck_2fa_pending'] = $challenge;
    return $challenge;
}

/**
 * Retrieve active, unconsumed, non-expired 2FA challenge.
 */
function ck_admin_get_pending_2fa_challenge(?int $now = null): ?array
{
    $pending = $_SESSION['ck_2fa_pending'] ?? null;
    if (!is_array($pending) || empty($pending['challenge_id']) || empty($pending['admin_id'])) {
        return null;
    }

    if (!empty($pending['consumed'])) {
        unset($_SESSION['ck_2fa_pending']);
        return null;
    }

    $now = $now ?? time();
    if ((int) ($pending['expires_at'] ?? 0) < $now) {
        ck_audit_logger()->log('2fa_challenge_expired', (string) $pending['admin_id']);
        unset($_SESSION['ck_2fa_pending']);
        return null;
    }

    return $pending;
}

/**
 * Mark and remove pending 2FA challenge so it cannot be reused.
 */
function ck_admin_clear_2fa_challenge(): void
{
    if (isset($_SESSION['ck_2fa_pending']) && is_array($_SESSION['ck_2fa_pending'])) {
        $_SESSION['ck_2fa_pending']['consumed'] = true;
    }
    unset($_SESSION['ck_2fa_pending']);
}

/**
 * Finalize admin login after password (and 2FA, when enabled) succeeds.
 * Regenerates session ID and rotates CSRF token to prevent fixation.
 */
function ck_admin_complete_login(array $user, bool $twoFactorVerified = false, ?int $verifiedAt = null): void
{
    ck_admin_clear_2fa_challenge();

    if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
        @session_regenerate_id(true);
    }
    $_SESSION['ck_csrf_token'] = bin2hex(random_bytes(32));

    $_SESSION['ck_admin_user'] = [
        'username'        => $user['username'] ?? 'admin',
        'name'            => $user['name'] ?? 'Administrator',
        'email'           => $user['email'] ?? '',
        'role'            => $user['role'] ?? 'admin',
        'login_at'        => time(),
        'auth_complete'   => true,
        '2fa_verified'    => $twoFactorVerified,
        '2fa_verified_at' => $twoFactorVerified ? ($verifiedAt ?? time()) : null,
    ];
}

/**
 * Set current admin session (backward-compatible wrapper).
 *
 * @param array<string, mixed> $options
 */
function ck_admin_login_user(array $user, array $options = []): void
{
    $preserve2fa = !empty($options['preserve_2fa']);
    $existingVerified = !empty($_SESSION['ck_admin_user']['2fa_verified']);
    $existingVerifiedAt = $_SESSION['ck_admin_user']['2fa_verified_at'] ?? null;

    $twoFactorVerified = $preserve2fa
        ? $existingVerified
        : (bool) ($options['2fa_verified'] ?? false);

    $verifiedAt = $preserve2fa
        ? ($existingVerifiedAt !== null ? (int) $existingVerifiedAt : null)
        : ($options['2fa_verified_at'] ?? null);

    ck_admin_complete_login($user, $twoFactorVerified, $verifiedAt);
}

/**
 * Terminate admin session and any pending 2FA challenge/setup state.
 */
function ck_admin_logout(): void
{
    unset(
        $_SESSION['ck_admin_user'],
        $_SESSION['ck_2fa_pending'],
        $_SESSION['ck_2fa_setup_unlocked']
    );

    if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
        @session_regenerate_id(true);
    }
    $_SESSION['ck_csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * Generate or retrieve CSRF token for the session.
 */
function ck_csrf_token(): string
{
    if (empty($_SESSION['ck_csrf_token'])) {
        $_SESSION['ck_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['ck_csrf_token'];
}

/**
 * Render hidden CSRF form input.
 */
function ck_csrf_field(): string
{
    $token = htmlspecialchars(ck_csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Verify CSRF token from POST request.
 */
function ck_csrf_verify(?string $token = null): bool
{
    if ($token === null) {
        $token = (string) ($_POST['csrf_token'] ?? '');
    }
    $sessionToken = (string) ($_SESSION['ck_csrf_token'] ?? '');
    if ($token === '' || $sessionToken === '') {
        return false;
    }
    return hash_equals($sessionToken, $token);
}

/**
 * Set flash alert message (e.g. success, error, warning, info).
 */
function ck_set_flash(string $type, string $message): void
{
    $_SESSION['ck_flash'] = [
        'type'    => $type,
        'message' => $message,
    ];
}

/**
 * Retrieve and clear flash alert message.
 */
function ck_get_flash(): ?array
{
    if (!empty($_SESSION['ck_flash'])) {
        $flash = $_SESSION['ck_flash'];
        unset($_SESSION['ck_flash']);
        return $flash;
    }
    return null;
}
