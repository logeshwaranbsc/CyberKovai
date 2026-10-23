<?php
/**
 * Cyber Kovai — Cyber Intelligence Services Page
 */
require_once __DIR__ . '/config.php';

$pageTitle       = 'Cyber Intelligence Services';
$pageDescription = 'Proactive cyber intelligence solutions to detect risks, investigate digital threats, conduct advanced forensics and protect your sensitive information. CyberKovai, Coimbatore.';

// Interactive Cyber Command Console 4-Pillar Data
$cyberPillars = [
    [
        'id'          => 'pillar-threat',
        'num'         => '01',
        'code'        => 'VEC-01 // THREAT_INTEL',
        'badge'       => 'PROACTIVE HUNTING',
        'title'       => 'Threat Intelligence & Detection',
        'metric'      => '99.8% Threat Intercept Rate',
        'metric_sub'  => 'Surface, Deep & Dark Web Coverage',
        'meter'       => '99',
        'encryption'  => 'ZERO-DAY FEEDS / TLS 1.3',
        'standard'    => 'ISO 27001 & SOC 2',
        'log'         => 'Threat Hunter active. 99.8% intercept rate confirmed across 4,200 IOCs.',
        'desc'        => 'Proactive threat hunting and global telemetry tracking across surface, deep, and dark web threat vectors before adversarial campaigns reach your infrastructure.',
        'target_id'   => 'target-threat',
        'coords'      => 'LAT 11.0168° N / LNG 76.9558° E',
        'status'      => 'MONITORING ACTIVE',
        'status_color'=> '#10b981',
        'image'       => 'assets/images/22_threat_intelligence.jpg',
        'capabilities'=> ['Dark Web Surveillance', 'Zero-Day IOC Feeds', 'Adversary Attribution', 'Early Warning Radar'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m4.93 4.93 4.24 4.24"/><path d="m14.83 9.17 4.24-4.24"/><path d="m14.83 14.83 4.24 4.24"/><path d="m9.17 14.83-4.24 4.24"/><circle cx="12" cy="12" r="4"/></svg>'
    ],
    [
        'id'          => 'pillar-forensics',
        'num'         => '02',
        'code'        => 'VEC-02 // DIGITAL_FORENSICS',
        'badge'       => 'EVIDENCE INTEGRITY',
        'title'       => 'Incident Forensics & Investigation',
        'metric'      => '100% Cryptographic Verification',
        'metric_sub'  => 'ISO/IEC 27037 Evidence Standard',
        'meter'       => '100',
        'encryption'  => 'SHA-256 VAULT / HSM',
        'standard'    => 'ISO/IEC 27037 COURT STANDARD',
        'log'         => 'Forensic Triage: Cryptographic SHA-256 hash verified. Chain-of-custody sealed.',
        'desc'        => 'Court-admissible digital artifact extraction, memory volatile capture, root-cause breach tracing, and complete forensic timeline reconstruction.',
        'target_id'   => 'target-forensics',
        'coords'      => 'SEC-HASH: SHA256-VAULT-VERIFIED',
        'status'      => 'CHAIN-OF-CUSTODY READY',
        'status_color'=> '#8b20ff',
        'image'       => 'assets/images/23_digital_forensics.jpg',
        'capabilities'=> ['Memory & Disk Imaging', 'Malware Reverse Engineering', 'Cryptographic Hashing', 'Court-Ready Expert Reports'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-7.07 17.07l.07.07"/><path d="M12 6a6 6 0 0 0-4.24 10.24"/><path d="M12 10a2 2 0 0 0-1.41 3.41"/><path d="M12 18v4"/><path d="M8 22h8"/><circle cx="12" cy="12" r="1"/></svg>'
    ],
    [
        'id'          => 'pillar-risk',
        'num'         => '03',
        'code'        => 'VEC-03 // CYBER_RISK',
        'badge'       => 'SURFACE AUDITING',
        'title'       => 'Risk Assessment & Attack Surface',
        'metric'      => '140+ Attack Vectors Audited',
        'metric_sub'  => 'CVSS v3.1 / OWASP Top 10 Aligned',
        'meter'       => '95',
        'encryption'  => 'CVSS v3.1 / OWASP DEFENSE',
        'standard'    => 'NIST CSF & OWASP TOP 10',
        'log'         => 'Risk Audit: 140+ attack surfaces scanned. Zero critical perimeter exposures detected.',
        'desc'        => 'Systematic auditing of external perimeter, APIs, cloud environments, and internal network segments to identify and remediate zero-day exposures.',
        'target_id'   => 'target-risk',
        'coords'      => 'PERIMETER: 0 EXPOSED SERVICES',
        'status'      => 'VAPT SHIELD ACTIVE',
        'status_color'=> '#3da9fc',
        'image'       => 'assets/images/24_cyber_risk_assessment.jpg',
        'capabilities'=> ['Vulnerability Assessment', 'Web & Mobile Pen Testing', 'Cloud Hardening Review', 'Executive Risk Scorecard'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>'
    ],
    [
        'id'          => 'pillar-data',
        'num'         => '04',
        'code'        => 'VEC-04 // DATA_PROTECTION',
        'badge'       => 'ZERO-TRUST ENCRYPTION',
        'title'       => 'Data Shielding & Governance',
        'metric'      => 'AES-256 GCM Protection',
        'metric_sub'  => 'Zero Data Leakage Tolerance',
        'meter'       => '100',
        'encryption'  => 'AES-256-GCM / HARDWARE HSM',
        'standard'    => 'GDPR / HIPAA / ISO 27701',
        'log'         => 'Data Shield: Hardware HSM keys loaded. Memory-level immutability active.',
        'desc'        => 'Enterprise Data Loss Prevention (DLP) frameworks, cryptographic key management, and credential shielding protecting sensitive proprietary assets.',
        'target_id'   => 'target-data',
        'coords'      => 'ENCRYPTION: HARDWARE HSM KEY',
        'status'      => 'VAULT SECURED',
        'status_color'=> '#ff8c42',
        'image'       => 'assets/images/25_data_protection.jpg',
        'capabilities'=> ['Enterprise DLP Controls', 'Privileged Identity Shielding', 'Ransomware Immutability', 'Compliance Audit Trails'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/><circle cx="12" cy="16" r="1.5"/></svg>'
    ],
];
// Backwards compatibility
$cyberPanels = $cyberPillars;

// 6 Cyber Services with Rich Visuals
$cyberServices = [
    [
        'image' => 'assets/images/ci_service_risk.jpg',
        'title' => 'Cyber Risk Assessment',
        'desc'  => 'Identify vulnerabilities, assess risks and strengthen your security posture with comprehensive cyber risk assessments.',
    ],
    [
        'image' => 'assets/images/ci_service_forensics.jpg',
        'title' => 'Digital Forensics',
        'desc'  => 'Recover, analyze and preserve digital evidence to help you uncover the root causes of incidents effectively and meet forensic standards.',
    ],
    [
        'image' => 'assets/images/ci_service_social.jpg',
        'title' => 'Social Media Investigation',
        'desc'  => 'Uncover digital footprints, monitor online activity and verify tasks from social media for personal and corporate matters.',
    ],
    [
        'image' => 'assets/images/ci_service_data.jpg',
        'title' => 'Data & Information Security',
        'desc'  => 'Protect sensitive data and prevent unauthorized access with end-to-end security frameworks and data protection strategies.',
    ],
    [
        'image' => 'assets/images/ci_service_advisory.jpg',
        'title' => 'Cyber Security Advisory',
        'desc'  => 'Strategic guidance to strengthen your cyber resilience with policies, risk reduction strategies and best practices.',
    ],
    [
        'image' => 'assets/images/ci_service_fraud.jpg',
        'title' => 'Fraud & Deception Prevention',
        'desc'  => 'Detect hidden frauds, verify digital identities and protect your business from financial and reputational risks.',
    ],
];

// Protection Process (5 Steps)
$cyberProcess = [
    ['num'=>'01', 'title'=>'Detect',     'desc'=>'Identify potential threats across your systems and digital ecosystem.'],
    ['num'=>'02', 'title'=>'Investigate','desc'=>'Analyze and isolate suspicious activities with forensic rigor.'],
    ['num'=>'03', 'title'=>'Analyze',    'desc'=>'Assess risks and derive actionable intelligence from collected data.'],
    ['num'=>'04', 'title'=>'Respond',    'desc'=>'Take immediate action to contain and mitigate security incidents.'],
    ['num'=>'05', 'title'=>'Protect',    'desc'=>'Strengthen defenses with continuous monitoring and security upgrades.'],
];

// Cyber risk tags matching Image 2
$cyberRisksRow1 = [
    'Malware & Ransomware',
    'Phishing Attacks',
    'Data Breaches',
    'Insider Threats',
    'Social Engineering',
    'Account Takeover',
];
$cyberRisksRow2 = [
    'Dark Web Monitoring',
    'Business Email Compromise',
    'Brand Impersonation',
    'IoT Risks',
];

// Testimonials matching Image 2
$testimonials = [
    [
        'quote'  => 'CyberKovai helped us identify critical vulnerabilities before it became a crisis and invaluable to our team! A highly professional and dedicated partner for security needs.',
        'name'   => 'Karthik',
        'role'   => 'Director, Manufacturing',
        'avatar' => 'assets/images/avatar_karthik.jpg',
    ],
    [
        'quote'  => 'Their digital forensics expertise and investigation skills made a significant difference for our organization. Highly recommend their services.',
        'name'   => 'Priya S.',
        'role'   => 'IT Head, HealthCare',
        'avatar' => 'assets/images/avatar_priya.jpg',
    ],
    [
        'quote'  => 'Quick response, deep technical knowledge and clear guidance. A trusted partner for our security needs.',
        'name'   => 'Aravind K.',
        'role'   => 'Manager, IT & Compliance',
        'avatar' => 'assets/images/avatar_aravind.jpg',
    ],
];

// FAQs matching Image 2
$cyberFaqs = [
    [
        'q' => 'What cyber intelligence services do you offer?',
        'a' => 'We offer Cyber Risk Assessment, Digital Forensics, Social Media Investigation, Data & Information Security, Cyber Security Advisory, and Fraud & Deception Prevention services.'
    ],
    [
        'q' => 'How long does an investigation take?',
        'a' => 'Investigation timelines vary based on complexity, typically ranging from 3 to 21 working days. We provide regular progress updates throughout.'
    ],
    [
        'q' => 'Is our information kept confidential?',
        'a' => 'Yes. 100% confidentiality is guaranteed. All client information, case details and findings are protected under strict non-disclosure protocols.'
    ],
    [
        'q' => 'Do you provide support for international cases?',
        'a' => 'Yes. We extend our cyber intelligence services to clients across India and internationally, with coverage in Singapore, Australia, Germany, Canada, UAE and more.'
    ],
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
                CYBER INTELLIGENCE SERVICES
            </div>

            <h1 class="ci-hero-heading ci-reveal">
                Protect Your<br>
                <span class="ci-grad-text">Digital World</span>
            </h1>

            <p class="ci-hero-desc ci-reveal">
                Proactive cyber intelligence solutions to detect risks, investigate digital threats, conduct advanced forensics and protect your sensitive information.
            </p>

            <div class="ci-hero-trust ci-reveal">
                <span>&#10003; Threat Detection</span>
                <span>&#10003; Risk Assessment</span>
                <span>&#10003; Data Protection</span>
            </div>

            <div class="ci-hero-btns ci-reveal">
                <a href="digital-forensics.php?section=cyber" class="btn outline-btn">
                    <span>&#x2190;</span> Explore Cyber Intelligence
                </a>
                <a href="#ci-services" class="btn primary-btn">
                    Explore Cyber Services <span>&#x2192;</span>
                </a>
                <a href="#contact" class="btn outline-btn">
                    Talk to an Expert
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
                <div class="ci-arc-label ci-arc-top">THREAT DETECTION</div>
                <div class="ci-arc-label ci-arc-right">DIGITAL FORENSICS</div>
                <div class="ci-arc-label ci-arc-bottom">RISK ASSESSMENT</div>
                <div class="ci-arc-label ci-arc-left">DATA SECURITY</div>
            </div>

            <!-- Floating feature cards -->
            <div class="ci-float-card ci-fc-1">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Threat Detection</span>
            </div>
            <div class="ci-float-card ci-fc-2">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                <span>Digital Forensics</span>
            </div>
            <div class="ci-float-card ci-fc-3">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/></svg>
                <span>Risk Assessment</span>
            </div>
            <div class="ci-float-card ci-fc-4">
                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>Data Security</span>
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
                INTELLIGENCE MONITORING
            </div>

        </div><!-- /ci-hero-visual -->

    </div><!-- /container -->

</section><!-- /ci-hero -->


<!-- ================================================================
     4-PILLAR ANIMATED HORIZONTAL EXPANDING SHOWCASE
================================================================ -->
<section class="section ci-showcase-section" id="ci-showcase" aria-label="Cyber Defense Intelligence Pillars">
    <div class="ci-showcase-ambient-glow" aria-hidden="true"></div>

    <div class="container">
        
        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                CORE INTELLIGENCE PILLARS
            </span>
            <h2>
                Real-Time Cyber <span>Defense Matrix</span>
            </h2>
            <p class="section-desc" style="max-width: 740px; margin: 0 auto;">
                Continuous 360° telemetry monitoring, multi-quadrant threat vector scanning, and active countermeasures across our four operational intelligence pillars.
            </p>
        </div>

        <div class="ci-showcase-wrapper ci-reveal">
            <div class="ci-showcase-panels" id="ciShowcasePanels" role="tablist" aria-label="Cyber Intelligence Pillars">

                <?php foreach ($cyberPillars as $i => $panel): ?>
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
                                <span>Explore Service</span>
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
     ABOUT OUR APPROACH
================================================================ -->
<section class="section ci-approach" id="ci-approach">
    <div class="container">
        <div class="ci-approach-grid">

            <!-- Left: Image -->
            <div class="ci-approach-img-col ci-reveal">
                <div class="ci-approach-img-wrap">
                    <img src="assets/images/ci_analyst_approach.jpg"
                         alt="Cyber Analyst Operations Center" class="ci-approach-img" loading="lazy">
                    <div class="ci-approach-img-border"></div>
                    <div class="ci-approach-badge">
                        <div class="ci-approach-badge-icon">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </div>
                        <div>
                            <strong>24/7</strong>
                            <span>Threat Monitoring</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content -->
            <div class="ci-approach-content">
                <span class="section-tag ci-reveal">
                    <span class="pulse-dot"></span>
                    OUR APPROACH
                </span>

                <h2 class="ci-reveal">
                    Proactive Intelligence<br>
                    for a <span class="ci-grad-text">Safer Tomorrow</span>
                </h2>

                <p class="ci-reveal">
                    We help organizations detect, investigate and respond to cyber threats before they cause business disruption.
                </p>

                <ul class="ci-approach-list">
                    <?php foreach ([
                        'Real-Time Threat Monitoring',
                        'Actionable Intelligence & Insights',
                        'Advanced Forensic Analysis',
                        'Customized Security Solutions',
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
                    Learn More About Cyber Intelligence <span>&rarr;</span>
                </a>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================
     CYBER SERVICES (6 CARDS WITH RICH PHOTO HEADERS)
================================================================ -->
<section class="section ci-services-section" id="ci-services">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                OUR SERVICES
            </span>
            <h2>Comprehensive <span class="ci-grad-text">Cyber Intelligence</span> Solutions</h2>
            <p>From risk and cyber intelligence services to digital forensics, detection, investigation, response and long-term protection.</p>
        </div>

        <div class="ci-services-grid">
            <?php foreach ($cyberServices as $svc): ?>
            <article class="ci-svc-card ci-reveal">
                <div class="ci-svc-img-wrap">
                    <img src="<?= sanitize_out($svc['image']) ?>" alt="<?= sanitize_out($svc['title']) ?>" class="ci-svc-img" loading="lazy">
                    <div class="ci-svc-img-gradient"></div>
                </div>
                <div class="ci-svc-body">
                    <h3><?= sanitize_out($svc['title']) ?></h3>
                    <p><?= sanitize_out($svc['desc']) ?></p>
                    <a href="#contact" class="ci-svc-link">
                        Learn More <span>&rarr;</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     PROTECTION PROCESS (5 SLEEK TIMELINE NODES)
================================================================ -->
<section class="section ci-process-section" id="ci-process">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                OUR PROCESS
            </span>
            <h2>How We <span class="ci-grad-text">Protect Your Business</span></h2>
            <p>A structured and proactive approach to cyber resilience.</p>
        </div>

        <div class="ci-process-timeline-wrap ci-reveal">
            <div class="ci-process-line" aria-hidden="true"></div>
            <div class="ci-process-track">
                <?php foreach ($cyberProcess as $step): ?>
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
     CYBER RISKS WE HELP YOU IDENTIFY
================================================================ -->
<section class="section ci-risks-section" id="ci-risks">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <h2>Cyber Risks We Help You <span class="ci-grad-text">Identify</span></h2>
            <p>Stay ahead of evolving threats with real-time monitoring and intelligence.</p>
        </div>

        <div class="ci-risks-wrapper ci-reveal">
            <!-- Row 1: 6 tags -->
            <div class="ci-risks-row ci-risks-row-1">
                <?php foreach ($cyberRisksRow1 as $risk): ?>
                <div class="ci-risk-tag">
                    <span class="ci-risk-dot"></span>
                    <span><?= sanitize_out($risk) ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Row 2: 4 tags -->
            <div class="ci-risks-row ci-risks-row-2">
                <?php foreach ($cyberRisksRow2 as $risk): ?>
                <div class="ci-risk-tag">
                    <span class="ci-risk-dot"></span>
                    <span><?= sanitize_out($risk) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
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
                    <img src="assets/images/ci_global_map.jpg" alt="Global Cyber Threat & Telemetry Network" class="ci-world-map-img" loading="lazy">
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
                    We provide cyber intelligence and forensics services to businesses, government agencies and law enforcement, with a trusted network of specialists across 15+ countries.
                </p>

                <div class="ci-stats-row ci-reveal">
                    <div class="ci-stat-item">
                        <strong>15+</strong>
                        <span>Countries</span>
                    </div>
                    <div class="ci-stat-item">
                        <strong>500+</strong>
                        <span>Investigations</span>
                    </div>
                    <div class="ci-stat-item">
                        <strong>24/7</strong>
                        <span>Threat Monitoring</span>
                    </div>
                    <div class="ci-stat-item">
                        <strong>99%</strong>
                        <span>Business Trust</span>
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
                TESTIMONIALS
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
                <p>Have more questions? Our team is ready to help.</p>
                <a href="#contact" class="btn primary-btn ci-faq-btn">
                    <span>View All FAQs</span>
                    <small>or Get Free Expert Consult</small>
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
     FINAL CTA (SECURE YOUR ASSETS)
================================================================ -->
<section class="ci-final-cta" id="contact">
    <!-- Background digital network canvas -->
    <canvas id="ciCtaCanvas" class="ci-cta-canvas" aria-hidden="true"></canvas>

    <div class="container ci-cta-inner">
        <span class="section-tag ci-reveal">
            <span class="pulse-dot"></span>
            SECURE YOUR ASSETS
        </span>
        <p class="ci-cta-tagline ci-reveal">
            Partner with CyberKovai for proactive cyber intelligence and comprehensive security solutions.
        </p>
        <div class="ci-cta-btns ci-reveal">
            <a href="#ci-services" class="btn primary-btn">
                Explore Cyber Services <span>&rarr;</span>
            </a>
            <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn outline-btn">
                Talk to an Expert
            </a>
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
