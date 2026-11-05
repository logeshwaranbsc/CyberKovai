<?php
/**
 * Cyber Kovai - Admin Dashboard Overview
 */

$adminPageTitle = 'Dashboard Overview';
require_once __DIR__ . '/includes/header.php';

$settings = ck_get_settings();
$cyberServices = ck_get_cyber_services(true);
$invServices = ck_get_investigation_services(true);
$testimonials = ck_get_testimonials(true);
$clients = ck_get_clients('all', true);
$accreds = ck_get_accreditations('all', true);
$teamMembers = ck_get_team_members(true);
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Security Operations Center Dashboard</h1>
        <p class="page-header-desc">Manage services, testimonials, leadership team, and site-wide contact info stored in secure file storage.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="services-cyber.php?action=add" class="btn btn-primary btn-sm">
            <span>+</span> Add Cyber Service
        </a>
        <a href="services-investigation.php?action=add" class="btn btn-secondary btn-sm">
            <span>+</span> Add Investigation Service
        </a>
    </div>
</div>

<!-- ================= STATS CARDS ================= -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Cyber Services</span>
            <div class="stat-icon-wrap">🛡️</div>
        </div>
        <div class="stat-value"><?= count($cyberServices) ?></div>
        <div class="stat-subtext">VAPT, Cloud, Network, Enterprise</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Investigation Services</span>
            <div class="stat-icon-wrap">🔍</div>
        </div>
        <div class="stat-value"><?= count($invServices) ?></div>
        <div class="stat-subtext">Digital forensics, OSINT, Fraud</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Client Testimonials</span>
            <div class="stat-icon-wrap">⭐</div>
        </div>
        <div class="stat-value"><?= count($testimonials) ?></div>
        <div class="stat-subtext">Published client reviews</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Our Team</span>
            <div class="stat-icon-wrap">👥</div>
        </div>
        <div class="stat-value"><?= count($teamMembers) ?></div>
        <div class="stat-subtext" style="display: flex; align-items: center; justify-content: space-between;">
            <span>Security architects</span>
            <?php if (!empty($settings['show_team'])): ?>
                <span class="status-pill active" style="font-size: 0.68rem; padding: 0.1rem 0.45rem;">Visible</span>
            <?php else: ?>
                <span class="status-pill inactive" style="font-size: 0.68rem; padding: 0.1rem 0.45rem; background: rgba(255,171,0,0.15); color: #ffab00;">Hidden</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ================= 2-COLUMN DASHBOARD GRID ================= -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(360px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">

    <!-- Contact & Application Information Card -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Live Application Contact Details</h3>
            <a href="settings.php" class="btn btn-secondary btn-sm">Edit Contact Info ➔</a>
        </div>
        <div class="admin-card-body">
            <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                These values are propagated throughout headers, footers, contact pages, and service inquiry blocks.
            </p>
            
            <div style="display: flex; flex-direction: column; gap: 0.9rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Primary Email</span>
                    <strong style="font-size: 0.9rem; color: var(--accent-purple-light);"><?= htmlspecialchars($settings['site_email'] ?? '') ?></strong>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Primary Phone</span>
                    <strong style="font-size: 0.9rem; color: var(--text-primary);"><?= htmlspecialchars($settings['site_phone'] ?? '') ?></strong>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Dial Link (tel:)</span>
                    <code style="font-size: 0.85rem; color: var(--accent-cyan);"><?= htmlspecialchars($settings['site_phone_tel'] ?? '') ?></code>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Location</span>
                    <span style="font-size: 0.88rem; color: var(--text-secondary);"><?= htmlspecialchars($settings['site_location'] ?? '') ?></span>
                </div>

                <div style="display: flex; align-items: flex-start; justify-content: space-between;">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Full Address</span>
                    <span style="font-size: 0.85rem; color: var(--text-secondary); text-align: right; max-width: 65%;"><?= htmlspecialchars($settings['site_address'] ?? '') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation & Storage Diagnostics -->
    <div class="admin-card" style="margin-bottom: 0;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Storage &amp; System Health</h3>
            <span class="status-pill active">JSON Vault Active</span>
        </div>
        <div class="admin-card-body">
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Storage Engine</span>
                    <span style="font-size: 0.88rem; font-weight: 600; color: #fff;">File Storage (JSON + Exclusive Locks)</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Data Vault Directory</span>
                    <code style="font-size: 0.8rem; color: var(--accent-purple-light);">/data/*.json</code>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Uploads Directory</span>
                    <code style="font-size: 0.8rem; color: var(--accent-cyan);">/data/uploads/</code>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(158,62,255,0.1);">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">Direct Web Access</span>
                    <span class="status-pill active">Blocked via .htaccess</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <span style="font-size: 0.82rem; color: var(--text-muted);">PHP Version</span>
                    <span style="font-size: 0.85rem; color: var(--text-secondary);"><?= PHP_VERSION ?></span>
                </div>
            </div>

            <div style="margin-top: 1.5rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <a href="services-cyber.php" class="btn btn-secondary btn-sm">Manage Cyber Services ➔</a>
                <a href="services-investigation.php" class="btn btn-secondary btn-sm">Manage Investigation ➔</a>
                <a href="clients.php" class="btn btn-secondary btn-sm">Manage Clients &amp; Logos ➔</a>
                <a href="accreditations.php" class="btn btn-secondary btn-sm">Manage Accreditations (<?= count($accreds) ?>) ➔</a>
                <a href="testimonials.php" class="btn btn-secondary btn-sm">Manage Testimonials ➔</a>
                <a href="team.php" class="btn btn-secondary btn-sm">Manage Team ➔</a>
            </div>
        </div>
    </div>

</div>

<!-- ================= RECENT INVESTIGATION SERVICES TABLE ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Investigation Services Overview</h3>
        <a href="services-investigation.php" class="btn btn-secondary btn-sm">View All (<?= count($invServices) ?>) ➔</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Image</th>
                    <th>Service Name</th>
                    <th>Short Title</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (array_slice($invServices, 0, 5) as $svc): ?>
                <tr>
                    <td>
                        <img src="../<?= htmlspecialchars($svc['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg') ?>" alt="" class="table-thumbnail">
                    </td>
                    <td>
                        <span class="cell-title"><?= htmlspecialchars($svc['title']) ?></span>
                        <span class="cell-subtitle">Slug: <?= htmlspecialchars($svc['slug']) ?></span>
                    </td>
                    <td>
                        <span class="category-tag"><?= htmlspecialchars($svc['short'] ?? '') ?></span>
                    </td>
                    <td>
                        <span class="status-pill <?= ($svc['status'] ?? 'active') === 'active' ? 'active' : 'inactive' ?>">
                            <?= htmlspecialchars($svc['status'] ?? 'active') ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div class="action-btns-group" style="justify-content: flex-end;">
                            <a href="services-investigation.php?action=edit&slug=<?= urlencode($svc['slug']) ?>" class="btn-action edit">Edit</a>
                            <a href="../services/<?= htmlspecialchars($svc['slug']) ?>.php?section=forensics" target="_blank" class="btn-action view">Preview</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

