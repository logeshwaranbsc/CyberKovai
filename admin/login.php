<?php
/**
 * Cyber Kovai - Admin Login Screen (Stage 1: Password Verification)
 */

$allowGuest = true;
require_once __DIR__ . '/includes/auth.php';

use CyberKovai\Security\CorruptedStorageException;

if (ck_admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
$flash = ck_get_flash();
$pendingChallenge = ck_admin_get_pending_2fa_challenge();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        $error = 'Security session expired. Please refresh the page and try again.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'Please enter both username and password.';
        } else {
            $limiter = ck_rate_limiter();
            $ip = ck_client_ip();
            $ipBucket = 'login_ip:' . $ip;
            $acctBucket = 'login_acct:' . strtolower($username) . ':' . $ip;

            $ipStatus = $limiter->check($ipBucket, 15, 300);
            $acctStatus = $limiter->check($acctBucket, 5, 300);

            if ($ipStatus['limited'] || $acctStatus['limited']) {
                $retryAfter = max($ipStatus['retry_after'], $acctStatus['retry_after'], 1);
                http_response_code(429);
                header('Retry-After: ' . $retryAfter);
                ck_audit_logger()->log('login_rate_limited', $username, ['retry_after' => $retryAfter]);
                $error = "Too many sign-in attempts. Please wait {$retryAfter} seconds and try again.";
            } else {
                $admin = ck_verify_admin($username, $password);
                if (!$admin || !ck_admin_has_admin_role((string) ($admin['role'] ?? ''))) {
                    $limiter->hit($ipBucket, 15, 300);
                    $limiter->hit($acctBucket, 5, 300);
                    ck_audit_logger()->log('login_password_failed', $username);
                    $error = 'Invalid credentials. Access denied.';
                } else {
                    $limiter->clear($acctBucket);
                    $limiter->clear($ipBucket);

                    try {
                        $requires2fa = ck_two_factor_service()->requiresTwoFactor($admin);
                    } catch (CorruptedStorageException $e) {
                        ck_audit_logger()->log('2fa_storage_error', (string) $admin['username'], [
                            'stage' => 'login',
                            'reason' => $e->getMessage(),
                        ]);
                        http_response_code(500);
                        $error = 'Authentication cannot be completed at this time. Please contact a system administrator.';
                        $requires2fa = null;
                    }

                    if ($requires2fa === true) {
                        ck_admin_start_2fa_challenge($admin);
                        ck_audit_logger()->log('login_2fa_challenge_issued', (string) $admin['username']);
                        header('Location: verify-2fa.php');
                        exit;
                    } elseif ($requires2fa === false) {
                        ck_admin_complete_login($admin, false);
                        ck_audit_logger()->log('login_password_success_no_2fa', (string) $admin['username']);
                        ck_set_flash('success', 'Welcome back, ' . ($admin['name'] ?? $admin['username']) . '!');
                        header('Location: index.php');
                        exit;
                    }
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Sign In | Cyber Kovai SOC</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/admin.css?v=<?= filemtime(__DIR__ . '/assets/admin.css') ?>">
</head>
<body class="admin-body">

    <div class="login-screen-wrap">
        <div class="login-card">
            <div class="login-brand">
                <img src="../assets/images/logo.png" alt="Cyber Kovai">
                <h1>Cyber <strong>Kovai</strong></h1>
                <p>Security Operations &amp; Administration Portal</p>
            </div>

            <?php if (!empty($flash)): ?>
            <div class="flash-alert <?= htmlspecialchars($flash['type']) ?>" role="status" style="margin-bottom: 1.5rem;">
                <span><?= htmlspecialchars($flash['message']) ?></span>
            </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
            <div class="flash-alert error" role="alert" style="margin-bottom: 1.5rem;">
                <span><strong>⚠ Authentication Failed:</strong> <?= htmlspecialchars($error) ?></span>
            </div>
            <?php endif; ?>

            <?php if ($pendingChallenge !== null && empty($error)): ?>
            <div class="flash-alert warning" style="margin-bottom: 1.5rem; flex-direction: column; align-items: flex-start; gap: 0.65rem;">
                <span>A two-factor verification challenge is currently awaiting completion.</span>
                <a href="verify-2fa.php" class="btn btn-secondary btn-sm">Resume 2FA Verification ➔</a>
            </div>
            <?php endif; ?>

            <form method="POST" action="login.php" id="adminLoginForm">
                <?= ck_csrf_field() ?>

                <div class="form-group">
                    <label for="username" class="form-label">Username / Email</label>
                    <input type="text" id="username" name="username" class="form-control" required autofocus placeholder="Enter username or email" autocomplete="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Enter password" autocomplete="current-password">
                </div>

                <div style="margin-top: 1.75rem;">
                    <button type="submit" class="btn btn-primary" id="loginSubmitBtn" style="width: 100%; padding: 0.85rem; font-size: 0.95rem;">
                        <span class="btn-label">Authenticate &amp; Enter SOC ➔</span>
                    </button>
                </div>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color); text-align: center; font-size: 0.78rem; color: var(--text-muted);">
                <p style="margin-top: 0.5rem;"><a href="../index.php" style="color: var(--text-secondary); text-decoration: none;">&larr; Return to Website</a></p>
            </div>
        </div>
    </div>

    <script>
    (function () {
        const form = document.getElementById('adminLoginForm');
        const btn = document.getElementById('loginSubmitBtn');
        if (form && btn) {
            form.addEventListener('submit', function () {
                btn.disabled = true;
                btn.style.opacity = '0.8';
                const label = btn.querySelector('.btn-label');
                if (label) label.textContent = 'Verifying Credentials...';
            });
        }
    })();
    </script>
</body>
</html>
