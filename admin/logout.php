<?php
/**
 * Cyber Kovai - Admin Logout
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_logout();
ck_set_flash('info', 'You have been signed out safely.');
header('Location: login.php');
exit;

