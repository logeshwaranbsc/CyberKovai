<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
require_once __DIR__ . '/../services-data.php';

$pageTitle = isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME . ' | ' . SITE_TAGLINE;
$pageDescription = isset($pageDescription) ? $pageDescription : 'Cyber Kovai - Elite Cybersecurity, Penetration Testing, Cyber Risk Management, and Digital Forensics.';

$isServicesSubdir = (basename(dirname($_SERVER['PHP_SELF'])) === 'services');
$basePrefix = $isServicesSubdir ? '../' : '';
$currentScript = basename($_SERVER['PHP_SELF']);

// Determine Active Section ('cyber' or 'forensics')
if (empty($activeSection)) {
    $paramSection = $_GET['section'] ?? $_GET['track'] ?? null;
    if ($paramSection) {
        if (in_array(strtolower($paramSection), ['forensics', 'investigation', 'digital-forensics'])) {
            $activeSection = 'forensics';
        } else {
            $activeSection = 'cyber';
        }
    } elseif ($currentScript === 'cyber-intelligence.php' || $currentScript === 'investigation.php') {
        $activeSection = 'forensics';
    } elseif (isset($categorySlug) && $categorySlug === 'digital-investigations') {
        $activeSection = 'forensics';
    } elseif (isset($_COOKIE['ck_section']) && in_array($_COOKIE['ck_section'], ['cyber', 'forensics'])) {
        $activeSection = $_COOKIE['ck_section'];
    } elseif (isset($_COOKIE['ck_track'])) {
        $activeSection = ($_COOKIE['ck_track'] === 'investigation' || $_COOKIE['ck_track'] === 'forensics') ? 'forensics' : 'cyber';
    } elseif ($currentScript === 'digital-forensics.php') {
        $activeSection = 'cyber';
    } else {
        $activeSection = 'cyber';
    }
}

if (!headers_sent()) {
    setcookie('ck_section', $activeSection, time() + 86400 * 30, '/');
}

// Dynamic URLs based on active section (Image 1 is Investigation, Image 2 is Cyber)
$activeHomeUrl = ($activeSection === 'cyber')
    ? $basePrefix . 'digital-forensics.php?section=cyber'
    : $basePrefix . 'cyber-intelligence.php?section=forensics';

$activeServicesUrl = ($activeSection === 'cyber')
    ? $basePrefix . 'digital-forensics.php?section=cyber#services'
    : $basePrefix . 'cyber-intelligence.php?section=forensics#ci-services';

$aboutUrl = $basePrefix . 'about.php?section=' . $activeSection;
$teamUrl = $basePrefix . 'team.php?section=' . $activeSection;
$contactUrl = $basePrefix . 'contact.php?section=' . $activeSection;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= sanitize_out($pageDescription) ?>">
    <title><?= sanitize_out($pageTitle) ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= $basePrefix ?>assets/images/logo.png">
    <link rel="shortcut icon" type="image/png" href="<?= $basePrefix ?>assets/images/logo.png">
    <link rel="apple-touch-icon" href="<?= $basePrefix ?>assets/images/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.css">
    <link rel="stylesheet" href="<?= $basePrefix ?>style.css?v=<?= filemtime(__DIR__ . '/../style.css') ?>">
    <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3@7.9.0/dist/d3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/topojson-client@3.1.0/dist/topojson-client.min.js"></script>
    <?php if (defined('ENABLE_RECAPTCHA') && ENABLE_RECAPTCHA): ?>
    <!-- Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <?php endif; ?>
</head>

<body class="<?= $bodyClass ?? '' ?>">

