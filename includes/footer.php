<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$isServicesSubdir = (basename(dirname($_SERVER['PHP_SELF'])) === 'services');
$basePrefix = $isServicesSubdir ? '../' : '';
$currentScript = $currentScript ?? basename($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? '');
$activeSection = $activeSection ?? 'cyber';
$contactUrl = $contactUrl ?? ($basePrefix . 'contact.php');
$activeHomeUrl = $activeHomeUrl ?? ($basePrefix . 'index.php');
$aboutUrl = $aboutUrl ?? ($basePrefix . 'about.php');
$teamUrl = $teamUrl ?? ($basePrefix . 'team.php?section=' . $activeSection);
$ckShowTeam = function_exists('ck_get_settings') 
    ? filter_var(ck_get_settings()['show_team'] ?? true, FILTER_VALIDATE_BOOLEAN)
    : (defined('SITE_SHOW_TEAM') ? SITE_SHOW_TEAM : true);
$ckShowTestimonials = function_exists('ck_get_settings') 
    ? filter_var(ck_get_settings()['show_testimonials'] ?? true, FILTER_VALIDATE_BOOLEAN)
    : (defined('SITE_SHOW_TESTIMONIALS') ? SITE_SHOW_TESTIMONIALS : true);
if ($ckShowTestimonials && function_exists('ck_get_testimonials')) {
    $ckShowTestimonials = !empty(ck_get_testimonials(false));
}
?>
    <!-- ================= LIVE CHAT / HELP WIDGET (MATCHING SCREENSHOT) ================= -->
    <div class="chat-widget-badge" id="chatWidgetBadge" role="complementary" aria-label="Customer Support">
        <div class="chat-bubble-card">
            <button class="chat-close-btn" id="chatCloseBtn" aria-label="Close message">×</button>
            <div class="chat-avatar">
                <span class="chat-online-indicator"></span>
                🛡️
            </div>
            <div class="chat-text-area">
                <p>Welcome to <strong><?= sanitize_out(SITE_NAME) ?></strong>, if you have questions simply click here — <em>online and ready to help.</em></p>
                <a href="<?= $contactUrl ?>" class="chat-reply-action">
                    Chat with an Expert ➔
                </a>
            </div>
        </div>
        <button class="chat-toggle-pill" id="chatToggleBtn" aria-label="Open support chat">
            <span class="chat-pulse-ring"></span>
            <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            <span class="chat-online-label">Online</span>
        </button>
    </div>

    <!-- ================= FOOTER ================= -->
    <?php if (empty($hideFooter)): ?>
    <footer class="footer">

        <div class="container footer-grid">

            <div class="footer-brand">

                <a href="<?= $basePrefix ?>index.php" class="logo" title="Cyber Kovai Home">
                    <img src="<?= $basePrefix ?>assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                    <span>CYBER <strong>KOVAI</strong></span>
                </a>

                <?php if ($activeSection === 'forensics' || $currentScript === 'cyber-intelligence.php'): ?>
                <p>
                    CyberKovai provides confidential digital investigation services, court-admissible digital forensics, OSINT threat intelligence, and fraud prevention for legal counsel, enterprises, and individuals.
                </p>
                <?php else: ?>
                <p>
                    CyberKovai is an elite cybersecurity and intelligence consultancy delivering comprehensive penetration testing, cyber risk management, compliance auditing, and cloud security defense.
                </p>
                <?php endif; ?>

                <div class="social-links">
                    <a href="#" aria-label="LinkedIn">in</a>
                </div>

            </div>

            <?php if ($activeSection === 'forensics' || $currentScript === 'cyber-intelligence.php' || (isset($categorySlug) && $categorySlug === 'digital-investigations')): ?>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <a href="<?= $activeHomeUrl ?>">Home</a>
                <a href="<?= $aboutUrl ?>">About Us</a>
                <?php if ($ckShowTeam): ?>
                <a href="<?= $teamUrl ?>">Our Team</a>
                <?php endif; ?>
                <a href="<?= $basePrefix ?>cyber-intelligence.php?section=forensics#ci-services">Services</a>
                <?php if ($ckShowTestimonials): ?>
                <a href="<?= $basePrefix ?>cyber-intelligence.php?section=forensics#ci-testimonials">Testimonials</a>
                <?php endif; ?>
                <a href="<?= $contactUrl ?>">Contact Us</a>
            </div>

            <div class="footer-column">
                <h4>Our Services</h4>
                <?php 
                global $investigationServices;
                if (empty($investigationServices)) {
                    require_once __DIR__ . '/../config.php';
                }
                foreach ($investigationServices as $svc): 
                    $footerLabel = !empty($svc['footer_name']) ? $svc['footer_name'] : (!empty($svc['short']) ? $svc['short'] : $svc['title']);
                ?>
                    <a href="<?= $basePrefix ?>services/<?= sanitize_out($svc['slug']) ?>.php?section=forensics"><?= sanitize_out($footerLabel) ?></a>
                <?php endforeach; ?>
            </div>

            <div class="footer-column">
                <h4>Contact Information</h4>
                <p class="reach-item">📍 <?= sanitize_out(SITE_LOCATION) ?></p>
                <p class="reach-item">📞 <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" style="color:inherit;text-decoration:none;"><?= sanitize_out(SITE_PHONE) ?></a></p>
                <p class="reach-item">✉️ <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" style="color:inherit;text-decoration:none;"><?= sanitize_out(SITE_EMAIL) ?></a></p>
                <div style="margin-top:0.75rem;">
                    <a href="<?= $contactUrl ?>" class="btn primary-btn" style="padding: 9px 18px; font-size: 11px; letter-spacing: 0.05em;">
                        <span>ENQUIRE NOW ➔</span>
                    </a>
                </div>
            </div>
            <?php else: ?>
            <div class="footer-column">

                <h4>NAVIGATION</h4>

                <a href="<?= $activeHomeUrl ?>">Home</a>
                <a href="<?= $aboutUrl ?>">About Us</a>
                <?php if ($ckShowTeam): ?>
                <a href="<?= $teamUrl ?>">Our Team</a>
                <?php endif; ?>
                <a href="<?= $basePrefix ?>cyber-intelligence.php?section=cyber">Cyber Intelligence</a>
                <a href="<?= $basePrefix ?>digital-forensics.php?section=forensics">Digital Forensics</a>
                <a href="<?= $activeServicesUrl ?? ($basePrefix . 'services.php') ?>">Services</a>
                <a href="<?= $contactUrl ?>">Contact &amp; Consultation</a>

            </div>

            <?php
            $ckCyberVault = function_exists('ck_get_cyber_services') ? ck_get_cyber_services(true) : [];
            $getCyberFooterLabel = function($slug, $fallback) use ($ckCyberVault) {
                if (isset($ckCyberVault[$slug])) {
                    if (!empty($ckCyberVault[$slug]['footer_name'])) {
                        return $ckCyberVault[$slug]['footer_name'];
                    }
                    if (!empty($ckCyberVault[$slug]['nav_label'])) {
                        return $ckCyberVault[$slug]['nav_label'];
                    }
                    if (!empty($ckCyberVault[$slug]['title'])) {
                        return $ckCyberVault[$slug]['title'];
                    }
                }
                return $fallback;
            };
            ?>

            <div class="footer-column">

                <h4>APP &amp; NETWORK SEC</h4>

                <a href="<?= $basePrefix ?>services/vulnerability-assessment-penetration-testing.php"><?= sanitize_out($getCyberFooterLabel('vulnerability-assessment-penetration-testing', 'Comprehensive VAPT')) ?></a>
                <a href="<?= $basePrefix ?>services/web-application-penetration-testing.php"><?= sanitize_out($getCyberFooterLabel('web-application-penetration-testing', 'Web App Security Testing')) ?></a>
                <a href="<?= $basePrefix ?>services/mobile-app-penetration-testing.php"><?= sanitize_out($getCyberFooterLabel('mobile-app-penetration-testing', 'Mobile App Security')) ?></a>
                <a href="<?= $basePrefix ?>services/api-penetration-testing.php"><?= sanitize_out($getCyberFooterLabel('api-penetration-testing', 'REST & GraphQL API Testing')) ?></a>
                <a href="<?= $basePrefix ?>services/network-penetration-testing.php"><?= sanitize_out($getCyberFooterLabel('network-penetration-testing', 'Network Pen Testing')) ?></a>
                <a href="<?= $basePrefix ?>services/ai-security.php"><?= sanitize_out($getCyberFooterLabel('ai-security', 'AI Security & LLM Auditing')) ?></a>
                <a href="<?= $basePrefix ?>services/firewall-security-audit.php"><?= sanitize_out($getCyberFooterLabel('firewall-security-audit', 'Firewall Perimeter Audit')) ?></a>

            </div>


            <div class="footer-column">

                <h4>CLOUD &amp; ENTERPRISE</h4>

                <a href="<?= $basePrefix ?>services/cloud-configuration-review.php"><?= sanitize_out($getCyberFooterLabel('cloud-configuration-review', 'Cloud Security Posture (CSPM)')) ?></a>
                <a href="<?= $basePrefix ?>services/cloud-application-security-assessment-casa.php"><?= sanitize_out($getCyberFooterLabel('cloud-application-security-assessment-casa', 'Cloud CASA Assessment')) ?></a>
                <a href="<?= $basePrefix ?>services/cloud-container-security.php"><?= sanitize_out($getCyberFooterLabel('cloud-container-security', 'Container & K8s Security')) ?></a>
                <a href="<?= $basePrefix ?>services/aws-server-hardening.php"><?= sanitize_out($getCyberFooterLabel('aws-server-hardening', 'AWS & Azure Cloud Hardening')) ?></a>
                <a href="<?= $basePrefix ?>services/virtual-ciso-services.php"><?= sanitize_out($getCyberFooterLabel('virtual-ciso-services', 'Virtual CISO (vCISO) Advisory')) ?></a>
                <a href="<?= $basePrefix ?>services/erp-security-audit-assessment.php"><?= sanitize_out($getCyberFooterLabel('erp-security-audit-assessment', 'Enterprise ERP & SAP Audit')) ?></a>

            </div>


            <div class="footer-column">

                <h4>REACH US</h4>

                <p class="reach-item">📍 <?= sanitize_out(SITE_LOCATION) ?></p>
                <p class="reach-item">📞 <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" style="color:inherit;text-decoration:none;"><?= sanitize_out(SITE_PHONE) ?></a></p>
                <p class="reach-item">✉️ <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" style="color:inherit;text-decoration:none;"><?= sanitize_out(SITE_EMAIL) ?></a></p>
                <div style="margin-top:0.85rem;">
                    <a href="<?= $contactUrl ?>" class="btn primary-btn" style="padding: 10px 20px; font-size: 12.5px; font-weight: 700; letter-spacing: 0.05em; border-radius: 50px; display: inline-flex;">
                        <span>SCHEDULE AUDIT ➔</span>
                    </a>
                </div>

            </div>
            <?php endif; ?>

        </div>


        <?php 
        $isCyberSecurityPage = in_array($currentScript, ['digital-forensics.php', 'digitalforensics.php'], true) || (($activeSection ?? '') === 'cyber');
        if ($currentScript !== 'cyber-intelligence.php' && !$isCyberSecurityPage): 
        ?>
        <div class="container service-areas-bar">
            <h4>SERVICE COVERAGE</h4>
            <p><strong>India Hub:</strong> Coimbatore, Chennai, Bengaluru, Hyderabad, Mumbai, Delhi, Pune, and all major tech corridors.</p>
            <p><strong>Global Delivery:</strong> UAE (Abu Dhabi, Dubai), Saudi Arabia, Singapore, Australia, Germany, Canada, and US.</p>
        </div>
        <?php endif; ?>


        <div class="footer-bottom">

            <p>
                © <?= date('Y') ?> <?= sanitize_out(SITE_NAME) ?>. All Rights Reserved.
            </p>

            <div class="footer-legal-links" role="navigation" aria-label="Legal policies">
                <a href="<?= $basePrefix ?>privacy-policy.php" title="Privacy Policy">Privacy Policy</a>
                <span>|</span>
                <a href="<?= $basePrefix ?>terms-conditions.php" title="Terms &amp; Conditions">Terms &amp; Conditions</a>
                <span>|</span>
                <a href="<?= $basePrefix ?>security-disclosure.php" title="Security &amp; Vulnerability Disclosure">Security Disclosure</a>
            </div>

        </div>

    </footer>
    <?php endif; ?>


    <script src="<?= $basePrefix ?>script.js?v=<?= filemtime(__DIR__ . '/../script.js') ?>"></script>

</body>

</html>
