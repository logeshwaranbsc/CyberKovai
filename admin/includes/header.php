<?php
/**
 * Cyber Kovai - Admin Header & Layout Framework
 */

require_once __DIR__ . '/auth.php';

if (empty($allowGuest)) {
    ck_admin_require_login();
}

$currentUser = ck_admin_current_user();
$currentFile = basename($_SERVER['PHP_SELF']);

// Retrieve counts for sidebar badges
$cyberServicesCount = count(ck_get_cyber_services(true));
$invServicesCount   = count(ck_get_investigation_services(true));
$testimonialsCount  = count(ck_get_testimonials(true));
$teamCount          = count(ck_get_team_members(true));

$pageTitle = $adminPageTitle ?? 'Admin Console';
$flash = ck_get_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle) ?> | Cyber Kovai Admin</title>
    <link rel="icon" type="image/png" href="../assets/images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/admin.css?v=<?= filemtime(__DIR__ . '/../assets/admin.css') ?>">
</head>
<body class="admin-body">

    <!-- ================= SIDEBAR ================= -->
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="sidebar-header">
            <a href="index.php" class="sidebar-logo">
                <img src="../assets/images/logo.png" alt="Cyber Kovai">
                <span class="logo-text">Cyber <strong>Kovai</strong></span>
            </a>
            <span class="sidebar-badge">SOC</span>
        </div>

        <nav class="sidebar-nav">
            <div class="nav-section-title">Overview</div>
            <a href="index.php" class="sidebar-link <?= ($currentFile === 'index.php') ? 'active' : '' ?>">
                <span class="link-icon">📊</span>
                <span>Dashboard</span>
            </a>

            <div class="nav-section-title">Services Management</div>
            <a href="services-cyber.php" class="sidebar-link <?= ($currentFile === 'services-cyber.php') ? 'active' : '' ?>">
                <span class="link-icon">🛡️</span>
                <span>Cyber Services</span>
                <span class="badge-count"><?= $cyberServicesCount ?></span>
            </a>
            <a href="services-investigation.php" class="sidebar-link <?= ($currentFile === 'services-investigation.php') ? 'active' : '' ?>">
                <span class="link-icon">🔍</span>
                <span>Investigation Services</span>
                <span class="badge-count"><?= $invServicesCount ?></span>
            </a>

            <div class="nav-section-title">Content &amp; Leadership</div>
            <a href="testimonials.php" class="sidebar-link <?= ($currentFile === 'testimonials.php') ? 'active' : '' ?>">
                <span class="link-icon">⭐</span>
                <span>Testimonials</span>
                <span class="badge-count"><?= $testimonialsCount ?></span>
            </a>
            <a href="team.php" class="sidebar-link <?= ($currentFile === 'team.php') ? 'active' : '' ?>">
                <span class="link-icon">👥</span>
                <span>Our Team</span>
                <span class="badge-count"><?= $teamCount ?></span>
            </a>

            <div class="nav-section-title">Configuration</div>
            <a href="settings.php" class="sidebar-link <?= ($currentFile === 'settings.php') ? 'active' : '' ?>">
                <span class="link-icon">⚙️</span>
                <span>Site &amp; Contact Info</span>
            </a>
            <a href="profile.php" class="sidebar-link <?= ($currentFile === 'profile.php') ? 'active' : '' ?>">
                <span class="link-icon">👤</span>
                <span>Admin Profile</span>
            </a>

            <div class="nav-section-title">Session</div>
            <a href="logout.php" class="sidebar-link sidebar-link-logout" title="Sign out of Admin Console">
                <span class="link-icon">🚪</span>
                <span>Log Out</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <a href="profile.php" class="admin-user-pill" title="Edit Profile">
                <div class="admin-avatar-small">
                    <?= strtoupper(substr($currentUser['username'] ?? 'A', 0, 1)) ?>
                </div>
                <div class="admin-user-info">
                    <div class="admin-name"><?= htmlspecialchars($currentUser['username'] ?? 'Admin') ?></div>
                    <div class="admin-role">Superadmin</div>
                </div>
            </a>
            <a href="logout.php" class="btn-sidebar-logout" title="Sign Out">
                <span>🚪</span>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT WRAPPER ================= -->
    <div class="admin-main-wrap">

        <!-- ================= TOPBAR ================= -->
        <header class="admin-topbar">
            <div style="display: flex; align-items: center;">
                <button type="button" class="mobile-menu-toggle" id="mobileSidebarToggle" aria-label="Toggle Sidebar">
                    ☰
                </button>
                <div class="topbar-breadcrumbs">
                    <a href="index.php">Admin</a>
                    <span class="sep">/</span>
                    <span class="current"><?= htmlspecialchars($pageTitle) ?></span>
                </div>
            </div>

            <div class="topbar-actions">
                <a href="../index.php" target="_blank" rel="noopener" class="btn-view-site" title="Open live website in new tab">
                    <span>🌐</span> View Live Site ➔
                </a>
                <a href="logout.php" class="btn-topbar-logout" title="Sign Out of Admin Console">
                    <span>🚪</span> Log Out
                </a>
            </div>
        </header>

        <!-- ================= CONTENT AREA ================= -->
        <main class="admin-content">

            <?php if (!empty($flash)): ?>
            <div class="flash-alert <?= htmlspecialchars($flash['type']) ?>">
                <span>
                    <strong><?= ($flash['type'] === 'success') ? '✓ Success:' : (($flash['type'] === 'error') ? '⚠ Error:' : 'Notice:') ?></strong>
                    <?= htmlspecialchars($flash['message']) ?>
                </span>
                <button type="button" class="flash-close-btn" aria-label="Close">&times;</button>
            </div>
            <?php endif; ?>

