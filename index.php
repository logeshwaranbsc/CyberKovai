<?php
/**
 * Cyber Kovai - Section Selection Portal (Dual-Track Selection)
 */
require_once __DIR__ . '/config.php';
$pageTitle       = 'Choose Your Solution | ' . SITE_NAME;
$pageDescription = 'Choose between Digital Investigation & Forensics and Cyber Intelligence & Defense solutions tailored to your security and verification needs.';

$bodyClass  = 'portal-page';
$hideFooter = true;

include_once __DIR__ . '/includes/header.php';

$reqSection = $_GET['section'] ?? null;
if ($reqSection === 'cyber') {
    $isCyberActive = true;
    $isForensicsActive = false;
} elseif ($reqSection === 'forensics') {
    $isCyberActive = false;
    $isForensicsActive = true;
} else {
    if (isset($_COOKIE['ck_section']) && $_COOKIE['ck_section'] === 'cyber') {
        $isCyberActive = true;
        $isForensicsActive = false;
    } else {
        $isForensicsActive = true;
        $isCyberActive = false;
    }
}
?>

    <main>

        <!-- ================= DUAL-INTELLIGENCE SHOWCASE HERO ================= -->

        <section class="split-hero-stage" id="home">
            <div class="split-ambient-glow" aria-hidden="true"></div>

            <div class="container split-hero-container">

                <!-- CARD 1: DIGITAL INVESTIGATION & FORENSICS (Expandable) -->
                <article class="split-card investigation-card <?= $isForensicsActive ? 'active' : '' ?>" id="cardInvestigation" data-track="forensics" data-url="cyber-intelligence.php?section=forensics" tabindex="0" role="region" aria-label="Digital Investigation and Forensics Services">
                    
                    <!-- Background Visual & Warm Monochrome Overlay -->
                    <div class="split-card-bg">
                        <img src="assets/images/hero_investigation_card.jpg" alt="Investigation Intelligence and Digital Forensics" class="split-card-art">
                        <div class="split-card-overlay split-card-overlay-warm"></div>
                    </div>

                    <!-- Collapsed Vertical Title & Outline 01 (Visible when Card 2 is active) -->
                    <div class="split-card-collapsed" aria-hidden="true">
                        <div class="collapsed-track-title">Investigation Intelligence</div>
                        <div class="collapsed-number">01</div>
                    </div>

                    <!-- Expanded Content (Visible when active) -->
                    <div class="split-card-content">
                        <div class="split-card-tag split-card-tag-warm">
                            <span class="tag-dash"></span>
                            <span class="tag-text">INVESTIGATION INTELLIGENCE</span>
                        </div>

                        <h2 class="split-card-title">
                            Digital Investigation<br>&amp; Forensics
                        </h2>

                        <p class="split-card-desc">
                            Discreet digital evidence collection, OSINT investigations, cyber fraud tracing, victim account recovery, and executive digital protection.
                        </p>

                        <div class="split-card-action">
                            <a href="cyber-intelligence.php?section=forensics" class="split-cta-circle split-cta-circle-warm" id="investigationCtaBtn" aria-label="Explore Investigation Services" title="Explore Investigation Services">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </a>
                            <a href="cyber-intelligence.php?section=forensics" class="split-cta-label split-cta-label-warm">
                                Explore Investigation Services <span>➔</span>
                            </a>
                        </div>
                    </div>
                </article>

                <!-- CARD 2: CYBER INTELLIGENCE (Expandable) -->
                <article class="split-card cyber-card <?= $isCyberActive ? 'active' : '' ?>" id="cardCyber" data-track="cyber" data-url="digital-forensics.php?section=cyber" tabindex="0" role="region" aria-label="Cyber Intelligence Services">
                    
                    <!-- Background Visual & Overlay -->
                    <div class="split-card-bg">
                        <img src="assets/images/hero_cyber_cloud.jpg" alt="Cyber Intelligence and Defense Artwork" class="split-card-art">
                        <div class="split-card-overlay"></div>
                    </div>

                    <!-- Collapsed Vertical Title & Outline 02 (Visible when Card 1 is active) -->
                    <div class="split-card-collapsed" aria-hidden="true">
                        <div class="collapsed-track-title">Cyber Intelligence</div>
                        <div class="collapsed-number">02</div>
                    </div>

                    <!-- Expanded Content (Visible when active) -->
                    <div class="split-card-content">
                        <div class="split-card-tag">
                            <span class="tag-dash"></span>
                            <span class="tag-text">CYBER INTELLIGENCE</span>
                        </div>

                        <h2 class="split-card-title">
                            Cyber Intelligence<br>&amp; Defense
                        </h2>

                        <p class="split-card-desc">
                            Enterprise threat detection, proactive vulnerability defense, incident response, network security, and continuous risk intelligence.
                        </p>

                        <div class="split-card-action">
                            <a href="digital-forensics.php?section=cyber" class="split-cta-circle" id="cyberCtaBtn" aria-label="Explore Cyber Intelligence" title="Explore Cyber Intelligence">
                                <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="7" y1="17" x2="17" y2="7"></line>
                                    <polyline points="7 7 17 7 17 17"></polyline>
                                </svg>
                            </a>
                            <a href="digital-forensics.php?section=cyber" class="split-cta-label">
                                Explore Cyber Intelligence <span>➔</span>
                            </a>
                        </div>
                    </div>
                </article>

            </div>
        </section>

    </main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
