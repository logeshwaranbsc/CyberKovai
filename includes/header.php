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
</head>

<body class="<?= $bodyClass ?? '' ?>">

    <!-- ================= NAVBAR ================= -->

    <header class="navbar" id="siteNavbar">
        <div class="container nav-container">

            <a href="<?= $basePrefix ?>index.php" class="logo" title="Cyber Kovai - Selection Portal">
                <img src="<?= $basePrefix ?>assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                <span>CYBER <strong>KOVAI</strong></span>
            </a>

            <!-- NAVBAR MENU: STRICTLY HOME | ABOUT | SERVICES | CONTACT -->
            <nav class="nav-menu" id="navMenu">

                <!-- 1. HOME -->
                <a href="<?= $activeHomeUrl ?>" class="<?= (($activeSection === 'cyber' && $currentScript === 'digital-forensics.php') || ($activeSection === 'forensics' && in_array($currentScript, ['investigation.php', 'cyber-intelligence.php']))) ? 'active' : '' ?>">Home</a>

                <!-- 2. ABOUT (SERVICES-STYLE DROPDOWN WITH ABOUT & OUR TEAM) -->
                <div class="nav-item has-dropdown about-nav-item <?= in_array($currentScript, ['about.php', 'team.php']) ? 'active' : '' ?>">
                    <a href="<?= $aboutUrl ?>" class="nav-link dropdown-toggle" id="aboutDropdownBtn" aria-expanded="false">
                        <?= ($activeSection === 'forensics') ? 'About Us' : 'About' ?>
                        <svg class="dropdown-arrow-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6,9 12,15 18,9"/></svg>
                    </a>

                    <!-- ABOUT DROPDOWN (CENTERED UNDER ABOUT LINK) -->
                    <div class="about-dropdown" id="aboutMegaMenu">
                        <ul class="mega-links-list about-links-list">
                            <li>
                                <a href="<?= $aboutUrl ?>" class="<?= ($currentScript === 'about.php') ? 'active' : '' ?>">
                                    <?= ($activeSection === 'forensics') ? 'About Us' : 'About CyberKovai' ?>
                                </a>
                            </li>
                            <li>
                                <a href="<?= $teamUrl ?>" class="<?= ($currentScript === 'team.php') ? 'active' : '' ?>">
                                    Our Team
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- 3. SERVICES (DYNAMICALLY SHOWS CYBER OR FORENSICS BASED ON ACTIVE SECTION) -->
                <?php if ($activeSection === 'cyber'): ?>
                    <!-- CYBER INTELLIGENCE SERVICES (4-COLUMN MEGA DROPDOWN) -->
                    <div class="nav-item has-dropdown <?= (($isServicesSubdir || $currentScript === 'service.php') && (!isset($categorySlug) || $categorySlug !== 'digital-investigations')) ? 'active' : '' ?>">
                        <a href="<?= $activeServicesUrl ?>" class="nav-link dropdown-toggle" id="servicesDropdownBtn" aria-expanded="false">
                            Services
                            <svg class="dropdown-arrow-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6,9 12,15 18,9"/></svg>
                        </a>

                        <!-- MEGA DROPDOWN (4 HIGHLIGHTED COLUMNS USING CYBER KOVAI PALETTE) -->
                        <div class="mega-dropdown" id="servicesMegaMenu">
                            <div class="mega-dropdown-inner">

                                <!-- COLUMN 1: Application Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block">
                                        <h4 class="mega-col-title">Application Security</h4>
                                        <ul class="mega-links-list">
                                            <li><a href="<?= $basePrefix ?>services/vulnerability-assessment-penetration-testing.php">Comprehensive VAPT Assessment</a></li>
                                            <li><a href="<?= $basePrefix ?>services/web-application-penetration-testing.php">Web Application Security Testing</a></li>
                                            <li><a href="<?= $basePrefix ?>services/mobile-app-penetration-testing.php">Mobile Application Security (iOS &amp; Android)</a></li>
                                            <li><a href="<?= $basePrefix ?>services/api-penetration-testing.php">REST &amp; GraphQL API Security Testing</a></li>
                                            <li><a href="<?= $basePrefix ?>services/secure-source-code-review.php">Secure Code Audit &amp; SAST Review</a></li>
                                            <li><a href="<?= $basePrefix ?>services/ecommerce-security.php">E-Commerce &amp; Payment Security Audit</a></li>
                                            <li><a href="<?= $basePrefix ?>services/saas-security.php">SaaS Platform Security Assessment</a></li>
                                            <li><a href="<?= $basePrefix ?>services/devsecops.php">DevSecOps &amp; CI/CD Pipeline Assurance</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- COLUMN 2: Network Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block">
                                        <h4 class="mega-col-title">Network Security</h4>
                                        <ul class="mega-links-list">
                                            <li><a href="<?= $basePrefix ?>services/network-penetration-testing.php">External &amp; Internal Network Pen Testing</a></li>
                                            <li><a href="<?= $basePrefix ?>services/wireless-penetration-testing.php">Wireless &amp; Wi-Fi Security Assessment</a></li>
                                            <li><a href="<?= $basePrefix ?>services/firewall-security-audit.php">Firewall &amp; Perimeter Rulebase Audit</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- COLUMN 3: Cloud Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block">
                                        <h4 class="mega-col-title">Cloud Security</h4>
                                        <ul class="mega-links-list">
                                            <li><a href="<?= $basePrefix ?>services/cloud-configuration-review.php">Cloud Security Posture Assessment (CSPM)</a></li>
                                            <li><a href="<?= $basePrefix ?>services/cloud-application-security-assessment-casa.php">Cloud App Security Assessment (CASA Tier 2/3)</a></li>
                                            <li><a href="<?= $basePrefix ?>services/cloud-container-security.php">Docker &amp; Kubernetes Container Security</a></li>
                                            <li><a href="<?= $basePrefix ?>services/gcp-server-hardening.php">Google Cloud (GCP) Security Hardening</a></li>
                                            <li><a href="<?= $basePrefix ?>services/aws-server-hardening.php">Amazon Web Services (AWS) Hardening</a></li>
                                            <li><a href="<?= $basePrefix ?>services/azure-server-hardening.php">Microsoft Azure Cloud Hardening</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <!-- COLUMN 4: Enterprise Security -->
                                <div class="mega-col-group">
                                    <div class="mega-category-block">
                                        <h4 class="mega-col-title">Enterprise Security</h4>
                                        <ul class="mega-links-list">
                                            <li><a href="<?= $basePrefix ?>services/virtual-cISO-services.php">Virtual CISO (vCISO) Advisory</a></li>
                                            <li><a href="<?= $basePrefix ?>services/black-box-testing.php">Zero-Knowledge Black Box Pen Testing</a></li>
                                            <li><a href="<?= $basePrefix ?>services/email-security-audit.php">Email Security &amp; Anti-Phishing Audit</a></li>
                                            <li><a href="<?= $basePrefix ?>services/server-hardening.php">Server &amp; Operating System Hardening</a></li>
                                            <li><a href="<?= $basePrefix ?>services/microsoft-365-security.php">Microsoft 365 &amp; Entra ID Security Review</a></li>
                                            <li><a href="<?= $basePrefix ?>services/erp-security-audit-assessment.php">Enterprise ERP &amp; SAP Security Audit</a></li>
                                            <li><a href="<?= $basePrefix ?>services/security-architecture-review.php">Zero-Trust Security Architecture Review</a></li>
                                            <li><a href="<?= $basePrefix ?>services/wordpress-security.php">CMS &amp; Web Platform Security Hardening</a></li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- DIGITAL INVESTIGATION & FORENSICS SERVICES DROPDOWN -->
                    <div class="nav-item has-dropdown <?= ($currentScript === 'cyber-intelligence.php' || (isset($categorySlug) && $categorySlug === 'digital-investigations')) ? 'active' : '' ?>">
                        <a href="<?= $activeServicesUrl ?>" class="nav-link dropdown-toggle" id="servicesDropdownBtn" aria-expanded="false">
                            Services
                            <svg class="dropdown-arrow-icon" viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="6,9 12,15 18,9"/></svg>
                        </a>

                        <!-- FORENSICS DROPDOWN (8 SPECIALIZED PRACTICES - EXACTLY LIKE IMAGE 2) -->
                        <div class="mega-dropdown forensics-mega-dropdown" id="servicesMegaMenu">
                            <ul class="mega-links-list forensics-links-list">
                                <?php 
                                global $investigationServices;
                                if (!isset($investigationServices) || empty($investigationServices)) {
                                    require_once __DIR__ . '/../config.php';
                                }
                                foreach ($investigationServices as $svc): 
                                ?>
                                <li>
                                    <a href="<?= $basePrefix ?>services/<?= sanitize_out($svc['slug']) ?>.php?section=forensics">
                                        <?= sanitize_out($svc['title']) ?>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- TESTIMONIAL (Matching Image 3) -->
                    <a href="<?= $basePrefix ?>cyber-intelligence.php?section=forensics#ci-testimonials">Testimonial</a>
                <?php endif; ?>

                <!-- 4. CONTACT -->
                <a href="<?= $contactUrl ?>" class="<?= ($currentScript === 'contact.php') ? 'active' : '' ?>"><?= ($activeSection === 'forensics') ? 'Contact Us' : 'Contact' ?></a>
            </nav>

            <div class="nav-actions">
                <button class="search-btn" title="Search" aria-label="Search">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <button class="theme-toggle" id="themeToggle" title="Toggle Light/Dark Theme" aria-label="Toggle theme">
                    <svg class="sun-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5" />
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                    </svg>
                    <svg class="moon-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                </button>

                <a href="<?= $contactUrl ?>" class="nav-button">
                    <?= ($activeSection === 'forensics') ? 'Enquire Now' : 'Confidential Consultation' ?>
                </a>

                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
                    ☰
                </button>
            </div>

        </div>
    </header>
