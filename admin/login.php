<?php
/**
 * Cyber Kovai - Admin Login Screen
 */

$allowGuest = true;
require_once __DIR__ . '/includes/auth.php';

if (ck_admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        $error = 'Security session expired. Please refresh the page and try again.';
    } else {
        $username = trim($_POST['username'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if ($username === '' || $password === '') {
            $error = 'Please enter both username and password.';
        } else {
            $admin = ck_verify_admin($username, $password);
            if ($admin) {
                ck_admin_login_user($admin);
                ck_set_flash('success', 'Welcome back, ' . ($admin['name'] ?? $admin['username']) . '!');
                header('Location: index.php');
                exit;
            } else {
                $error = 'Invalid administrative credentials. Access denied.';
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

            <?php if (!empty($error)): ?>
            <div class="flash-alert error" style="margin-bottom: 1.5rem;">
                <span><strong>⚠ Authentication Failed:</strong> <?= htmlspecialchars($error) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="login.php">
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
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.85rem; font-size: 0.95rem;">
                        Authenticate &amp; Enter SOC ➔
                    </button>
                </div>
            </form>

            <div style="margin-top: 2rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color); text-align: center; font-size: 0.78rem; color: var(--text-muted);">
                <p style="margin-top: 0.5rem;"><a href="../index.php" style="color: var(--text-secondary); text-decoration: none;">&larr; Return to Website</a></p>
            </div>
        </div>
    </div>

</body>
</html>

