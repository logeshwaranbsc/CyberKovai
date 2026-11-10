<?php
/**
 * Cyber Kovai - Two-Factor Authentication Challenge Screen (Stage 2)
 */

$allowGuest = true;
require_once __DIR__ . '/includes/auth.php';

use CyberKovai\Security\CorruptedStorageException;

if (ck_admin_is_logged_in()) {
    header('Location: index.php');
    exit;
}

$hadPendingRaw = !empty($_SESSION['ck_2fa_pending']);
$challenge = ck_admin_get_pending_2fa_challenge();
if ($challenge === null) {
    if ($hadPendingRaw) {
        ck_set_flash('error', 'Your two-factor verification session expired. Please sign in again.');
    } else {
        ck_set_flash('info', 'Please sign in with your administrator credentials first.');
    }
    header('Location: login.php');
    exit;
}

$error = '';
$remainingSeconds = max(0, (int) ($challenge['expires_at'] - time()));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        $error = 'Security session expired. Please refresh and try again.';
    } else {
        $action = (string) ($_POST['action'] ?? 'verify_otp');

        if ($action === 'cancel') {
            ck_audit_logger()->log('2fa_challenge_cancelled', (string) $challenge['admin_id']);
            ck_admin_clear_2fa_challenge();
            if (session_status() === PHP_SESSION_ACTIVE && !headers_sent()) {
                @session_regenerate_id(true);
            }
            ck_set_flash('info', 'Sign-in cancelled. Enter your credentials to start again.');
            header('Location: login.php');
            exit;
        }

        $admins = ck_get_admins();
        $adminId = (string) $challenge['admin_id'];
        $freshAdmin = $admins[$adminId] ?? null;

        if (!is_array($freshAdmin) || !ck_admin_has_admin_role((string) ($freshAdmin['role'] ?? ''))) {
            ck_admin_clear_2fa_challenge();
            ck_set_flash('error', 'Authentication failed. Please sign in again.');
            header('Location: login.php');
            exit;
        }

        $limiter = ck_rate_limiter();
        $ip = ck_client_ip();
        $otpInput = (string) ($_POST['otp_code'] ?? '');
        $acctBucket = '2fa_otp:' . $adminId . ':' . $ip;
        $ipBucket = '2fa_otp_ip:' . $ip;

        $acctLimit = $limiter->check($acctBucket, 5, 300);
        $ipLimit = $limiter->check($ipBucket, 15, 300);

        if ($acctLimit['limited'] || $ipLimit['limited']) {
            $retryAfter = max($acctLimit['retry_after'], $ipLimit['retry_after'], 1);
            http_response_code(429);
            header('Retry-After: ' . $retryAfter);
            ck_audit_logger()->log('2fa_rate_limited', $adminId, ['mode' => 'totp', 'retry_after' => $retryAfter]);
            $error = "Too many verification attempts. Please wait {$retryAfter} seconds and try again.";
        } else {
            try {
                $result = ck_two_factor_service()->verifyLoginOtp($freshAdmin, $otpInput);
                if (!empty($result['success'])) {
                    $limiter->clear($acctBucket);
                    $limiter->clear($ipBucket);
                    ck_admin_complete_login($freshAdmin, true);
                    ck_set_flash('success', 'Two-factor verification successful. Welcome back, ' . ($freshAdmin['name'] ?? $freshAdmin['username']) . '!');
                    header('Location: index.php');
                    exit;
                }

                $limiter->hit($acctBucket, 5, 300);
                $limiter->hit($ipBucket, 15, 300);
                $error = $result['error'] ?? 'Invalid verification code. Please try again.';
            } catch (CorruptedStorageException $e) {
                ck_audit_logger()->log('2fa_storage_error', $adminId, ['stage' => 'verify_otp', 'reason' => $e->getMessage()]);
                http_response_code(500);
                $error = 'Unable to verify authentication code due to a security configuration issue.';
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
    <title>Verify Your Identity | Cyber Kovai SOC</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/admin.css?v=<?= filemtime(__DIR__ . '/assets/admin.css') ?>">
    <style>
        .otp-input-lg {
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.45em;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            padding: 0.85rem 1rem;
        }
        .tfa-expiry-note {
            font-size: 0.76rem;
            color: var(--text-muted);
            text-align: center;
            margin-top: 0.85rem;
        }
    </style>
</head>
<body class="admin-body">

    <div class="login-screen-wrap">
        <div class="login-card">
            <div class="login-brand">
                <img src="../assets/images/logo.png" alt="Cyber Kovai">
                <h1>Verify Your Identity</h1>
                <p>Enter the six-digit code from your authenticator app.</p>
            </div>

            <?php if (!empty($error)): ?>
            <div class="flash-alert error" role="alert" aria-live="polite" style="margin-bottom: 1.25rem;">
                <span><strong>⚠ Verification Failed:</strong> <?= htmlspecialchars($error) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="verify-2fa.php" id="totpVerifyForm">
                <?= ck_csrf_field() ?>
                <input type="hidden" name="action" value="verify_otp">

                <div class="form-group">
                    <label for="otp_code" class="form-label">Six-Digit Verification Code</label>
                    <input
                        type="text"
                        id="otp_code"
                        name="otp_code"
                        class="form-control otp-input-lg"
                        inputmode="numeric"
                        pattern="[0-9]{6}"
                        maxlength="6"
                        autocomplete="one-time-code"
                        placeholder="000000"
                        autofocus
                        required
                        aria-describedby="otpHelp"
                    >
                    <span class="form-help" id="otpHelp">Open Google Authenticator or Microsoft Authenticator and enter the current 6-digit code.</span>
                </div>

                <div style="margin-top: 1.5rem;">
                    <button type="submit" class="btn btn-primary" id="verifyOtpBtn" style="width: 100%; padding: 0.85rem; font-size: 0.95rem;">
                        <span class="btn-label">Verify &amp; Continue ➔</span>
                    </button>
                </div>
            </form>

            <p class="tfa-expiry-note">
                Challenge expires in approximately <strong id="challengeCountdown"><?= (int) ceil($remainingSeconds / 60) ?></strong> min.
            </p>

            <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color); text-align: center;">
                <form method="POST" action="verify-2fa.php" style="display: inline;">
                    <?= ck_csrf_field() ?>
                    <input type="hidden" name="action" value="cancel">
                    <button type="submit" class="btn btn-secondary btn-sm" style="width: 100%;">
                        &larr; Cancel &amp; Back to Login
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
    (function () {
        const totpForm = document.getElementById('totpVerifyForm');
        const otpInput = document.getElementById('otp_code');
        const btn = document.getElementById('verifyOtpBtn');

        if (otpInput) {
            otpInput.addEventListener('input', function () {
                otpInput.value = otpInput.value.replace(/\D/g, '').slice(0, 6);
            });
        }

        if (totpForm && btn) {
            totpForm.addEventListener('submit', function () {
                btn.disabled = true;
                btn.style.opacity = '0.8';
                const label = btn.querySelector('.btn-label');
                if (label) label.textContent = 'Verifying Code...';
            });
        }
    })();
    </script>
</body>
</html>
