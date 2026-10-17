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

<body>

    <!-- ================= NAVBAR ================= -->

    <header class="navbar" id="siteNavbar">
        <div class="container nav-container">

            <a href="<?= $basePrefix ?>index.php" class="logo">
                <img src="<?= $basePrefix ?>assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                <span>CYBER <strong>KOVAI</strong></span>
            </a>

            <nav class="nav-menu" id="navMenu">
                <a href="<?= $basePrefix ?>index.php" class="<?= ($currentScript === 'index.php') ? 'active' : '' ?>">Home</a>
                <a href="<?= $basePrefix ?>about.php" class="<?= ($currentScript === 'about.php') ? 'active' : '' ?>">About</a>

                <!-- SERVICES (5-COLUMN MEGA DROPDOWN USING CYBER KOVAI PALETTE) -->
                <div class="nav-item has-dropdown <?= ($isServicesSubdir || $currentScript === 'service.php') ? 'active' : '' ?>">
                    <a href="#services" class="nav-link dropdown-toggle" id="servicesDropdownBtn" aria-expanded="false">
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
                                        <li><a href="<?= $basePrefix ?>services/virtual-ciso-services.php">Virtual CISO (vCISO) Advisory</a></li>
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

                <a href="<?= $basePrefix ?>cyber-intelligence.php" class="<?= ($currentScript === 'cyber-intelligence.php') ? 'active' : '' ?>">Cyber Intelligence</a>
                <a href="<?= $basePrefix ?>index.php#contact">Contact</a>
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

                <a href="<?= $basePrefix ?>index.php#contact" class="nav-button">
                    Confidential Consultation
                </a>

                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
                    ☰
                </button>
            </div>

        </div>
    </header>
