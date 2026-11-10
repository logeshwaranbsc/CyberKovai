<?php
/**
 * Cyber Kovai - Authenticated Admin 2FA Setup QR Code Endpoint
 * Serves the SVG QR code exclusively for an authenticated admin during active password-confirmed setup.
 */

require_once __DIR__ . '/includes/auth.php';

$admin = ck_admin_require_admin_role();

$unlockedAt = (int) ($_SESSION['ck_2fa_setup_unlocked'] ?? 0);
if ($unlockedAt <= 0 || (time() - $unlockedAt) > 900) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    exit('Setup authorization expired. Confirm your password to view the QR code.');
}

$pendingData = ck_two_factor_service()->getPendingProvisioningData($admin);
if ($pendingData === null || empty($pendingData['provisioning_uri'])) {
    http_response_code(404);
    header('Content-Type: text/plain; charset=utf-8');
    exit('No active pending 2FA setup found.');
}

try {
    $svg = ck_two_factor_service()->renderQrSvg($pendingData['provisioning_uri']);
} catch (\Throwable $e) {
    error_log('CyberKovai 2FA QR render error: ' . $e->getMessage());
    http_response_code(503);
    header('Content-Type: text/plain; charset=utf-8');
    exit('QR code rendering unavailable. Please enter the manual setup key.');
}

header('Content-Type: image/svg+xml; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0, private');
header('Pragma: no-cache');
header('X-Content-Type-Options: nosniff');
echo $svg;
exit;

