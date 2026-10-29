<?php
/**
 * Cyber Kovai — Digital Investigation & Forensics Solutions
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/forensic-icons.php';

$activeSection   = 'forensics';
$pageTitle       = 'Digital Investigation & Forensics Services';
$pageDescription = 'Confidential digital investigations, accredited forensic evidence recovery, OSINT threat intelligence, and cyber fraud tracing by CyberKovai, Coimbatore.';

// Interactive Investigation Console 4-Pillar Data
$investigationPillars = [
    [
        'id'          => 'pillar-forensics',
        'num'         => '01',
        'code'        => 'INV-01 // DIGITAL_FORENSICS',
        'badge'       => 'COURT ADMISSIBLE',
        'title'       => 'Digital Forensics & Artifact Analysis',
        'short'       => 'Digital Forensics',
        'metric'      => '100% Cryptographic Verification',
        'metric_sub'  => 'ISO/IEC 27037 Evidence Standard',
        'meter'       => '100',
        'encryption'  => 'SHA-256 VAULT / HSM',
        'standard'    => 'ISO/IEC 27037 COURT STANDARD',
        'log'         => 'Forensic Triage: Cryptographic SHA-256 hash verified. Chain-of-custody sealed.',
        'desc'        => 'Court-admissible bit-stream imaging, volatile memory capture, deleted artifact carving, timestamp tampering detection, and root-cause breach tracing.',
        'target_id'   => 'target-forensics',
        'coords'      => 'SEC-HASH: SHA256-VAULT-VERIFIED',
        'status'      => 'CHAIN-OF-CUSTODY READY',
        'status_color'=> '#8b20ff',
        'image'       => 'assets/images/investigation_05_digital_forensics.jpg',
        'capabilities'=> ['Memory & Disk Imaging', 'Deleted File Carving', 'Cryptographic Hashing', 'Court-Ready Expert Reports'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-7.07 17.07l.07.07"/><path d="M12 6a6 6 0 0 0-4.24 10.24"/><path d="M12 10a2 2 0 0 0-1.41 3.41"/><path d="M12 18v4"/><path d="M8 22h8"/><circle cx="12" cy="12" r="1"/></svg>'
    ],
    [
        'id'          => 'pillar-osint',
        'num'         => '02',
        'code'        => 'INV-02 // OSINT_INTEL',
        'badge'       => 'DEEP INTELLIGENCE',
        'title'       => 'OSINT & Digital Footprint Tracing',
        'short'       => 'OSINT & Tracing',
        'metric'      => '99.4% Attribution Confidence',
        'metric_sub'  => 'Surface, Deep & Dark Web Profiling',
        'meter'       => '99',
        'encryption'  => 'ANONYMIZED TELEMETRY',
        'standard'    => 'ETHICAL INVESTIGATION PROTOCOL',
        'log'         => 'OSINT Recon: Multi-source footprint correlated. Digital identity confirmed across 8 platforms.',
        'desc'        => 'Uncovering hidden digital footprints, verifying online identities, cross-platform persona correlation, geolocation intelligence, and adversary profiling.',
        'target_id'   => 'target-osint',
        'coords'      => 'OSINT: MULTI-VECTOR TRACE ACTIVE',
        'status'      => 'RECONNAISSANCE ACTIVE',
        'status_color'=> '#3da9fc',
        'image'       => 'assets/images/investigation_02_osint.jpg',
        'capabilities'=> ['Deep Web Persona Profiling', 'Domain & Network Recon', 'Identity Verification', 'Geolocation Intelligence'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><circle cx="11" cy="11" r="3"/></svg>'
    ],
    [
        'id'          => 'pillar-fraud',
        'num'         => '03',
        'code'        => 'INV-03 // FRAUD_TRACE',
        'badge'       => 'FINANCIAL FORENSICS',
        'title'       => 'Cyber Fraud & Financial Scam Tracing',
        'short'       => 'Cyber Fraud Tracing',
        'metric'      => '₹50Cr+ Traced In Fraud Cases',
        'metric_sub'  => 'Crypto, Banking & Wire Scam Tracing',
        'meter'       => '98',
        'encryption'  => 'FIN-TRACE / BLOCKCHAIN AUDIT',
        'standard'    => 'LEA-READY EVIDENTIARY DOSSIER',
        'log'         => 'Fraud Trace: Transaction trail mapped across payment gateways and blockchain ledgers.',
        'desc'        => 'Professional investigation for investment scams, crypto fraud, banking deception, business email compromise, and preparation of legal enforcement dossiers.',
        'target_id'   => 'target-fraud',
        'coords'      => 'TRACE: FINANCIAL TRAIL IDENTIFIED',
        'status'      => 'FRAUD INTEL ACTIVE',
        'status_color'=> '#f59e0b',
        'image'       => 'assets/images/investigation_04_fraud_support.jpg',
        'capabilities'=> ['Cryptocurrency Ledger Tracing', 'Phishing & Wire Scam Tracking', 'Mule Account Identification', 'LEA Complaint Dossier Prep'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><circle cx="7" cy="15" r="1"/></svg>'
    ],
    [
        'id'          => 'pillar-social',
        'num'         => '04',
        'code'        => 'INV-04 // SOCIAL_INTEL',
        'badge'       => 'IDENTITY DEFENSE',
        'title'       => 'Social Media & Impersonation Investigation',
        'short'       => 'Social Media Intel',
        'metric'      => '99.1% Impersonation Removal Rate',
        'metric_sub'  => 'Evidence Capture & Takedown Support',
        'meter'       => '99',
        'encryption'  => 'METADATA ARCHIVE / HASH SEAL',
        'standard'    => 'PLATFORM TOS & LEGAL COMPLIANCE',
        'log'         => 'Identity Verification: Fake profiles identified, metadata archived, takedown notice dispatched.',
        'desc'        => 'Detecting and unmasking fake profiles, investigating online harassment, recovering hijacked accounts, and compiling digital evidence for legal takedowns.',
        'target_id'   => 'target-social',
        'coords'      => 'IDENTITY: PROFILE ANOMALY DETECTED',
        'status'      => 'TAKEDOWN STREAM ACTIVE',
        'status_color'=> '#10b981',
        'image'       => 'assets/images/investigation_03_social_media.jpg',
        'capabilities'=> ['Fake Profile & Botnet Tracing', 'Harassment & Defamation Evidence', 'Account Takeover Recovery', 'Platform Legal Reporting Support'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
    ],
];
// Compatibility aliases
$cyberPillars = $investigationPillars;
$cyberPanels  = $investigationPillars;

// 8 Investigation Services with Rich Visuals
global $investigationServices;
if (empty($investigationServices)) {
    require_once __DIR__ . '/config.php';
}
$cyberServices = $investigationServices;

// Forensic Investigation Lifecycle (5 Steps)
$investigationProcess = [
    [
        'num'   => '01',
        'title' => 'Consultation & Scoping',
        'desc'  => 'Confidential case assessment under strict NDA to understand case requirements and define investigation scope.'
    ],
    [
        'num'   => '02',
        'title' => 'Evidence Acquisition',
        'desc'  => 'Forensic bit-stream disk and device imaging adhering strictly to ISO/IEC 27037 standards.'
    ],
    [
        'num'   => '03',
        'title' => 'Forensic Analysis & OSINT',
        'desc'  => 'Artifact extraction, deleted data recovery, timeline reconstruction, and cross-platform intelligence correlation.'
    ],
    [
        'num'   => '04',
        'title' => 'Evidentiary Reporting',
        'desc'  => 'Comprehensive, court-admissible forensic dossiers with cryptographic SHA-256 verification.'
    ],
    [
        'num'   => '05',
        'title' => 'Legal & Ongoing Advisory',
        'desc'  => 'Expert witness testimony, law enforcement filing support, and actionable guidance for legal proceedings.'
    ],
];
$cyberProcess = $investigationProcess;

// Investigation Threat & Incident Tags
$investigationThreatsRow1 = [
    'Cybercrime & Online Fraud',
    'Digital Evidence Preservation',
    'Crypto & Investment Scams',
    'Social Media Impersonation',
    'Corporate Data Theft & Espionage',
    'Matrimonial & Personal Disputes',
];
$investigationThreatsRow2 = [
    'Cyberstalking & Harassment',
    'Account Takeovers & Hacking',
    'Child Digital Safety Threats',
    'Extortion & Blackmail Tracing',
];
$cyberRisksRow1 = $investigationThreatsRow1;
$cyberRisksRow2 = $investigationThreatsRow2;

// Testimonials for Investigation
$investigationTestimonials = [
    [
        'quote'  => 'CyberKovai\'s digital forensics team recovered critical deleted evidence and provided an airtight forensic report that proved decisive in our corporate litigation. Exceptional discretion and technical precision.',
        'name'   => 'Rajesh M.',
        'role'   => 'Managing Partner, Legal Advisory',
        'avatar' => 'assets/images/avatar_karthik.jpg',
    ],
    [
        'quote'  => 'Their cyber fraud tracing and blockchain analysis uncovered the illicit movement of funds after our firm suffered a major financial wire fraud. The dossier provided to law enforcement led directly to key recoveries.',
        'name'   => 'Priya S.',
        'role'   => 'Chief Financial Officer, Enterprise Logistics',
        'avatar' => 'assets/images/avatar_priya.jpg',
    ],
    [
        'quote'  => 'We faced an aggressive online harassment and executive impersonation campaign. CyberKovai identified the perpetrators through OSINT within 72 hours and facilitated swift platform takedowns.',
        'name'   => 'Aravind K.',
        'role'   => 'VP Operations & Corporate Affairs',
        'avatar' => 'assets/images/avatar_aravind.jpg',
    ],
];
$testimonials = $investigationTestimonials;

// FAQs for Digital Investigations & Forensics
$investigationFaqs = [
    [
        'q' => 'What digital investigation and forensic services do you offer?',
        'a' => 'We provide Digital Forensics & Artifact Extraction, OSINT & Background Intelligence, Cyber Fraud & Scam Tracing, Social Media Investigations & Impersonation Removal, Cybercrime Victim Assistance, Executive Digital Protection, and Child Digital Safety investigations.'
    ],
    [
        'q' => 'Are your forensic reports admissible in court?',
        'a' => 'Yes. All digital evidence is collected, preserved, and analyzed following ISO/IEC 27037 standards. We maintain a rigorous chain of custody and verify artifacts with cryptographic SHA-256 hashes, ensuring our comprehensive reports are fully admissible in legal proceedings.'
    ],
    [
        'q' => 'How do you guarantee the confidentiality of my case?',
        'a' => '100% confidentiality is guaranteed from your very first consultation. All case files, client identities, and forensic findings are protected under legally binding Non-Disclosure Agreements (NDAs) and stored in encrypted offline forensic vaults.'
    ],
    [
        'q' => 'How long does a digital investigation take?',
        'a' => 'Investigation timelines vary depending on case complexity. Urgent inquiries such as active impersonation or account takeovers can produce actionable intelligence within 24 to 72 hours, while complex corporate forensic audits or financial fraud tracing typically range from 5 to 14 business days.'
    ],
    [
        'q' => 'Do you assist with cross-border and international cases?',
        'a' => 'Yes. CyberKovai handles digital investigations across India and internationally, working regularly on matters spanning the UAE, Singapore, Germany, Canada, the UK, Australia, and the US.'
    ],
];
$cyberFaqs = $investigationFaqs;

// Form Services Dropdown List
$investigationFormServices = [
    'Digital Evidence Preservation & Forensics',
    'Digital Investigations & OSINT',
    'Cyber Fraud Investigation Support',
    'Social Media Investigations & Impersonation Removal',
    'Cybercrime Victim Assistance & Account Recovery',
    'Executive & Family Digital Protection',
    'Child Digital Safety & Protection',
    'Cybersecurity Awareness & LEA Training',
    'Corporate & Background Investigation'
];

include_once __DIR__ . '/includes/header.php';
?>

<main class="ci-page">

<!-- ================================================================
     HERO SECTION
================================================================ -->
<section class="ci-hero" id="ci-home">

    <!-- Particle canvas background -->
    <canvas id="ciParticleCanvas" class="ci-hero-canvas" aria-hidden="true"></canvas>

    <!-- HUD grid overlay -->
    <div class="ci-hero-hud" aria-hidden="true">
        <div class="ci-hud-corner ci-hud-tl"></div>
        <div class="ci-hud-corner ci-hud-tr"></div>
        <div class="ci-hud-corner ci-hud-bl"></div>
        <div class="ci-hud-corner ci-hud-br"></div>
        <div class="ci-hud-h-line"></div>
        <div class="ci-hud-v-line"></div>
    </div>

    <div class="container ci-hero-inner">

        <!-- LEFT: Content -->
        <div class="ci-hero-content">

            <div class="ci-hero-label ci-reveal">
                <svg viewBox="0 0 10 10" width="8" height="8" fill="var(--orchid)"><circle cx="5" cy="5" r="5"/></svg>
                DIGITAL INVESTIGATION &amp; FORENSICS
            </div>

            <h1 class="ci-hero-heading ci-reveal">
                Uncover Digital Truth<br>
                <span class="ci-grad-text">&amp; Forensic Evidence</span>
            </h1>

            <p class="ci-hero-desc ci-reveal">
                Confidential, court-admissible digital investigations, OSINT intelligence, cyber fraud tracing, and evidence preservation for individuals, legal counsel, and enterprises.
            </p>

            <div class="ci-hero-trust ci-reveal">
                <span>&#10003; Court-Admissible Evidence</span>
                <span>&#10003; 100% Confidential Inquiry</span>
                <span>&#10003; Certified Specialists</span>
            </div>

            <div class="ci-hero-btns ci-reveal">
                <a href="#ci-services" class="btn primary-btn">
                    Explore Investigation Services <span>&#x2192;</span>
                </a>
                <a href="#contact" class="btn outline-btn">
                    Schedule Consultation <span>&#x2192;</span>
                </a>
            </div>

        </div>

        <!-- RIGHT: Animated Cyber Shield Stage -->
        <div class="ci-hero-visual ci-reveal" aria-hidden="true">

            <!-- Outer rotating ring -->
            <div class="ci-ring ci-ring-outer"></div>
            <div class="ci-ring ci-ring-mid"></div>

            <!-- HUD arc labels -->
            <div class="ci-arc-labels">
                <div class="ci-arc-label ci-arc-top">DIGITAL FORENSICS</div>
                <div class="ci-arc-label ci-arc-right">OSINT INVESTIGATION</div>
                <div class="ci-arc-label ci-arc-bottom">CYBER FRAUD TRACING</div>
                <div class="ci-arc-label ci-arc-left">EVIDENCE PRESERVATION</div>
            </div>

            <!-- Floating feature cards -->
            <div class="ci-float-card ci-fc-1">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 2a10 10 0 0 0-7.07 17.07l.07.07"/><path d="M12 6a6 6 0 0 0-4.24 10.24"/><path d="M12 10a2 2 0 0 0-1.41 3.41"/><path d="M12 18v4"/><path d="M8 22h8"/><circle cx="12" cy="12" r="1"/></svg>
                <span>Digital Forensics</span>
            </div>
            <div class="ci-float-card ci-fc-2">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><circle cx="11" cy="11" r="3"/></svg>
                <span>OSINT Recon</span>
            </div>
            <div class="ci-float-card ci-fc-3">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><circle cx="7" cy="15" r="1"/></svg>
                <span>Cyber Fraud Tracing</span>
            </div>
            <div class="ci-float-card ci-fc-4">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <span>Evidence Vault</span>
            </div>

            <!-- Central shield -->
            <div class="ci-shield-wrap">
                <div class="ci-shield-glow"></div>
                <div class="ci-shield-icon">
                    <img src="assets/images/logo.png" alt="Cyber Kovai Logo" class="ci-shield-logo-img">
                </div>
                <!-- Data lines from shield to 4 corner cards -->
                <svg class="ci-data-lines" viewBox="0 0 400 400" fill="none" aria-hidden="true">
                    <line x1="200" y1="200" x2="85"  y2="85"  stroke="url(#lineGrad)" stroke-width="1.2" stroke-dasharray="4 6" opacity="0.6">
                        <animate attributeName="stroke-dashoffset" values="0;-20" dur="2s" repeatCount="indefinite"/>
                    </line>
                    <line x1="200" y1="200" x2="315" y2="85"  stroke="url(#lineGrad)" stroke-width="1.2" stroke-dasharray="4 6" opacity="0.6">
                        <animate attributeName="stroke-dashoffset" values="0;-20" dur="2.4s" repeatCount="indefinite"/>
                    </line>
                    <line x1="200" y1="200" x2="315" y2="315" stroke="url(#lineGrad)" stroke-width="1.2" stroke-dasharray="4 6" opacity="0.6">
                        <animate attributeName="stroke-dashoffset" values="0;-20" dur="1.8s" repeatCount="indefinite"/>
                    </line>
                    <line x1="200" y1="200" x2="85"  y2="315" stroke="url(#lineGrad)" stroke-width="1.2" stroke-dasharray="4 6" opacity="0.6">
                        <animate attributeName="stroke-dashoffset" values="0;-20" dur="2.2s" repeatCount="indefinite"/>
                    </line>
                    <defs>
                        <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#c84bff"/>
                            <stop offset="100%" stop-color="#7b2ff7"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>

            <!-- Intel monitoring badge -->
            <div class="ci-monitoring-badge">
                <span class="ci-monitoring-dot"></span>
                CONFIDENTIAL INVESTIGATION ACTIVE
            </div>

        </div><!-- /ci-hero-visual -->

    </div><!-- /container -->

</section><!-- /ci-hero -->


<!-- ================================================================
     4-PILLAR ANIMATED HORIZONTAL EXPANDING SHOWCASE
================================================================ -->
<section class="section ci-showcase-section" id="ci-showcase" aria-label="Digital Investigation Pillars">
    <div class="ci-showcase-ambient-glow" aria-hidden="true"></div>

    <div class="container">
        
        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                CORE INVESTIGATION PILLARS
            </span>
            <h2>
                Digital Forensic &amp; <span>Investigation Matrix</span>
            </h2>
            <p class="section-desc" style="max-width: 740px; margin: 0 auto;">
                Court-grade forensic artifact analysis, OSINT intelligence mapping, financial fraud indicators tracing, and evidentiary preservation across our four specialized investigation pillars.
            </p>
        </div>

        <div class="ci-showcase-wrapper ci-reveal">
            <div class="ci-showcase-panels" id="ciShowcasePanels" role="tablist" aria-label="Digital Investigation Pillars">

                <?php foreach ($investigationPillars as $i => $panel): ?>
                <div class="ci-panel <?= $i === 0 ? 'ci-panel-active' : '' ?>"
                     data-panel="<?= $i ?>"
                     id="ciPanel<?= $i ?>"
                     role="tab"
                     tabindex="0"
                     aria-selected="<?= $i === 0 ? 'true' : 'false' ?>"
                     aria-label="<?= sanitize_out($panel['title']) ?>">

                    <!-- Background Image Layer with Zoom Effect -->
                    <div class="ci-panel-bg" style="background-image: url('<?= sanitize_out($panel['image']) ?>');"></div>

                    <!-- Cyber Overlay Gradient & Vignette -->
                    <div class="ci-panel-overlay"></div>

                    <!-- Top glowing edge line -->
                    <div class="ci-panel-glow-edge"></div>

                    <!-- Floating Cyber Particle Nodes -->
                    <div class="ci-panel-particles" aria-hidden="true">
                        <span class="ci-ptcl ptcl-1"></span>
                        <span class="ci-ptcl ptcl-2"></span>
                        <span class="ci-ptcl ptcl-3"></span>
                        <span class="ci-ptcl ptcl-4"></span>
                        <span class="ci-ptcl ptcl-5"></span>
                    </div>

                    <!-- COLLAPSED STATE (Slim Vertical Strip) -->
                    <div class="ci-panel-collapsed" aria-hidden="<?= $i === 0 ? 'true' : 'false' ?>">
                        <span class="ci-panel-num"><?= sanitize_out($panel['num']) ?></span>
                        <div class="ci-panel-icon-badge">
                            <?= $panel['svg_icon'] ?>
                        </div>
                        <div class="ci-panel-short-title">
                            <span><?= sanitize_out($panel['short'] ?? $panel['title']) ?></span>
                        </div>
                        <div class="ci-panel-expand-pill">
                            <span class="expand-dot"></span>
                            <span>EXPAND</span>
                        </div>
                    </div>

                    <!-- EXPANDED STATE (Rich content with staggered entrance) -->
                    <div class="ci-panel-expanded" aria-hidden="<?= $i === 0 ? 'false' : 'true' ?>">
                        <div class="ci-panel-exp-header">
                            <div class="ci-panel-tag-group">
                                <span class="ci-panel-exp-num"><?= sanitize_out($panel['num']) ?></span>
                                <span class="ci-panel-exp-badge"><?= sanitize_out($panel['badge']) ?></span>
                                <span class="ci-panel-exp-status">
                                    <span class="status-pulse-dot" style="background: <?= sanitize_out($panel['status_color'] ?? '#10b981') ?>; box-shadow: 0 0 8px <?= sanitize_out($panel['status_color'] ?? '#10b981') ?>;"></span>
                                    <?= sanitize_out($panel['status']) ?>
                                </span>
                            </div>
                            <div class="ci-panel-exp-icon">
                                <?= $panel['svg_icon'] ?>
                            </div>
                        </div>

                        <h3 class="ci-panel-exp-title"><?= sanitize_out($panel['title']) ?></h3>
                        <p class="ci-panel-exp-desc"><?= sanitize_out($panel['desc']) ?></p>

                        <!-- Capabilities Tags -->
                        <div class="ci-panel-caps">
                            <?php foreach ($panel['capabilities'] as $cap): ?>
                                <span class="ci-cap-tag">
                                    <span class="ci-cap-dot"></span>
                                    <?= sanitize_out($cap) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <!-- Metric Highlight & CTA Footer -->
                        <div class="ci-panel-exp-footer">
                            <div class="ci-panel-metric-box">
                                <div class="ci-metric-value"><?= sanitize_out($panel['metric']) ?></div>
                                <div class="ci-metric-sub"><?= sanitize_out($panel['metric_sub']) ?></div>
                            </div>

                            <a href="#contact" class="ci-panel-cta" title="Inquire about <?= sanitize_out($panel['title']) ?>">
                                <span>Inquire Confidentially</span>
                                <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div><!-- /ci-panel -->
                <?php endforeach; ?>

            </div><!-- /ci-showcase-panels -->
        </div><!-- /ci-showcase-wrapper -->

    </div><!-- /container -->
</section><!-- /ci-showcase-section -->


<!-- ================================================================
     ABOUT OUR INVESTIGATIVE METHODOLOGY
================================================================ -->
<section class="section ci-approach" id="ci-approach">
    <div class="container">
        <div class="ci-approach-grid">

            <!-- Left: Image -->
            <div class="ci-approach-img-col ci-reveal">
                <div class="ci-approach-img-wrap">
                    <img src="assets/images/15_investigation_monitoring_room.png"
                         alt="Cyber Forensics & Investigation Operations Center" class="ci-approach-img" loading="lazy">
                    <div class="ci-approach-img-border"></div>
                    <div class="ci-approach-badge">
                        <div class="ci-approach-badge-icon">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <circle cx="12" cy="11" r="3"/>
                            </svg>
                        </div>
                        <div>
                            <strong>100%</strong>
                            <span>Confidential Inquiry</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content -->
            <div class="ci-approach-content">
                <span class="section-tag ci-reveal">
                    <span class="pulse-dot"></span>
                    OUR METHODOLOGY
                </span>

                <h2 class="ci-reveal">
                    Scientific Precision &amp;<br>
                    Discreet <span class="ci-grad-text">Investigative Rigor</span>
                </h2>

                <p class="ci-reveal">
                    We combine accredited digital forensic methodologies, court-tested evidence preservation, and global open-source intelligence to uncover facts that stand up to legal scrutiny.
                </p>

                <ul class="ci-approach-list">
                    <?php foreach ([
                        'ISO/IEC 27037 Evidence Handling & Chain-of-Custody',
                        'Legally Admissible Documentation & Expert Analysis',
                        'Advanced OSINT & Cross-Platform Forensic Tracking',
                        'Strict Non-Disclosure & 100% Case Confidentiality',
                    ] as $point): ?>
                    <li class="ci-reveal">
                        <span class="ci-check-icon">
                            <svg viewBox="0 0 20 20" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5">
                                <polyline points="4,10 8,14 16,6"/>
                            </svg>
                        </span>
                        <span><?= sanitize_out($point) ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <a href="#ci-services" class="btn primary-btn ci-approach-btn ci-reveal">
                    Explore Investigation Practices <span>&rarr;</span>
                </a>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================
     DIGITAL INVESTIGATION SERVICES (8 CORE PRACTICES)
================================================================ -->
<section class="section ci-services-section" id="ci-services">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                OUR SPECIALIZED PRACTICES
            </span>
            <h2>Comprehensive <span class="ci-grad-text">Digital Investigation</span> Solutions</h2>
            <p>From incident evidence recovery and cyber fraud tracing to OSINT and child safety, we provide legally sound investigations with complete discretion.</p>
        </div>

        <div class="ci-services-grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
            <?php foreach ($investigationServices as $svc): ?>
            <article class="ci-svc-card ci-reveal">
                <div class="ci-svc-img-wrap">
                    <img src="<?= sanitize_out($svc['image']) ?>" alt="<?= sanitize_out($svc['title']) ?>" class="ci-svc-img" loading="lazy">
                    <div class="ci-svc-img-gradient"></div>
                </div>
                <div class="ci-svc-body">
                    <h3><?= sanitize_out($svc['title']) ?></h3>
                    <p><?= sanitize_out($svc['description']) ?></p>
                    <a href="services/<?= sanitize_out($svc['slug']) ?>.php?section=forensics" class="ci-svc-link">
                        Explore Investigation <span>&rarr;</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     EVIDENTIARY PROCESS (5 FORENSIC TIMELINE NODES)
================================================================ -->
<section class="section ci-process-section" id="ci-process">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                EVIDENTIARY PROCESS
            </span>
            <h2>How We Conduct <span class="ci-grad-text">Digital Investigations</span></h2>
            <p>A structured, chain-of-custody compliant process designed to deliver verified facts and court-admissible results.</p>
        </div>

        <div class="ci-process-timeline-wrap ci-reveal">
            <div class="ci-process-line" aria-hidden="true"></div>
            <div class="ci-process-track">
                <?php foreach ($investigationProcess as $step): ?>
                <div class="ci-process-step">
                    <div class="ci-process-node">
                        <span class="ci-process-node-pulse"></span>
                        <span class="ci-process-node-num"><?= sanitize_out($step['num']) ?></span>
                    </div>
                    <h4><?= sanitize_out($step['title']) ?></h4>
                    <p><?= sanitize_out($step['desc']) ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>


<!-- ================================================================
     INCIDENTS & THREATS WE INVESTIGATE
================================================================ -->
<section class="section ci-risks-section" id="ci-risks">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <h2>Incidents &amp; Threats We <span class="ci-grad-text">Investigate</span></h2>
            <p>Specialized investigative capabilities across diverse cybercrime, financial fraud, and digital dispute categories.</p>
        </div>

        <div class="ci-risks-wrapper ci-reveal">
            <!-- Row 1: 6 tags -->
            <div class="ci-risks-row ci-risks-row-1">
                <?php foreach ($investigationThreatsRow1 as $threat): ?>
                <div class="ci-risk-tag">
                    <span class="ci-risk-dot"></span>
                    <span><?= sanitize_out($threat) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Row 2: 4 tags -->
            <div class="ci-risks-row ci-risks-row-2">
                <?php foreach ($investigationThreatsRow2 as $threat): ?>
                <div class="ci-risk-tag">
                    <span class="ci-risk-dot"></span>
                    <span><?= sanitize_out($threat) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>


<!-- ================================================================
     MEMBERSHIPS, ASSOCIATIONS & ACCREDITATIONS
================================================================ -->
<section class="section credentials-section" id="credentials" style="text-align: center; padding: 3.5rem 0; background: rgba(5, 5, 17, 0.7);">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                OUR CREDENTIALS
            </span>
            <h2>
                Memberships, Associations &amp; <span>Accreditations</span>
            </h2>
            <p style="max-width: 680px; margin: 0 auto 2.5rem; opacity: 0.85;">
                We are associated with reputable investigative organizations and certified bodies to ensure the highest standards of professionalism, ethics, and legal compliance.
            </p>
        </div>

        <!-- 4 Badges Display -->
        <div class="credentials-grid" style="display: flex; justify-content: center; align-items: center; gap: 2rem; flex-wrap: wrap;">
            <?php foreach ($accreds as $badge): ?>
                <div class="credentials-card" style="padding: 1rem 1.5rem; background: rgba(13, 11, 26, 0.8); border: 1px solid rgba(139, 32, 255, 0.25); border-radius: 14px; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
                    <div class="badge-card">
                        <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img" style="max-height: 55px; width: auto; object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.4));">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     GLOBAL FOOTPRINT
================================================================ -->
<section class="section ci-coverage-section" id="ci-coverage">
    <div class="container">

        <div class="ci-coverage-grid">

            <!-- Left: High-Tech Telemetry Map Card -->
            <div class="ci-coverage-map-col ci-reveal">
                <div class="ci-world-map-wrap">
                    <img src="assets/images/ci_global_map.jpg" alt="Global Cyber Investigation & Intelligence Network" class="ci-world-map-img" loading="lazy">
                </div>
            </div>

            <!-- Right: Content & 2x2 Stat Cards -->
            <div class="ci-coverage-content">
                <span class="section-tag ci-reveal">
                    <span class="pulse-dot"></span>
                    GLOBAL FOOTPRINT
                </span>

                <h2 class="ci-reveal">From Coimbatore <span class="ci-grad-text">to the World</span></h2>

                <p class="ci-reveal">
                    We provide discreet digital investigation and forensics services to individuals, legal practices, corporations, and law enforcement agencies across India and internationally.
                </p>

                <div class="ci-stats-row ci-reveal">
                    <div class="ci-stat-item">
                        <strong>15+</strong>
                        <span>Countries Covered</span>
                    </div>
                    <div class="ci-stat-item">
                        <strong>500+</strong>
                        <span>Cases Investigated</span>
                    </div>
                    <div class="ci-stat-item">
                        <strong>100%</strong>
                        <span>Confidentiality Guaranteed</span>
                    </div>
                    <div class="ci-stat-item">
                        <strong>99.4%</strong>
                        <span>Evidentiary Precision</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================
     TESTIMONIALS (3 CARDS)
================================================================ -->
<section class="section ci-testimonials" id="ci-testimonials">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                CASE TESTIMONIALS
            </span>
            <h2>What Our <span class="ci-grad-text">Clients Say</span></h2>
        </div>

        <div class="ci-testi-grid">
            <?php foreach ($testimonials as $t): ?>
            <div class="ci-testi-card ci-reveal">
                <div class="ci-testi-quote-icon">&ldquo;</div>
                <p class="ci-testi-quote"><?= sanitize_out($t['quote']) ?></p>
                <div class="ci-testi-author">
                    <img src="<?= sanitize_out($t['avatar']) ?>" alt="<?= sanitize_out($t['name']) ?>" class="ci-testi-avatar-img" loading="lazy">
                    <div class="ci-testi-meta">
                        <strong><?= sanitize_out($t['name']) ?></strong>
                        <span><?= sanitize_out($t['role']) ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     FAQ (HELP CENTER)
================================================================ -->
<section class="section ci-faq-section" id="ci-faq">
    <div class="container">

        <div class="ci-faq-grid">

            <div class="ci-faq-left ci-reveal">
                <span class="section-tag">
                    <span class="pulse-dot"></span>
                    HELP CENTER
                </span>
                <h2>Frequently Asked <span class="ci-grad-text">Questions</span></h2>
                <p>Have questions regarding evidence admissibility, confidentiality, or case timelines? Our forensic team is ready to assist.</p>
                <a href="#contact" class="btn primary-btn ci-faq-btn">
                    <span>Ask a Question</span>
                    <small>or Get Free Confidential Consult</small>
                </a>
            </div>

            <div class="ci-faq-list">
                <?php foreach ($cyberFaqs as $faq): ?>
                <div class="ci-faq-item ci-reveal">
                    <button class="ci-faq-q" type="button" aria-expanded="false">
                        <span><?= sanitize_out($faq['q']) ?></span>
                        <span class="ci-faq-arrow">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6"/>
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

    </div>
</section>


<!-- ================================================================
     FINAL CTA & CONFIDENTIAL INQUIRY FORM
================================================================ -->
<section class="ci-final-cta" id="contact" style="padding: 4.5rem 0;">
    <!-- Background digital network canvas -->
    <canvas id="ciCtaCanvas" class="ci-cta-canvas" aria-hidden="true"></canvas>

    <div class="container ci-cta-inner">
        <span class="section-tag ci-reveal">
            <span class="pulse-dot"></span>
            CONFIDENTIAL INQUIRY
        </span>
        <h2>Need a Discreet <span class="ci-grad-text">Digital Investigation?</span></h2>
        <p class="ci-cta-tagline ci-reveal">
            Speak directly with our senior forensic investigators. All consultations are 100% confidential and protected by strict non-disclosure agreements.
        </p>

        <div class="ci-cta-btns ci-reveal" style="margin-bottom: 2.5rem;">
            <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn primary-btn">
                <span>&#x1F4DE;</span> Call Senior Investigator ➔
            </a>
            <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" class="btn outline-btn">
                <span>&#x2709;&#xFE0F;</span> Email Investigation Team
            </a>
        </div>

        <!-- Interactive PHP Contact Form -->
        <div class="contact-form-wrapper ci-reveal" style="width: 100%; max-width: 820px; margin: 0 auto; text-align: left; background: rgba(13, 11, 26, 0.9); padding: 2.2rem; border-radius: 20px; border: 1px solid rgba(139, 32, 255, 0.35); box-shadow: 0 20px 50px rgba(0,0,0,0.6); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);">
            <form id="contactForm" action="process-contact.php" method="POST">
                <div id="formResponse" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;"></div>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                    <div>
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Your Name *</label>
                        <input type="text" id="name" name="name" required placeholder="John Doe" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                    </div>
                    <div>
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Email Address *</label>
                        <input type="email" id="email" name="email" required placeholder="john@example.com" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                    <div>
                        <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone / WhatsApp *</label>
                        <input type="tel" id="phone" name="phone" required placeholder="+91 98765 43210" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                    </div>
                    <div>
                        <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Investigation Service Required</label>
                        <select id="service" name="service" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: #130f28; border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                            <option value="">Select an Investigation Practice</option>
                            <?php foreach ($investigationFormServices as $formService): ?>
                                <option value="<?= sanitize_out($formService) ?>"><?= sanitize_out($formService) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="message" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Case Overview / Incident Details *</label>
                    <textarea id="message" name="message" rows="4" required placeholder="Describe the suspected breach, affected devices/platforms, or required evidence preservation (strictly confidential)..." style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; resize: vertical; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;"></textarea>
                </div>

                <!-- Google reCAPTCHA -->
                <div class="recaptcha-wrapper" style="margin-bottom: 1.5rem;">
                    <div class="g-recaptcha" data-sitekey="<?= sanitize_out(RECAPTCHA_SITE_KEY) ?>" data-theme="dark"></div>
                </div>

                <button type="submit" class="btn primary-btn" style="cursor: pointer; border: none; width: 100%; justify-content: center; font-size: 1.05rem; padding: 1.05rem;">
                    Submit Confidential Investigation Request ➔
                </button>
            </form>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const faqItems = document.querySelectorAll('.ci-faq-item');
    faqItems.forEach(function (item) {
        const btn = item.querySelector('.ci-faq-q');
        if (!btn) return;
        btn.addEventListener('click', function () {
            const isOpen = item.classList.contains('ci-faq-open');
            faqItems.forEach(function (other) {
                if (other !== item) {
                    other.classList.remove('ci-faq-open');
                    const otherBtn = other.querySelector('.ci-faq-q');
                    if (otherBtn) otherBtn.setAttribute('aria-expanded', 'false');
                }
            });
            item.classList.toggle('ci-faq-open', !isOpen);
            btn.setAttribute('aria-expanded', !isOpen ? 'true' : 'false');
        });
    });
});
</script>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
