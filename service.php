<?php
/**
 * Cyber Kovai - Master Service Detail Page Renderer
 * Dynamically displays detailed, verified cybersecurity content for all 51 services.
 * Theme adapts smoothly to existing Cyber Kovai dark/light palette with cyber accents.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/services-data.php';

// Get service slug from variable or query string
$currentSlug = $serviceSlug ?? ($_GET['slug'] ?? 'vulnerability-assessment-penetration-testing');
$service = getServiceBySlug($currentSlug);

// Fallback to first service if not found
if (!$service) {
    $currentSlug = 'vulnerability-assessment-penetration-testing';
    $service = getServiceBySlug($currentSlug);
}

// Get service image (or fallback from config for investigation services)
global $investigationServices;
$invMap = !empty($investigationServices) ? array_column($investigationServices, 'image', 'slug') : [];
$serviceImage = $service['image'] ?? ($invMap[$currentSlug] ?? null);

$categorySlug = $service['category'] ?? 'application-security';
if ($categorySlug === 'digital-investigations') {
    $activeSection = 'forensics';
} elseif (!isset($activeSection)) {
    $paramSection = $_GET['section'] ?? $_GET['track'] ?? null;
    if ($paramSection && in_array(strtolower($paramSection), ['forensics', 'investigation', 'digital-forensics'])) {
        $activeSection = 'forensics';
    } else {
        $activeSection = 'cyber';
    }
}
$category = $serviceCategories[$categorySlug] ?? [
    'name' => 'Cyber Security',
    'badge' => 'SPECIALIZED SECURITY',
    'icon' => '🛡️'
];

$pageTitle = $service['title'] . ' | ' . SITE_NAME;
$pageDescription = $service['short_desc'] . ' Professional cybersecurity services by Cyber Kovai.';

// Get related services in same category
$relatedServices = getServicesByCategory($categorySlug);
// Remove current service from related
unset($relatedServices[$currentSlug]);
$relatedSlice = array_slice($relatedServices, 0, 4, true);

include_once __DIR__ . '/includes/header.php';
?>

<main class="service-detail-page">

    <!-- ================= HERO & BREADCRUMB ================= -->
    <section class="svc-hero">
        <div class="svc-hero-hud" aria-hidden="true">
            <div class="svc-hud-grid"></div>
            <div class="svc-hud-glow"></div>
        </div>

        <div class="container svc-hero-container">
            <!-- Breadcrumbs -->
            <nav class="svc-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= $activeHomeUrl ?>">Home</a>
                <span class="svc-sep">/</span>
                <a href="<?= ($categorySlug === 'digital-investigations') ? $basePrefix . 'cyber-intelligence.php?section=forensics#ci-services' : $activeServicesUrl ?>">Services</a>
                <span class="svc-sep">/</span>
                <span class="svc-cat-crumb"><?= sanitize_out($category['name']) ?></span>
                <span class="svc-sep">/</span>
                <span class="svc-curr"><?= sanitize_out($service['title']) ?></span>
            </nav>

            <div class="svc-hero-grid">
                <!-- Left Content -->
                <div class="svc-hero-main">
                    <div class="svc-badge-pill">
                        <span class="svc-badge-icon"><?= $category['icon'] ?? '🛡️' ?></span>
                        <span class="svc-badge-text"><?= sanitize_out($service['badge'] ?? $category['badge']) ?></span>
                    </div>

                    <h1 class="svc-hero-title">
                        <?= sanitize_out($service['title']) ?>
                    </h1>

                    <p class="svc-hero-tagline">
                        <?= sanitize_out($service['tagline']) ?>
                    </p>

                    <p class="svc-hero-desc">
                        <?= sanitize_out($service['short_desc']) ?>
                    </p>

                    <div class="svc-hero-trust-bar">
                        <div class="svc-trust-item">
                            <span class="svc-check">✓</span>
                            <span>Zero False Positives</span>
                        </div>
                        <div class="svc-trust-item">
                            <span class="svc-check">✓</span>
                            <span>Manual & Automated Exploits</span>
                        </div>
                        <div class="svc-trust-item">
                            <span class="svc-check">✓</span>
                            <span>Attestation Certificate Included</span>
                        </div>
                    </div>

                    <div class="svc-hero-actions">
                        <a href="#book-assessment" class="btn primary-btn svc-book-btn">
                            <span>Schedule Security Audit</span>
                            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                        <a href="#methodology" class="btn outline-btn">
                            Explore Methodology
                        </a>
                        <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn outline-btn">
                            Talk to an Expert
                        </a>
                    </div>
                </div>

                <!-- Right Visual Stats Card -->
                <div class="svc-hero-card-side">
                    <?php if (!empty($serviceImage)): ?>
                    <div class="svc-hero-img-box">
                        <img src="<?= $basePrefix ?><?= sanitize_out($serviceImage) ?>" alt="<?= sanitize_out($service['title']) ?>" class="svc-hero-preview-img" loading="eager">
                        <div class="svc-hero-img-overlay">
                            <span class="svc-img-tag"><?= sanitize_out($service['badge'] ?? $category['badge'] ?? 'CYBER PRACTICE') ?></span>
                            <span class="svc-img-status">ACTIVE PRACTICE</span>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="svc-hud-card">
                        <div class="svc-card-header">
                            <div class="svc-status-indicator">
                                <span class="svc-status-dot"></span>
                                <span class="svc-status-label">AUDIT READY</span>
                            </div>
                            <span class="svc-card-badge"><?= sanitize_out($category['name']) ?></span>
                        </div>

                        <div class="svc-card-body">
                            <div class="svc-stat-highlight">
                                <span class="svc-stat-big">100%</span>
                                <span class="svc-stat-sub">Confidential & Compliant Assessment</span>
                            </div>

                            <div class="svc-spec-list">
                                <div class="svc-spec-row">
                                    <span class="svc-spec-k">Frameworks</span>
                                    <span class="svc-spec-v"><?= implode(', ', array_slice($service['compliance'] ?? [], 0, 3)) ?></span>
                                </div>
                                <div class="svc-spec-row">
                                    <span class="svc-spec-k">Delivery Format</span>
                                    <span class="svc-spec-v">Executive Brief + Technical PoC</span>
                                </div>
                                <div class="svc-spec-row">
                                    <span class="svc-spec-k">Testing Mode</span>
                                    <span class="svc-spec-v">Black, Gray & White Box</span>
                                </div>
                                <div class="svc-spec-row">
                                    <span class="svc-spec-k">Re-Testing</span>
                                    <span class="svc-spec-v">Complimentary Post-Fix Audit</span>
                                </div>
                            </div>
                        </div>

                        <div class="svc-card-footer">
                            <div class="svc-card-security-seal">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                                <span>Certified Ethical Cybersecurity Labs</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ================= OVERVIEW & BUSINESS CONTEXT ================= -->
    <section class="section svc-overview-section" id="overview">
        <div class="container">
            <div class="svc-split-grid">
                <div class="svc-split-text">
                    <div class="section-tag">EXECUTIVE SUMMARY</div>
                    <h2>Defend Your Assets With <span>Precision Intelligence</span></h2>
                    <p class="svc-lead-para">
                        <?= sanitize_out($service['overview']) ?>
                    </p>

                    <div class="svc-why-box">
                        <div class="svc-why-icon">⚠️</div>
                        <div class="svc-why-content">
                            <h4>Why Your Organization Needs This</h4>
                            <p><?= sanitize_out($service['why_needed']) ?></p>
                        </div>
                    </div>
                </div>

                <div class="svc-split-visual">
                    <div class="svc-compliance-card">
                        <h3>Regulatory & Security Standards Aligned</h3>
                        <p>Our audit methodology strictly mirrors established international compliance mandates and defensive controls:</p>
                        
                        <div class="svc-compliance-tags">
                            <?php foreach ($service['compliance'] as $std): ?>
                                <span class="svc-comp-tag">
                                    <svg viewBox="0 0 16 16" width="12" height="12" fill="currentColor"><path d="M13.485 1.431a1.473 1.473 0 0 1 2.104 2.062l-7.84 9.801a1.473 1.473 0 0 1-2.12.04L.431 8.138a1.473 1.473 0 0 1 2.084-2.083l4.111 4.112 6.82-8.696a.486.486 0 0 1 .04-.04z"/></svg>
                                    <?= sanitize_out($std) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <div class="svc-audit-seal-box">
                            <div class="svc-seal-icon">🛡️</div>
                            <div>
                                <strong>Attestation of Security</strong>
                                <small>Official compliance-ready verification letter issued upon successful assessment and remediation.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- ================= CORE CAPABILITIES / WHAT WE ASSESS ================= -->
    <section class="section svc-capabilities-section" id="capabilities">
        <div class="container">
            <div class="section-heading text-center">
                <span class="section-tag">IN-DEPTH COVERAGE</span>
                <h2>What We <span>Assess & Test</span></h2>
                <p>Comprehensive attack surface evaluation targeting critical vectors and architectural weak points.</p>
            </div>

            <div class="svc-features-grid">
                <?php foreach ($service['key_features'] as $idx => $feat): ?>
                    <div class="svc-feature-card">
                        <div class="svc-feature-num">0<?= $idx + 1 ?></div>
                        <h3 class="svc-feature-title"><?= sanitize_out($feat['title']) ?></h3>
                        <p class="svc-feature-desc"><?= sanitize_out($feat['desc']) ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ================= METHODOLOGY & TESTING PHASES ================= -->
    <section class="section svc-methodology-section" id="methodology">
        <div class="container">
            <div class="section-heading text-center">
                <span class="section-tag">SYSTEMATIC EXECUTION</span>
                <h2>Engagement <span>Methodology</span></h2>
                <p>A rigorous, phased framework ensuring maximum vulnerability discovery with zero disruption to live operations.</p>
            </div>

            <div class="svc-timeline">
                <?php foreach ($service['methodology'] as $phase): ?>
                    <div class="svc-timeline-step">
                        <div class="svc-step-badge"><?= sanitize_out($phase['step']) ?></div>
                        <div class="svc-step-content">
                            <h4 class="svc-step-title"><?= sanitize_out($phase['title']) ?></h4>
                            <p class="svc-step-desc"><?= sanitize_out($phase['desc']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>


    <!-- ================= DELIVERABLES ================= -->
    <section class="section svc-deliverables-section">
        <div class="container">
            <div class="svc-deliverables-wrapper">
                <div class="svc-deliv-header">
                    <span class="section-tag">WHAT YOU RECEIVE</span>
                    <h2>Tangible <span>Deliverables</span></h2>
                    <p>Clear, actionable intelligence tailored for both executive boards and technical engineering teams.</p>
                </div>

                <div class="svc-deliv-grid">
                    <?php foreach ($service['deliverables'] as $i => $item): ?>
                        <div class="svc-deliv-item">
                            <div class="svc-deliv-check">✓</div>
                            <div class="svc-deliv-text">
                                <strong><?= sanitize_out($item) ?></strong>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>


    <!-- ================= FAQS ================= -->
    <?php if (!empty($service['faqs'])): ?>
    <section class="section svc-faq-section" id="faqs">
        <div class="container" style="max-width: 900px;">
            <div class="section-heading text-center">
                <span class="section-tag">QUESTIONS & ANSWERS</span>
                <h2>Frequently Asked <span>Questions</span></h2>
                <p>Everything you need to know about our <?= sanitize_out($service['title']) ?> service.</p>
            </div>

            <div class="ci-faq-list">
                <?php foreach ($service['faqs'] as $faq): ?>
                    <div class="ci-faq-item">
                        <button class="ci-faq-q">
                            <?= sanitize_out($faq['q']) ?>
                            <span class="ci-faq-arrow">
                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6,9 12,15 18,9"/>
                                </svg>
                            </span>
                        </button>
                        <div class="ci-faq-a">
                            <p><?= sanitize_out($faq['a']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <!-- ================= RELATED SERVICES ================= -->
    <?php if (!empty($relatedSlice)): ?>
    <section class="section svc-related-section">
        <div class="container">
            <div class="section-heading">
                <span class="section-tag">EXPLORE MORE</span>
                <h2>Related Services in <span><?= sanitize_out($category['name']) ?></span></h2>
            </div>

            <div class="svc-related-grid">
                <?php foreach ($relatedSlice as $relSlug => $relService): 
                    $relUrl = file_exists(__DIR__ . '/services/' . $relSlug . '.php')
                        ? $basePrefix . 'services/' . urlencode($relSlug) . '.php'
                        : $basePrefix . 'service.php?slug=' . urlencode($relSlug);
                ?>
                    <a href="<?= $relUrl ?>" class="svc-related-card">
                        <div class="svc-rel-icon"><?= $category['icon'] ?? '🛡️' ?></div>
                        <h4 class="svc-rel-title"><?= sanitize_out($relService['title']) ?></h4>
                        <p class="svc-rel-desc"><?= sanitize_out(substr($relService['short_desc'], 0, 110)) ?>...</p>
                        <span class="svc-rel-link">Explore Service ➔</span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <!-- ================= BOOKING & CONSULTATION CTA ================= -->
    <section class="section svc-booking-section" id="book-assessment">
        <div class="container">
            <div class="svc-booking-card">
                <div class="svc-booking-info">
                    <span class="section-tag">CONFIDENTIAL ENGAGEMENT</span>
                    <h2>Schedule Your <span><?= sanitize_out($service['title']) ?></span></h2>
                    <p>
                        Speak directly with our certified cybersecurity specialists. We sign strict Non-Disclosure Agreements (NDAs) prior to discussing sensitive architecture or scope details.
                    </p>
                    
                    <div class="svc-booking-trust">
                        <div class="svc-b-trust-item">
                            <strong>100%</strong>
                            <span>Confidentiality Guaranteed</span>
                        </div>
                        <div class="svc-b-trust-item">
                            <strong>24h</strong>
                            <span>Proposal & Scoping Turnaround</span>
                        </div>
                        <div class="svc-b-trust-item">
                            <strong>Certified</strong>
                            <span>OSCP, CEH, CISSP Specialists</span>
                        </div>
                    </div>
                </div>

                <div class="svc-booking-form-wrapper">
                    <form id="contactForm" action="<?= $basePrefix ?>process-contact.php" method="POST" class="svc-contact-form">
                        <div id="formResponse" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;"></div>
                        <div class="form-group">
                            <label for="service">Service Required *</label>
                            <select id="service" name="service" required>
                                <option value="<?= sanitize_out($service['title']) ?>" selected><?= sanitize_out($service['title']) ?></option>
                                <?php if (!empty($services) && is_array($services)): ?>
                                    <?php foreach ($services as $svcItem): ?>
                                        <?php if (!empty($svcItem['title']) && $svcItem['title'] !== $service['title']): ?>
                                            <option value="<?= sanitize_out($svcItem['title']) ?>"><?= sanitize_out($svcItem['title']) ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="client_name">Your Name / Pseudonym *</label>
                            <input type="text" id="client_name" name="name" required placeholder="e.g. John Doe">
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="client_email">Secure Email Address *</label>
                                <input type="email" id="client_email" name="email" required placeholder="john@company.com">
                            </div>
                            <div class="form-group">
                                <label for="client_phone">Phone / WhatsApp / Signal *</label>
                                <input type="tel" id="client_phone" name="phone" required placeholder="+91 63820 19821">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="client_scope">Confidential Details / Message *</label>
                            <textarea id="client_scope" name="message" rows="3" required placeholder="Describe your requirement in brief. All submissions are encrypted and kept strictly confidential under NDA."></textarea>
                        </div>

                        <?php if (defined('ENABLE_RECAPTCHA') && ENABLE_RECAPTCHA): ?>
                        <!-- Google reCAPTCHA -->
                        <div class="form-group recaptcha-wrapper" style="margin-bottom: 1.5rem;">
                            <div class="g-recaptcha" data-sitekey="<?= sanitize_out(RECAPTCHA_SITE_KEY) ?>" data-theme="dark"></div>
                        </div>
                        <?php endif; ?>

                        <button type="submit" class="btn primary-btn svc-submit-btn">
                            Request Confidential Audit Proposal ➔
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