<?php if (empty($hideNavbar)): ?>
    <!-- ================= NAVBAR ================= -->

    <header class="navbar" id="siteNavbar">
        <div class="container nav-container">

            <a href="<?= $basePrefix ?>index.php" class="logo" title="Cyber Kovai - Selection Portal">
                <img src="<?= $basePrefix ?>assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                <span>CYBER <strong>KOVAI</strong></span>
            </a>

            <!-- NAVBAR MENU: HOME | SERVICES | ABOUT | OUR TEAM | CONTACT -->
            <nav class="nav-menu" id="navMenu">

                <!-- MOBILE DRAWER TOP BAR (Close Button & Logo) -->
                <div class="mobile-drawer-header">
                    <a href="<?= $basePrefix ?>index.php" class="mobile-drawer-brand" title="<?= sanitize_out(SITE_NAME) ?>">
                        <img src="<?= $basePrefix ?>assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                        <span>CYBER <strong>KOVAI</strong></span>
                    </a>
                    <button type="button" class="mobile-drawer-close" id="mobileDrawerClose" aria-label="Close navigation menu">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <!-- 1. HOME -->
                <a href="<?= $activeHomeUrl ?>" class="nav-main-link <?= (($activeSection === 'cyber' && $currentScript === 'digital-forensics.php') || ($activeSection === 'forensics' && in_array($currentScript, ['investigation.php', 'cyber-intelligence.php']))) ? 'active' : '' ?>">Home</a>

                <!-- 2. SERVICES (ACCORDION IN MOBILE / 4-COLUMN MEGA DROPDOWN IN DESKTOP) -->
                <?php if ($activeSection === 'cyber'): ?>
                    <!-- CYBER INTELLIGENCE SERVICES -->
                    <div class="nav-item has-dropdown services-nav-item <?= (($isServicesSubdir || $currentScript === 'service.php') && (!isset($categorySlug) || $categorySlug !== 'digital-investigations')) ? 'active' : '' ?>" id="servicesNavItem">
                        <a href="<?= $activeServicesUrl ?>" class="nav-link dropdown-toggle" id="servicesDropdownBtn" aria-expanded="false">
                            <span>Services</span>
                            <span class="nav-arrow" aria-hidden="true">➔</span>
                        </a>

                        <!-- MEGA DROPDOWN (4 HIGHLIGHTED COLUMNS USING CYBER KOVAI PALETTE) -->
                        <div class="mega-dropdown" id="servicesMegaMenu">
                            <div class="mega-dropdown-inner">

                                <!-- COLUMN 1: Application Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block" data-category="application-security">
                                        <div class="mega-cat-header" tabindex="0" role="button" aria-expanded="false">
                                            <h4 class="mega-col-title">Application Security</h4>
                                            <span class="mega-cat-arrow" aria-hidden="true">➔</span>
                                        </div>
                                        <ul class="mega-links-list">
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/vulnerability-assessment-penetration-testing.php">Comprehensive VAPT Assessment</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/web-application-penetration-testing.php">Web Application Security Testing</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/mobile-app-penetration-testing.php">Mobile Application Security (iOS &amp; Android)</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/api-penetration-testing.php">REST &amp; GraphQL API Security Testing</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/secure-source-code-review.php">Secure Code Audit &amp; SAST Review</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/ecommerce-security.php">E-Commerce &amp; Payment Security Audit</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/saas-security.php">SaaS Platform Security Assessment</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/devsecops.php">DevSecOps &amp; CI/CD Pipeline Assurance</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- COLUMN 2: Network Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block" data-category="network-security">
                                        <div class="mega-cat-header" tabindex="0" role="button" aria-expanded="false">
                                            <h4 class="mega-col-title">Network Security</h4>
                                            <span class="mega-cat-arrow" aria-hidden="true">➔</span>
                                        </div>
                                        <ul class="mega-links-list">
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/network-penetration-testing.php">External &amp; Internal Network Pen Testing</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/wireless-penetration-testing.php">Wireless &amp; Wi-Fi Security Assessment</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/firewall-security-audit.php">Firewall &amp; Perimeter Rulebase Audit</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- COLUMN 3: Cloud Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block" data-category="cloud-security">
                                        <div class="mega-cat-header" tabindex="0" role="button" aria-expanded="false">
                                            <h4 class="mega-col-title">Cloud Security</h4>
                                            <span class="mega-cat-arrow" aria-hidden="true">➔</span>
                                        </div>
                                        <ul class="mega-links-list">
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/cloud-configuration-review.php">Cloud Security Posture Assessment (CSPM)</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/cloud-application-security-assessment-casa.php">Cloud App Security Assessment (CASA Tier 2/3)</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/cloud-container-security.php">Docker &amp; Kubernetes Container Security</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/gcp-server-hardening.php">Google Cloud (GCP) Security Hardening</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/aws-server-hardening.php">Amazon Web Services (AWS) Hardening</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/azure-server-hardening.php">Microsoft Azure Cloud Hardening</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- COLUMN 4: Enterprise Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block" data-category="enterprise-security">
                                        <div class="mega-cat-header" tabindex="0" role="button" aria-expanded="false">
                                            <h4 class="mega-col-title">Enterprise Security</h4>
                                            <span class="mega-cat-arrow" aria-hidden="true">➔</span>
                                        </div>
                                        <ul class="mega-links-list">
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/virtual-cISO-services.php">Virtual CISO (vCISO) Advisory</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/black-box-testing.php">Zero-Knowledge Black Box Pen Testing</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/email-security-audit.php">Email Security &amp; Anti-Phishing Audit</a></li>
                                            <li class="submodule-item"><a href="<?= $basePrefix ?>services/server-hardening.php">Server &amp; Operating System Hardening</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/microsoft-365-security.php">Microsoft 365 &amp; Entra ID Security Review</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/erp-security-audit-assessment.php">Enterprise ERP &amp; SAP Security Audit</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/security-architecture-review.php">Zero-Trust Security Architecture Review</a></li>
                                            <li class="submodule-item submodule-extra"><a href="<?= $basePrefix ?>services/wordpress-security.php">CMS &amp; Web Platform Security Hardening</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- DIGITAL INVESTIGATION & FORENSICS SERVICES DROPDOWN -->
                    <div class="nav-item has-dropdown services-nav-item <?= ($currentScript === 'cyber-intelligence.php' || (isset($categorySlug) && $categorySlug === 'digital-investigations')) ? 'active' : '' ?>" id="servicesNavItem">
                        <a href="<?= $activeServicesUrl ?>" class="nav-link dropdown-toggle" id="servicesDropdownBtn" aria-expanded="false">
                            <span>Services</span>
                            <span class="nav-arrow" aria-hidden="true">➔</span>
                        </a>

                        <!-- FORENSICS DROPDOWN (8 SPECIALIZED PRACTICES) -->
                        <div class="mega-dropdown forensics-mega-dropdown" id="servicesMegaMenu">
                            <ul class="mega-links-list forensics-links-list">
                                <?php 
                                global $investigationServices;
                                if (!isset($investigationServices) || empty($investigationServices)) {
                                    require_once __DIR__ . '/../config.php';
                                }
                                foreach ($investigationServices as $idx => $svc): 
                                ?>
                                <li class="submodule-item">
                                    <a href="<?= $basePrefix ?>services/<?= sanitize_out($svc['slug']) ?>.php?section=forensics">
                                        <?= sanitize_out($svc['title']) ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                <?php endif; ?>

                <!-- 3. ABOUT (ACCORDION IN MOBILE / DROPDOWN IN DESKTOP) -->
                <div class="nav-item has-dropdown about-nav-item <?= in_array($currentScript, ['about.php', 'team.php']) ? 'active' : '' ?>" id="aboutNavItem">
                    <a href="<?= $aboutUrl ?>" class="nav-link dropdown-toggle" id="aboutDropdownBtn" aria-expanded="false">
                        <span><?= ($activeSection === 'forensics') ? 'About Us' : 'About' ?></span>
                        <svg class="dropdown-arrow-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6,9 12,15 18,9"/></svg>
                        <span class="nav-arrow" aria-hidden="true">➔</span>
                    </a>

                    <!-- ABOUT DROPDOWN / SUBMODULES -->
                    <div class="about-dropdown" id="aboutMegaMenu">
                        <ul class="mega-links-list about-links-list">
                            <li class="submodule-item">
                                <a href="<?= $aboutUrl ?>" class="<?= ($currentScript === 'about.php') ? 'active' : '' ?>">
                                    <?= ($activeSection === 'forensics') ? 'About Us' : 'About CyberKovai' ?>
                                </a>
                            </li>
                            <li class="submodule-item">
                                <a href="<?= $teamUrl ?>" class="<?= ($currentScript === 'team.php') ? 'active' : '' ?>">
                                    Our Team
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 4. CONTACT -->
                <a href="<?= $contactUrl ?>" class="nav-main-link <?= ($currentScript === 'contact.php') ? 'active' : '' ?>"><?= ($activeSection === 'forensics') ? 'Contact Us' : 'Contact' ?></a>

                <!-- QUICK CONTACT SECTION (MATCHING SCREENSHOT 1 & 2) -->
                <div class="mobile-drawer-quick-contact">
                    <div class="quick-contact-header">
                        <h4 class="quick-contact-title">Quick Contact</h4>
                        <p class="quick-contact-subtitle">Talk to our team</p>
                    </div>

                    <a href="mailto:<?= SITE_EMAIL ?>" class="qc-card qc-card-email">
                        <span class="qc-label">Email</span>
                        <span class="qc-value"><?= SITE_EMAIL ?></span>
                    </a>

                    <a href="tel:<?= SITE_PHONE_TEL ?>" class="qc-card qc-card-phone">
                        <span class="qc-label">Phone</span>
                        <span class="qc-value"><?= SITE_PHONE ?></span>
                    </a>

                    <div class="qc-bottom-row">
                        <div class="qc-social-card">
                            <span class="qc-label">Social</span>
                            <div class="qc-social-icons">
                                <a href="https://linkedin.com" target="_blank" rel="noopener" aria-label="LinkedIn">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 10.9v8.37H9.2V10.9H6.46M7.83 6.45c-.88 0-1.6.72-1.6 1.6s.72 1.6 1.6 1.6 1.6-.72 1.6-1.6-.72-1.6-1.6-1.6Z"/></svg>
                                </a>
                                <a href="https://twitter.com" target="_blank" rel="noopener" aria-label="Twitter">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                </a>
                                <a href="https://instagram.com" target="_blank" rel="noopener" aria-label="Instagram">
                                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                </a>
                            </div>
                        </div>

                        <a href="<?= $contactUrl ?>" class="qc-cta-button">
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
                            <span>Message</span>
                        </a>
                    </div>
                </div>
            </nav>

            <div class="nav-actions">
               



                <a href="<?= $contactUrl ?>" class="nav-button">
                    <?= ($activeSection === 'forensics') ? 'Consult Our Experts' : 'Confidential Consultation' ?>
                </a>

                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
                    ☰
                </button>
            </div>

        </div>
    </header>
<?php endif; ?>
