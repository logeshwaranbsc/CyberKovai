<?php
/**
 * Cyber Kovai - Site & Contact Settings Management
 * Allows adding and editing the email ID, phone numbers, location, and address across the entire application.
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security session token expired. Please try again.');
    } else {
        $saved = ck_save_settings($_POST);
        if ($saved) {
            ck_set_flash('success', 'Application contact information and site settings successfully updated! Changes are live across all pages, footers, headers, and contact forms.');
        } else {
            ck_set_flash('error', 'Failed to write settings to file storage. Check folder permissions.');
        }
        header('Location: settings.php');
        exit;
    }
}

$settings = ck_get_settings();

$adminPageTitle = 'Site & Contact Settings';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Application Contact Info &amp; Site Settings</h1>
        <p class="page-header-desc">
            Edit the official email ID, phone numbers, and physical address. Updates take effect immediately throughout all headers, footers, contact portals, and notification services.
        </p>
    </div>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Global Contact &amp; Business Information</h3>
        <span class="status-pill active">File Storage Synced</span>
    </div>
    <div class="admin-card-body">

        <form method="POST" action="settings.php">
            <?= ck_csrf_field() ?>

            <!-- Contact Numbers Section -->
            <div style="margin-bottom: 2rem;">
                <h4 style="font-size: 1rem; color: var(--accent-purple-light); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📞</span> Phone Numbers
                </h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Configure customer-facing display numbers and device auto-dial link values.
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="site_phone" class="form-label">
                            Primary Phone (Display Format) <span class="required">*</span>
                        </label>
                        <input type="text" id="site_phone" name="site_phone" class="form-control" required placeholder="+91 63820 19821" value="<?= htmlspecialchars($settings['site_phone'] ?? '') ?>">
                        <span class="form-help">Formatted for visual display in navbar, footer, and buttons (e.g. +91 63820 19821)</span>
                    </div>

                    <div class="form-group">
                        <label for="site_phone_tel" class="form-label">
                            Click-to-Call Number (tel: Protocol) <span class="required">*</span>
                        </label>
                        <input type="text" id="site_phone_tel" name="site_phone_tel" class="form-control" required placeholder="+916382019821" value="<?= htmlspecialchars($settings['site_phone_tel'] ?? '') ?>">
                        <span class="form-help">E.164 international digits without spaces, used for mobile dialer links (e.g. +916382019821)</span>
                    </div>

                    <div class="form-group col-full">
                        <label for="site_phone_alt" class="form-label">
                            Secondary / WhatsApp / Signal Number
                        </label>
                        <input type="text" id="site_phone_alt" name="site_phone_alt" class="form-control" placeholder="+91 98765 43210" value="<?= htmlspecialchars($settings['site_phone_alt'] ?? '') ?>">
                        <span class="form-help">Optional alternative hotline or WhatsApp contact number</span>
                    </div>
                </div>
            </div>

            <!-- Email Address Section -->
            <div style="margin-bottom: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <h4 style="font-size: 1rem; color: var(--accent-purple-light); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>✉️</span> Email Address
                </h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Official inquiries, forensic report requests, and automated contact form recipient.
                </p>

                <div class="form-grid">
                    <div class="form-group col-full">
                        <label for="site_email" class="form-label">
                            Primary Official Email ID <span class="required">*</span>
                        </label>
                        <input type="email" id="site_email" name="site_email" class="form-control" required placeholder="info@cyberkovai.com" value="<?= htmlspecialchars($settings['site_email'] ?? '') ?>">
                        <span class="form-help">Displayed in all headers and footers; receiving inbox for website inquiries.</span>
                    </div>
                </div>
            </div>

            <!-- Address & Location Section -->
            <div style="margin-bottom: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <h4 style="font-size: 1rem; color: var(--accent-purple-light); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>📍</span> Address &amp; Geographical Location
                </h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Geographical hub and full corporate office location.
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="site_location" class="form-label">
                            City / Region Headline <span class="required">*</span>
                        </label>
                        <input type="text" id="site_location" name="site_location" class="form-control" required placeholder="Coimbatore, Tamil Nadu, India" value="<?= htmlspecialchars($settings['site_location'] ?? '') ?>">
                        <span class="form-help">Short location tag displayed in footer items &amp; badge pills.</span>
                    </div>

                    <div class="form-group">
                        <label for="working_hours" class="form-label">
                            Operational / Working Hours
                        </label>
                        <input type="text" id="working_hours" name="working_hours" class="form-control" placeholder="24/7 Incident Response & Emergency Support" value="<?= htmlspecialchars($settings['working_hours'] ?? '') ?>">
                        <span class="form-help">Operating availability notice.</span>
                    </div>

                    <div class="form-group col-full">
                        <label for="site_address" class="form-label">
                            Full Physical Office Address <span class="required">*</span>
                        </label>
                        <textarea id="site_address" name="site_address" rows="3" class="form-control" required placeholder="Full Street Address, IT Park, City, PIN"><?= htmlspecialchars($settings['site_address'] ?? '') ?></textarea>
                        <span class="form-help">Detailed physical headquarters address.</span>
                    </div>
                </div>
            </div>

            <!-- General Application Identity Section -->
            <div style="margin-bottom: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <h4 style="font-size: 1rem; color: var(--accent-purple-light); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>🛡️</span> Application Identity &amp; Social Links
                </h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Site title, brand tagline, and social profile links.
                </p>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="site_name" class="form-label">
                            Site / Brand Name <span class="required">*</span>
                        </label>
                        <input type="text" id="site_name" name="site_name" class="form-control" required placeholder="Cyber Kovai" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="site_tagline" class="form-label">
                            Brand Tagline
                        </label>
                        <input type="text" id="site_tagline" name="site_tagline" class="form-control" placeholder="Verified Facts, Confident Decisions." value="<?= htmlspecialchars($settings['site_tagline'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="social_linkedin" class="form-label">
                            LinkedIn URL
                        </label>
                        <input type="url" id="social_linkedin" name="social_linkedin" class="form-control" placeholder="https://linkedin.com/company/cyberkovai" value="<?= htmlspecialchars($settings['social_linkedin'] ?? '') ?>">
                    </div>

                    <div class="form-group">
                        <label for="social_twitter" class="form-label">
                            Twitter / X URL
                        </label>
                        <input type="url" id="social_twitter" name="social_twitter" class="form-control" placeholder="https://twitter.com/cyberkovai" value="<?= htmlspecialchars($settings['social_twitter'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Website Features & Team Visibility Section -->
            <div style="margin-bottom: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                <h4 style="font-size: 1rem; color: var(--accent-purple-light); margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>👥</span> Our Team Page &amp; Navigation Visibility
                </h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.25rem;">
                    Choose whether the "Our Team" page and navigation links should be publicly visible or completely hidden across the website.
                </p>

                <div class="form-grid">
                    <div class="form-group col-full">
                        <label for="show_team" class="form-label">
                            Our Team Section Visibility Status <span class="required">*</span>
                        </label>
                        <select id="show_team" name="show_team" class="form-control" style="font-weight: 600;">
                            <option value="1" <?= (!empty($settings['show_team'])) ? 'selected' : '' ?>>
                                Visible — Show "Our Team" in header menu, footer links, and allow /team.php
                            </option>
                            <option value="0" <?= (empty($settings['show_team'])) ? 'selected' : '' ?>>
                                Hidden — Hide "Our Team" from all navigation menus &amp; redirect visitors
                            </option>
                        </select>
                        <span class="form-help">
                            When set to <strong>Hidden</strong>, "Our Team" is automatically hidden from all header dropdowns and footers, and any direct request to <code>team.php</code> is smoothly redirected to the About page.
                        </span>
                    </div>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 1rem;">
                <a href="index.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save All Site Settings &amp; Contact Info
                </button>
            </div>

        </form>

    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

