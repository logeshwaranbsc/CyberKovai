<?php
/**
 * Cyber Kovai - Admin Account & Security Profile (including Admin-Only 2FA Management)
 */

require_once __DIR__ . '/includes/auth.php';

use CyberKovai\Security\CryptoService;

$freshAdmin = ck_admin_require_admin_role();
$currentUser = ck_admin_current_user();
$username = (string) ($freshAdmin['username'] ?? $currentUser['username'] ?? 'admin');
$adminData = $freshAdmin;

$twoFactor = ck_two_factor_service();
$limiter = ck_rate_limiter();
$ip = ck_client_ip();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: profile.php');
        exit;
    }

    $postAction = (string) ($_POST['action'] ?? 'update_profile');

    // ---------------- 2FA: INITIATE SETUP ----------------
    if ($postAction === '2fa_initiate') {
        $reauthBucket = 'profile_reauth:' . $username . ':' . $ip;
        $limit = $limiter->check($reauthBucket, 8, 600);
        if ($limit['limited']) {
            ck_audit_logger()->log('2fa_rate_limited', $username, ['stage' => 'setup_initiate']);
            ck_set_flash('error', 'Too many verification attempts. Please wait ' . $limit['retry_after'] . ' seconds before trying again.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        $curPassword = (string) ($_POST['current_password'] ?? '');
        if (!ck_verify_admin($username, $curPassword)) {
            $limiter->hit($reauthBucket, 8, 600);
            ck_set_flash('error', 'Current password is incorrect. Re-authentication is required before enabling 2FA.');
            header('Location: profile.php#two-factor-security');
            exit;
        }
        $limiter->clear($reauthBucket);

        try {
            $twoFactor->initiateSetup($freshAdmin);
            $_SESSION['ck_2fa_setup_unlocked'] = time();
            ck_set_flash('success', 'Two-factor setup initiated. Scan the QR code with your authenticator app and confirm with a six-digit code.');
        } catch (\Throwable $e) {
            ck_set_flash('error', $e->getMessage());
        }
        header('Location: profile.php#two-factor-security');
        exit;
    }

    // ---------------- 2FA: UNLOCK PENDING SETUP ----------------
    if ($postAction === '2fa_unlock_setup') {
        $reauthBucket = 'profile_reauth:' . $username . ':' . $ip;
        $limit = $limiter->check($reauthBucket, 8, 600);
        if ($limit['limited']) {
            ck_set_flash('error', 'Too many verification attempts. Please wait ' . $limit['retry_after'] . ' seconds.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        $curPassword = (string) ($_POST['current_password'] ?? '');
        if (!ck_verify_admin($username, $curPassword)) {
            $limiter->hit($reauthBucket, 8, 600);
            ck_set_flash('error', 'Current password is incorrect.');
        } else {
            $limiter->clear($reauthBucket);
            $_SESSION['ck_2fa_setup_unlocked'] = time();
        }
        header('Location: profile.php#two-factor-security');
        exit;
    }

    // ---------------- 2FA: CANCEL PENDING SETUP ----------------
    if ($postAction === '2fa_cancel_setup') {
        unset($_SESSION['ck_2fa_setup_unlocked']);
        $twoFactor->cancelSetup($freshAdmin);
        ck_set_flash('info', 'Pending two-factor setup was cancelled. 2FA remains disabled.');
        header('Location: profile.php#two-factor-security');
        exit;
    }

    // ---------------- 2FA: CONFIRM SETUP WITH 6-DIGIT OTP ----------------
    if ($postAction === '2fa_confirm') {
        $confirmBucket = '2fa_setup_confirm:' . $username . ':' . $ip;
        $limit = $limiter->check($confirmBucket, 6, 300);
        if ($limit['limited']) {
            ck_audit_logger()->log('2fa_rate_limited', $username, ['stage' => 'setup_confirm']);
            ck_set_flash('error', 'Too many incorrect codes. Please wait ' . $limit['retry_after'] . ' seconds before trying again.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        $unlockedAt = (int) ($_SESSION['ck_2fa_setup_unlocked'] ?? 0);
        if ($unlockedAt <= 0 || (time() - $unlockedAt) > 900) {
            ck_set_flash('error', 'Setup authorization expired. Please confirm your current password to continue setup.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        $otpCode = (string) ($_POST['otp_code'] ?? '');
        $res = $twoFactor->confirmSetup($freshAdmin, $otpCode);
        if (!empty($res['success'])) {
            $limiter->clear($confirmBucket);
            unset($_SESSION['ck_2fa_setup_unlocked']);
            ck_admin_complete_login($freshAdmin, true);
            ck_set_flash('success', 'Two-factor authentication is now ENABLED for your administrator account!');
        } else {
            $limiter->hit($confirmBucket, 6, 300);
            ck_set_flash('error', $res['error'] ?? 'Verification failed. Two-factor authentication was not enabled.');
        }
        header('Location: profile.php#two-factor-security');
        exit;
    }

    // ---------------- 2FA: DISABLE 2FA ----------------
    if ($postAction === '2fa_disable') {
        $manageBucket = '2fa_manage:' . $username . ':' . $ip;
        $limit = $limiter->check($manageBucket, 5, 600);
        if ($limit['limited']) {
            ck_audit_logger()->log('2fa_rate_limited', $username, ['stage' => 'disable']);
            ck_set_flash('error', 'Too many verification attempts. Please wait ' . $limit['retry_after'] . ' seconds.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        if (empty($_POST['confirm_disable'])) {
            ck_set_flash('error', 'Please check the confirmation box before disabling Two-Factor Authentication.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        $curPassword = (string) ($_POST['current_password'] ?? '');
        $otpCode = (string) ($_POST['otp_code'] ?? '');

        if (!ck_verify_admin($username, $curPassword)) {
            $limiter->hit($manageBucket, 5, 600);
            ck_set_flash('error', 'Current password is incorrect. Two-Factor Authentication remains enabled.');
            header('Location: profile.php#two-factor-security');
            exit;
        }

        $res = $twoFactor->disableTwoFactor($freshAdmin, $otpCode);
        if (!empty($res['success'])) {
            $limiter->clear($manageBucket);
            ck_admin_complete_login($freshAdmin, false);
            ck_set_flash('success', 'Two-Factor Authentication has been safely disabled for your account.');
        } else {
            $limiter->hit($manageBucket, 5, 600);
            ck_set_flash('error', $res['error'] ?? 'Could not disable Two-Factor Authentication.');
        }
        header('Location: profile.php#two-factor-security');
        exit;
    }

    // ---------------- EXISTING PROFILE UPDATE ----------------
    $reauthBucket = 'profile_reauth:' . $username . ':' . $ip;
    $limit = $limiter->check($reauthBucket, 8, 600);
    if ($limit['limited']) {
        ck_set_flash('error', 'Too many verification attempts. Please wait ' . $limit['retry_after'] . ' seconds.');
        header('Location: profile.php');
        exit;
    }

    $newUsername = trim((string) ($_POST['username'] ?? ''));
    $email       = trim((string) ($_POST['email'] ?? ''));
    $curPassword = (string) ($_POST['current_password'] ?? '');
    $newPassword = (string) ($_POST['new_password'] ?? '');
    $conPassword = (string) ($_POST['confirm_password'] ?? '');

    $verifyCheck = ck_verify_admin($username, $curPassword);
    if (!$verifyCheck) {
        $limiter->hit($reauthBucket, 8, 600);
        ck_set_flash('error', 'Current password is incorrect. Verification failed.');
        header('Location: profile.php');
        exit;
    }
    $limiter->clear($reauthBucket);

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
        ck_admin_login_user($result['user'], ['preserve_2fa' => true]);
        ck_set_flash('success', 'Admin profile and credentials successfully updated!');
        header('Location: profile.php');
        exit;
    } else {
        ck_set_flash('error', $result['error'] ?? 'Failed to update admin profile.');
        header('Location: profile.php');
        exit;
    }
}

$twoFaStatus = $twoFactor->getStatus($username);
$cryptoReady = CryptoService::isConfigured();
$setupUnlockedAt = (int) ($_SESSION['ck_2fa_setup_unlocked'] ?? 0);
$setupUnlocked = $setupUnlockedAt > 0 && (time() - $setupUnlockedAt) <= 900;
$pendingProvisioning = null;
if (!empty($twoFaStatus['pending_setup']) && $setupUnlocked && $cryptoReady) {
    try {
        $pendingProvisioning = $twoFactor->getPendingProvisioningData($freshAdmin);
    } catch (\Throwable $e) {
        $pendingProvisioning = null;
    }
}

$adminPageTitle = 'Admin Profile & Security';
require_once __DIR__ . '/includes/header.php';
?>

<style>
.tfa-setup-grid {
    display: grid;
    grid-template-columns: 220px 1fr;
    gap: 1.5rem;
    align-items: start;
    margin-bottom: 1.5rem;
}
@media (max-width: 720px) {
    .tfa-setup-grid {
        grid-template-columns: 1fr;
    }
}
.tfa-qr-frame {
    background: #ffffff;
    border-radius: 12px;
    padding: 0.75rem;
    border: 2px solid rgba(158, 62, 255, 0.35);
    display: flex;
    align-items: center;
    justify-content: center;
    max-width: 220px;
}
.tfa-qr-frame img {
    width: 100%;
    height: auto;
    display: block;
}
.tfa-manual-key-box {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    flex-wrap: wrap;
    padding: 0.75rem 1rem;
    background: rgba(5, 5, 17, 0.85);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    margin: 0.75rem 0;
}
.tfa-manual-key-box code {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-size: 0.92rem;
    color: var(--accent-cyan);
    letter-spacing: 0.08em;
    word-break: break-all;
}
.tfa-action-panel {
    background: rgba(5, 5, 17, 0.45);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-sm);
    padding: 1.25rem;
}
.tfa-action-panel.danger {
    border-color: rgba(255, 51, 102, 0.3);
    background: rgba(255, 51, 102, 0.04);
}
.tfa-checkbox-row {
    display: flex;
    align-items: flex-start;
    gap: 0.6rem;
    font-size: 0.83rem;
    color: var(--text-secondary);
    margin: 0.85rem 0 1rem;
    cursor: pointer;
}
.tfa-checkbox-row input {
    margin-top: 0.2rem;
    accent-color: var(--accent-purple);
}
.ck-persistent-notice {
    padding: 1rem 1.25rem;
    border-radius: var(--radius-sm);
    margin-bottom: 1.25rem;
    font-size: 0.9rem;
    line-height: 1.5;
}
.ck-persistent-notice.warning {
    background: rgba(255, 171, 0, 0.12);
    border: 1px solid rgba(255, 171, 0, 0.35);
    color: #ffe082;
}
.ck-persistent-notice.error {
    background: rgba(255, 51, 102, 0.12);
    border: 1px solid rgba(255, 51, 102, 0.35);
    color: #ff99b3;
}
</style>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Admin Profile &amp; Security Settings</h1>
        <p class="page-header-desc">Manage Two-Factor Authentication (2FA), administrative username, notification email, and SOC password.</p>
    </div>
</div>

<!-- ================= TWO-FACTOR AUTHENTICATION (2FA) CARD ================= -->
<div class="admin-card" id="two-factor-security" style="max-width: 820px;">
    <div class="admin-card-header">
        <div>
            <h3 class="admin-card-title">Two-Factor Authentication (Authenticator App)</h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;">
                Require a six-digit TOTP code from Google Authenticator or Microsoft Authenticator on every admin login.
            </p>
        </div>
        <?php if (!empty($twoFaStatus['corrupted'])): ?>
            <span class="status-pill inactive" style="background: rgba(255,51,102,0.16); color: #ff5c7c; border-color: rgba(255,51,102,0.4);">Storage Error</span>
        <?php elseif (!empty($twoFaStatus['enabled'])): ?>
            <span class="status-pill active">Enabled</span>
        <?php elseif (!empty($twoFaStatus['pending_setup'])): ?>
            <span class="status-pill inactive" style="background: rgba(255,171,0,0.15); color: #ffab00; border-color: rgba(255,171,0,0.35);">Pending Confirmation</span>
        <?php else: ?>
            <span class="status-pill inactive">Disabled</span>
        <?php endif; ?>
    </div>

    <div class="admin-card-body">

        <?php if (!empty($twoFaStatus['corrupted'])): ?>
            <div class="ck-persistent-notice error" role="alert">
                <span><strong>⚠ Security Configuration Error:</strong> The two-factor authentication storage file could not be validated. Check backups and <code>CK_APP_KEY</code> configuration before making changes.</span>
            </div>
        <?php endif; ?>

        <?php if (!$cryptoReady && empty($twoFaStatus['enabled'])): ?>
            <div class="ck-persistent-notice warning">
                <span><strong>Configuration Required:</strong> Set a 256-bit <code>CK_APP_KEY</code> in your server environment (<code>.env</code>) before enabling Two-Factor Authentication.</span>
            </div>
        <?php elseif (!empty($twoFaStatus['enabled'])): ?>
            <!-- -------- 2FA IS ENABLED -------- -->
            <div style="display: flex; flex-wrap: wrap; gap: 1.25rem; padding: 1rem 1.25rem; background: rgba(0, 230, 118, 0.06); border: 1px solid rgba(0, 230, 118, 0.25); border-radius: var(--radius-sm); margin-bottom: 1.5rem;">
                <div>
                    <div style="font-size: 0.74rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Status</div>
                    <div style="font-size: 0.95rem; font-weight: 700; color: var(--accent-green);">Active &amp; Enforced on Admin Login</div>
                </div>
                <?php if (!empty($twoFaStatus['confirmed_at'])): ?>
                <div>
                    <div style="font-size: 0.74rem; text-transform: uppercase; color: var(--text-muted); font-weight: 700;">Enabled Since</div>
                    <div style="font-size: 0.88rem; color: var(--text-secondary);"><?= htmlspecialchars($twoFaStatus['confirmed_at']) ?></div>
                </div>
                <?php endif; ?>
            </div>

            <div class="tfa-action-panel danger">
                <h4 style="font-size: 0.98rem; color: #ff7a99; margin-bottom: 0.4rem;">Disable Two-Factor Authentication</h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">
                    Removing 2FA lowers account protection to password-only authentication. Confirm with both your current password and a valid 6-digit authenticator code.
                </p>
                <form method="POST" action="profile.php#two-factor-security" onsubmit="return confirm('Are you sure you want to disable Two-Factor Authentication for this administrator account?');">
                    <?= ck_csrf_field() ?>
                    <input type="hidden" name="action" value="2fa_disable">

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="disable_password" class="form-label">Current Password <span class="required">*</span></label>
                            <input type="password" id="disable_password" name="current_password" class="form-control" required autocomplete="current-password" placeholder="Enter current password">
                        </div>

                        <div class="form-group">
                            <label for="disable_otp" class="form-label">Current 6-Digit Authenticator Code <span class="required">*</span></label>
                            <input type="text" id="disable_otp" name="otp_code" class="form-control" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required placeholder="000000" autocomplete="one-time-code">
                        </div>
                    </div>

                    <label class="tfa-checkbox-row">
                        <input type="checkbox" name="confirm_disable" value="1" required>
                        <span>Confirm disabling Two-Factor Authentication on this administrator account.</span>
                    </label>

                    <button type="submit" class="btn btn-danger">Disable 2FA</button>
                </form>
            </div>

        <?php elseif ($pendingProvisioning !== null): ?>
            <!-- -------- STEP 2: SCAN QR & CONFIRM FIRST OTP -------- -->
            <div class="ck-persistent-notice warning">
                <span><strong>Setup In Progress:</strong> Two-factor authentication is <strong>not active yet</strong>. Scan the QR code with your authenticator app and verify a six-digit code below to activate it.</span>
            </div>

            <div class="tfa-setup-grid">
                <div>
                    <?php if (class_exists(\chillerlan\QRCode\QRCode::class)): ?>
                    <div class="tfa-qr-frame">
                        <img src="two-factor-qr.php?v=<?= time() ?>" alt="Authenticator QR Code">
                    </div>
                    <span class="form-help" style="text-align: center; margin-top: 0.5rem;">Scan with Google or Microsoft Authenticator</span>
                    <?php else: ?>
                    <div class="tfa-action-panel" style="padding: 1rem; text-align: center;">
                        <p style="font-size: 0.8rem; color: var(--text-secondary); margin: 0;">
                            QR image rendering requires <code>composer install</code>. Use the manual setup key on the right in your authenticator app.
                        </p>
                    </div>
                    <?php endif; ?>
                </div>

                <div>
                    <h4 style="font-size: 1rem; color: var(--text-primary); margin-bottom: 0.5rem;">1. Scan QR Code or Enter Setup Key</h4>
                    <p style="font-size: 0.84rem; color: var(--text-secondary);">
                        Open Google Authenticator, Microsoft Authenticator, or another standard TOTP authenticator app, choose <strong>Add Account</strong> &rarr; <strong>Scan QR Code</strong>, or enter this manual setup key:
                    </p>

                    <div class="tfa-manual-key-box">
                        <code id="totpManualKey"><?= htmlspecialchars(trim(chunk_split($pendingProvisioning['secret_manual'], 4, ' '))) ?></code>
                        <button type="button" class="btn btn-secondary btn-sm" id="copyManualKeyBtn">Copy Key</button>
                    </div>

                    <h4 style="font-size: 1rem; color: var(--text-primary); margin: 1.25rem 0 0.5rem;">2. Confirm Setup with a Six-Digit Code</h4>
                    <form method="POST" action="profile.php#two-factor-security">
                        <?= ck_csrf_field() ?>
                        <input type="hidden" name="action" value="2fa_confirm">

                        <div class="form-group">
                            <label for="setup_otp_code" class="form-label">Authenticator 6-Digit Code <span class="required">*</span></label>
                            <input
                                type="text"
                                id="setup_otp_code"
                                name="otp_code"
                                class="form-control"
                                inputmode="numeric"
                                pattern="[0-9]{6}"
                                maxlength="6"
                                autocomplete="one-time-code"
                                placeholder="000000"
                                required
                                style="max-width: 220px; text-align: center; font-size: 1.25rem; letter-spacing: 0.3em; font-weight: 700;"
                            >
                        </div>

                        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <button type="submit" class="btn btn-primary">Verify &amp; Enable 2FA</button>
                        </div>
                    </form>

                    <form method="POST" action="profile.php#two-factor-security" style="margin-top: 0.75rem;">
                        <?= ck_csrf_field() ?>
                        <input type="hidden" name="action" value="2fa_cancel_setup">
                        <button type="submit" class="btn btn-secondary btn-sm">Cancel Setup</button>
                    </form>
                </div>
            </div>

        <?php elseif (!empty($twoFaStatus['pending_setup'])): ?>
            <!-- -------- PENDING SETUP FROM PRIOR SESSION (NEEDS PASSWORD RE-AUTH) -------- -->
            <div class="tfa-action-panel">
                <h4 style="font-size: 0.98rem; color: var(--accent-amber); margin-bottom: 0.4rem;">Resume Pending 2FA Setup</h4>
                <p style="font-size: 0.84rem; color: var(--text-secondary); margin-bottom: 1rem;">
                    A pending setup secret was previously generated but has not been confirmed yet. Re-enter your current password to display the setup QR code, or cancel the pending setup.
                </p>
                <form method="POST" action="profile.php#two-factor-security" style="margin-bottom: 0.75rem;">
                    <?= ck_csrf_field() ?>
                    <input type="hidden" name="action" value="2fa_unlock_setup">
                    <div class="form-group">
                        <label for="unlock_setup_pw" class="form-label">Current Password <span class="required">*</span></label>
                        <input type="password" id="unlock_setup_pw" name="current_password" class="form-control" required placeholder="Enter current password" style="max-width: 340px;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Continue Setup</button>
                </form>
                <form method="POST" action="profile.php#two-factor-security">
                    <?= ck_csrf_field() ?>
                    <input type="hidden" name="action" value="2fa_cancel_setup">
                    <button type="submit" class="btn btn-secondary btn-sm">Discard Pending Setup</button>
                </form>
            </div>

        <?php else: ?>
            <!-- -------- STEP 1: DISABLED -> PASSWORD CONFIRM TO BEGIN SETUP -------- -->
            <div class="tfa-action-panel">
                <h4 style="font-size: 0.98rem; color: var(--text-primary); margin-bottom: 0.4rem;">Enable Two-Factor Authentication</h4>
                <p style="font-size: 0.84rem; color: var(--text-secondary); margin-bottom: 1rem;">
                    Protect your administrator account using Google Authenticator or Microsoft Authenticator. Re-enter your current password to generate a unique setup QR code.
                </p>

                <form method="POST" action="profile.php#two-factor-security">
                    <?= ck_csrf_field() ?>
                    <input type="hidden" name="action" value="2fa_initiate">

                    <div class="form-group">
                        <label for="enable_2fa_password" class="form-label">Current Password <span class="required">*</span></label>
                        <input type="password" id="enable_2fa_password" name="current_password" class="form-control" required autocomplete="current-password" placeholder="Enter your current password" style="max-width: 360px;">
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <span>🔐</span> Enable Two-Factor Authentication
                    </button>
                </form>
            </div>
        <?php endif; ?>

    </div>
</div>

<!-- ================= PROFILE & CREDENTIALS CARD ================= -->
<div class="admin-card" style="max-width: 820px;">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Security Credentials</h3>
        <span class="status-pill active"><?= htmlspecialchars(ucfirst($adminData['role'] ?? 'Superadmin')) ?></span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="profile.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="update_profile">

            <div class="form-group">
                <label for="username" class="form-label">Admin Username <span class="required">*</span></label>
                <input type="text" id="username" name="username" class="form-control" required value="<?= htmlspecialchars($adminData['username'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Admin Notification Email</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($adminData['email'] ?? '') ?>">
                <span class="form-help">Used for system alerts, authenticator label, and critical SOC security notifications.</span>
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

<script>
(function () {
    const setupOtp = document.getElementById('setup_otp_code');
    if (setupOtp) {
        setupOtp.addEventListener('input', function () {
            setupOtp.value = setupOtp.value.replace(/\D/g, '').slice(0, 6);
        });
    }

    const disableOtp = document.getElementById('disable_otp');
    if (disableOtp) {
        disableOtp.addEventListener('input', function () {
            disableOtp.value = disableOtp.value.replace(/\D/g, '').slice(0, 6);
        });
    }

    const copyKeyBtn = document.getElementById('copyManualKeyBtn');
    const manualKeyEl = document.getElementById('totpManualKey');
    if (copyKeyBtn && manualKeyEl && navigator.clipboard) {
        copyKeyBtn.addEventListener('click', function () {
            const raw = manualKeyEl.textContent.replace(/\s+/g, '');
            navigator.clipboard.writeText(raw).then(function () {
                copyKeyBtn.textContent = 'Copied!';
                setTimeout(function () { copyKeyBtn.textContent = 'Copy Key'; }, 2000);
            });
        });
    }
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
