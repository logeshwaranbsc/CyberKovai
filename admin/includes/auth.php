<?php
/**
 * Cyber Kovai - Admin Authentication & Session Security Handler
 */

if (session_status() === PHP_SESSION_NONE) {
    if (!ob_get_level()) {
        ob_start();
    }
    // Start session with secure cookie attributes
    $params = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => 86400 * 7,
        'path'     => '/',
        'domain'   => $params['domain'],
        'secure'   => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
        'httponly' => true,
        'samesite' => 'Lax'
    ]);
    session_start();
}

require_once __DIR__ . '/../../includes/storage.php';

/**
 * Check if admin is currently authenticated.
 */
function ck_admin_is_logged_in() {
    return !empty($_SESSION['ck_admin_user']);
}

/**
 * Enforce admin authentication guard.
 */
function ck_admin_require_login() {
    if (!ck_admin_is_logged_in()) {
        $loginUrl = 'login.php';
        header("Location: {$loginUrl}");
        exit;
    }
}

/**
 * Get currently authenticated admin user info.
 */
function ck_admin_current_user() {
    return $_SESSION['ck_admin_user'] ?? null;
}

/**
 * Set current admin session.
 */
function ck_admin_login_user($user) {
    session_regenerate_id(true);
    $_SESSION['ck_admin_user'] = [
        'username' => $user['username'] ?? 'admin',
        'name'     => $user['name'] ?? 'Administrator',
        'email'    => $user['email'] ?? '',
        'role'     => $user['role'] ?? 'admin',
        'login_at' => time()
    ];
}

/**
 * Terminate admin session.
 */
function ck_admin_logout() {
    unset($_SESSION['ck_admin_user']);
    session_regenerate_id(true);
}

/**
 * Generate or retrieve CSRF token for the session.
 */
function ck_csrf_token() {
    if (empty($_SESSION['ck_csrf_token'])) {
        $_SESSION['ck_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['ck_csrf_token'];
}

/**
 * Render hidden CSRF form input.
 */
function ck_csrf_field() {
    $token = htmlspecialchars(ck_csrf_token(), ENT_QUOTES, 'UTF-8');
    return '<input type="hidden" name="csrf_token" value="' . $token . '">';
}

/**
 * Verify CSRF token from POST request.
 */
function ck_csrf_verify($token = null) {
    if ($token === null) {
        $token = $_POST['csrf_token'] ?? '';
    }
    $sessionToken = $_SESSION['ck_csrf_token'] ?? '';
    if (empty($token) || empty($sessionToken)) {
        return false;
    }
    return hash_equals($sessionToken, $token);
}

/**
 * Set flash alert message (e.g. success, error, warning).
 */
function ck_set_flash($type, $message) {
    $_SESSION['ck_flash'] = [
        'type'    => $type,
        'message' => $message
    ];
}

/**
 * Retrieve and clear flash alert message.
 */
function ck_get_flash() {
    if (!empty($_SESSION['ck_flash'])) {
        $flash = $_SESSION['ck_flash'];
        unset($_SESSION['ck_flash']);
        return $flash;
    }
    return null;
}

