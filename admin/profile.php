<?php
/**
 * Cyber Kovai - Admin Account & Security Profile
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$currentUser = ck_admin_current_user();
$username = $currentUser['username'] ?? 'admin';
$admins = ck_get_admins();
$adminData = $admins[$username] ?? [
    'username' => $username,
    'email'    => 'admin@cyberkovai.com',
    'name'     => 'Cyber Kovai Administrator'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: profile.php');
        exit;
    }

    $newUsername = trim($_POST['username'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $curPassword = (string)($_POST['current_password'] ?? '');
    $newPassword = (string)($_POST['new_password'] ?? '');
    $conPassword = (string)($_POST['confirm_password'] ?? '');

    // If changing password or sensitive profile details, verify current password
    $verifyCheck = ck_verify_admin($username, $curPassword);
    if (!$verifyCheck) {
        ck_set_flash('error', 'Current password is incorrect. Verification failed.');
        header('Location: profile.php');
        exit;
    }

    if ($newPassword !== '') {
        if ($newPassword !== $conPassword) {
            ck_set_flash('error', 'New password and confirmation do not match.');
            header('Location: profile.php');
            exit;
        }
        if (strlen($newPassword) < 8) {
            ck_set_flash('error', 'New password must be at least 8 characters long.');
            header('Location: profile.php');
            exit;
        }
    }

    $result = ck_update_admin_profile($username, $newUsername, $email, $newPassword ?: null);
    if ($result['success']) {
        ck_admin_login_user($result['user']);
        ck_set_flash('success', 'Admin profile and credentials successfully updated!');
        header('Location: profile.php');
        exit;
    } else {
        ck_set_flash('error', $result['error'] ?? 'Failed to update admin profile.');
        header('Location: profile.php');
        exit;
    }
}

$adminPageTitle = 'Admin Profile & Security';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Admin Profile &amp; Access Credentials</h1>
        <p class="page-header-desc">Manage administrative username, email notifications, and SOC access password.</p>
    </div>
</div>

<div class="admin-card" style="max-width: 720px;">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Security Credentials</h3>
        <span class="status-pill active">Superadmin</span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="profile.php">
            <?= ck_csrf_field() ?>

            <div class="form-group">
                <label for="username" class="form-label">Admin Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" class="form-control" required value="<?= htmlspecialchars($adminData['username'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Admin Notification Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($adminData['email'] ?? '') ?>">
                <span class="form-help">Used for system alerts and critical SOC security notifications.</span>
            </div>

            <div style="margin: 1.5rem 0; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
                <h4 style="font-size: 0.95rem; color: var(--accent-purple-light); margin-bottom: 0.35rem;">
                    Update Password (Optional)
                </h4>
                <p style="font-size: 0.78rem; color: var(--text-muted); margin-bottom: 1rem;">
                    Leave new password fields blank if you only wish to change your username or email.
                </p>

                <div class="form-group">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Minimum 8 characters">
                </div>

                <div class="form-group">
                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Re-enter new password">
                </div>
            </div>

            <div style="margin: 1.5rem 0; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
                <div class="form-group">
                    <label for="current_password" class="form-label">
                        Current Password (Required to Authorize Changes) <span class="required">*</span>
                    </label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required placeholder="Enter current password">
                    <span class="form-help">Enter your current password to confirm authorization.</span>
                </div>
            </div>

            <div style="padding-top: 1rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Update Admin Profile
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

