<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$isServicesSubdir = (basename(dirname($_SERVER['PHP_SELF'])) === 'services');
$basePrefix = $isServicesSubdir ? '../' : '';
$currentScript = $currentScript ?? basename($_SERVER['SCRIPT_NAME'] ?? $_SERVER['PHP_SELF'] ?? '');
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

                <?php if ($currentScript === 'cyber-intelligence.php'): ?>
                <p>
                    CyberKovai provides professional cyber intelligence services, investigative digital forensics and security advisory for organizations worldwide and individuals.
                </p>
                <?php else: ?>
                <p>
                    CyberKovai is an elite cybersecurity and intelligence consultancy delivering comprehensive penetration testing, cyber risk management, compliance auditing, and digital forensics.
                </p>
                <?php endif; ?>

                <div class="social-links">
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Twitter">x</a>
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="LinkedIn">in</a>
                </div>

            </div>

            <?php if ($currentScript === 'cyber-intelligence.php'): ?>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <a href="<?= $activeHomeUrl ?>">Home</a>
                <a href="<?= $aboutUrl ?>">About Us</a>
                <a href="#ci-services">Services</a>
                <a href="#ci-testimonials">Testimonials</a>
                <a href="#contact">Contact Us</a>
            </div>

            <div class="footer-column">
                <h4>Our Services</h4>
                <a href="#ci-services">Threat Intelligence Monitoring</a>
                <a href="#ci-services">Digital Forensics Investigation</a>
                <a href="#ci-services">Cyber Risk Assessment</a>
                <a href="#ci-services">Social Media Investigation</a>
                <a href="#ci-services">Data & Information Security</a>
                <a href="#ci-services">Cyber Security Advisory</a>
                <a href="#ci-services">Fraud & Deception Prevention</a>
            </div>

            <div class="footer-column">
                <h4>Contact Information</h4>
                <p class="reach-item">📞 +91 87541 43015</p>
                <p class="reach-item">✉️ info@cyberkovai.com</p>
                <p class="reach-item">📍 Coimbatore, India</p>
                <div style="margin-top:1rem;">
                    <a href="#contact" class="btn primary-btn" style="padding: 10px 22px; font-size: 12px; font-weight:700; border-radius:50px; display:inline-flex;">
                        <span>Report an Incident</span>
                    </a>
                </div>
            </div>
            <?php elseif ($activeSection === 'forensics' || (isset($categorySlug) && $categorySlug === 'digital-investigations')): ?>
            <div class="footer-column">
                <h4>Quick Links</h4>
                <a href="<?= $activeHomeUrl ?>">Home</a>
                <a href="<?= $aboutUrl ?>">About Us</a>
                <a href="<?= $basePrefix ?>cyber-intelligence.php?section=forensics#ci-services">Services</a>
                <a href="<?= $basePrefix ?>cyber-intelligence.php?section=forensics#ci-testimonials">Testimonial</a>
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
                ?>
                    <a href="<?= $basePrefix ?>services/<?= sanitize_out($svc['slug']) ?>.php"><?= sanitize_out($svc['title']) ?></a>
                <?php endforeach; ?>
            </div>

            <div class="footer-column">
                <h4>Contact Information</h4>
                <p class="reach-item">📍 Coimbatore - 641 017.</p>
                <p class="reach-item">📞 +91 63820 19821</p>
                <p class="reach-item">✉️ info@cyberkovai.com</p>
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
                <a href="<?= $basePrefix ?>cyber-intelligence.php?section=cyber">Cyber Intelligence</a>
                <a href="<?= $basePrefix ?>digital-forensics.php?section=forensics">Digital Forensics</a>
                <a href="<?= $activeServicesUrl ?>">Services</a>
                <a href="<?= $contactUrl ?>">Contact &amp; Consultation</a>

            </div>


            <div class="footer-column">

                <h4>APP &amp; NETWORK SEC</h4>

                <a href="<?= $basePrefix ?>services/vulnerability-assessment-penetration-testing.php">Comprehensive VAPT</a>
                <a href="<?= $basePrefix ?>services/web-application-penetration-testing.php">Web App Security Testing</a>
                <a href="<?= $basePrefix ?>services/mobile-app-penetration-testing.php">Mobile App Security</a>
                <a href="<?= $basePrefix ?>services/api-penetration-testing.php">REST &amp; GraphQL API Testing</a>
                <a href="<?= $basePrefix ?>services/network-penetration-testing.php">Network Pen Testing</a>
                <a href="<?= $basePrefix ?>services/firewall-security-audit.php">Firewall Perimeter Audit</a>

            </div>


            <div class="footer-column">

                <h4>CLOUD &amp; ENTERPRISE</h4>

                <a href="<?= $basePrefix ?>services/cloud-configuration-review.php">Cloud Security Posture (CSPM)</a>
                <a href="<?= $basePrefix ?>services/cloud-application-security-assessment-casa.php">Cloud CASA Assessment</a>
                <a href="<?= $basePrefix ?>services/cloud-container-security.php">Container &amp; K8s Security</a>
                <a href="<?= $basePrefix ?>services/aws-server-hardening.php">AWS &amp; Azure Cloud Hardening</a>
                <a href="<?= $basePrefix ?>services/virtual-ciso-services.php">Virtual CISO (vCISO) Advisory</a>
                <a href="<?= $basePrefix ?>services/erp-security-audit-assessment.php">Enterprise ERP &amp; SAP Audit</a>

            </div>


            <div class="footer-column">

                <h4>REACH US</h4>

                <p class="reach-item">📍 <?= sanitize_out(SITE_LOCATION) ?></p>
                <p class="reach-item">📞 <?= sanitize_out(SITE_PHONE) ?></p>
                <p class="reach-item">✉️ <?= sanitize_out(SITE_EMAIL) ?></p>
                <div style="margin-top:0.75rem;">
                    <a href="<?= $contactUrl ?>" class="btn primary-btn" style="padding: 9px 18px; font-size: 11px; letter-spacing: 0.05em;">
                        <span>SCHEDULE AUDIT ➔</span>
                    </a>
                </div>

            </div>
            <?php endif; ?>

        </div>


        <?php if ($currentScript !== 'cyber-intelligence.php'): ?>
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

            <div>
                <a href="#">Privacy Policy</a>
                <span>|</span>
                <a href="#">Terms &amp; Conditions</a>
                <?php if ($currentScript !== 'cyber-intelligence.php'): ?>
                <span>|</span>
                <a href="#">Security Disclosure</a>
                <?php endif; ?>
            </div>

        </div>

    </footer>
    <?php endif; ?>


    <script src="<?= $basePrefix ?>script.js?v=<?= filemtime(__DIR__ . '/../script.js') ?>"></script>

</body>

</html>
