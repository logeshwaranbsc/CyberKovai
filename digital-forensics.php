<?php
/**
 * Cyber Kovai — Cyber Security & Offensive Threat Defense
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/forensic-icons.php';

$activeSection   = 'cyber';
$pageTitle       = 'Cyber Security & Offensive Threat Defense | ' . SITE_NAME;
$pageDescription = 'Comprehensive cybersecurity solutions, certified ethical hacking, VAPT, cloud security, network defense, and enterprise cyber resilience by CyberKovai.';

// Cyber Security Stats
$cyberStats = [
    ['value' => '500+',   'label' => 'SECURITY AUDITS COMPLETED'],
    ['value' => '10k+',   'label' => 'VULNERABILITIES REMEDIATED'],
    ['value' => '99.9%',  'label' => 'THREAT MITIGATION RATE'],
    ['value' => '140+',   'label' => 'ATTACK VECTORS AUDITED'],
    ['value' => '0',      'label' => 'CRITICAL RESIDUAL EXPOSURES']
];

// 7 Cyber Security Core Practices
$cyberPractices = function_exists('ck_get_cyber_practices') ? ck_get_cyber_practices(false) : [];
if (empty($cyberPractices)) {
    $cyberPractices = [
        [
            'id'          => '01',
            'title'       => 'Vulnerability Assessment & Pen Testing (VAPT)',
            'slug'        => 'vulnerability-assessment-penetration-testing',
            'link'        => 'services/vulnerability-assessment-penetration-testing.php',
            'tag'         => '// APPSEC-01',
            'badge'       => 'PRIMARY PRACTICE',
            'status_text' => 'ARMORED',
            'icon'        => '🛡️',
            'is_hero'     => true,
            'description' => 'Simulate real-world attacks across web applications, APIs, mobile apps, and systems to uncover exploitable flaws before adversaries do.'
        ],
        [
            'id'          => '02',
            'title'       => 'Network & Wireless Penetration Testing',
            'slug'        => 'network-penetration-testing',
            'link'        => 'services/network-penetration-testing.php',
            'tag'         => '// NETSEC-02',
            'badge'       => '',
            'status_text' => 'ARMORED',
            'icon'        => '🌐',
            'is_hero'     => false,
            'description' => 'Comprehensive perimeter and internal network auditing, firewall rulebase evaluations, and rogue wireless access point testing.'
        ],
        [
            'id'          => '03',
            'title'       => 'Cloud Security & Posture Management (CSPM)',
            'slug'        => 'cloud-configuration-review',
            'link'        => 'services/cloud-configuration-review.php',
            'tag'         => '// CLOUD-03',
            'badge'       => '',
            'status_text' => 'ARMORED',
            'icon'        => '☁️',
            'is_hero'     => false,
            'description' => 'Audit AWS, Azure, and GCP architectures for misconfigurations, excessive IAM privileges, CASA compliance, and container vulnerabilities.'
        ],
        [
            'id'          => '04',
            'title'       => 'Virtual CISO (vCISO) & Executive Advisory',
            'slug'        => 'virtual-ciso-services',
            'link'        => 'services/virtual-ciso-services.php',
            'tag'         => '// ENTPR-04',
            'badge'       => 'PRIMARY PRACTICE',
            'status_text' => 'ARMORED',
            'icon'        => '👔',
            'is_hero'     => true,
            'description' => 'Strategic cybersecurity leadership, governance, vendor risk management, and regulatory alignment with ISO 27001, SOC 2, and NIST.'
        ],
        [
            'id'          => '05',
            'title'       => 'REST & GraphQL API Security Testing',
            'slug'        => 'api-penetration-testing',
            'link'        => 'services/api-penetration-testing.php',
            'tag'         => '// APISEC-05',
            'badge'       => '',
            'status_text' => 'ARMORED',
            'icon'        => '⚡',
            'is_hero'     => false,
            'description' => 'Deep technical auditing for OWASP API Security Top 10 vulnerabilities, broken authentication, rate-limiting flaws, and mass assignment.'
        ],
        [
            'id'          => '06',
            'title'       => 'Secure Source Code Review (SAST/DAST)',
            'slug'        => 'secure-source-code-review',
            'link'        => 'services/secure-source-code-review.php',
            'tag'         => '// DEVSEC-06',
            'badge'       => '',
            'status_text' => 'ARMORED',
            'icon'        => '💻',
            'is_hero'     => false,
            'description' => 'Automated and manual line-by-line static analysis to identify hidden backdoors, cryptographic bugs, and code injection vulnerabilities.'
        ],
        [
            'id'          => '07',
            'title'       => 'Zero-Trust Architecture & Threat Hardening',
            'slug'        => 'security-architecture-review',
            'link'        => 'services/security-architecture-review.php',
            'tag'         => '// ZEROTRUST-07',
            'badge'       => '',
            'status_text' => 'ARMORED',
            'icon'        => '🔒',
            'is_hero'     => false,
            'description' => 'Enterprise identity defense, Microsoft 365 hardening, network segmentation, and micro-perimeter security to stop ransomware spread.'
        ],
        [
            'id'          => '08',
            'title'       => 'AI Security & LLM Red Teaming',
            'slug'        => 'ai-security',
            'link'        => 'services/ai-security.php',
            'tag'         => '// AISEC-08',
            'badge'       => 'AI DEFENSE PRACTICE',
            'status_text' => 'ARMORED',
            'icon'        => '🤖',
            'is_hero'     => true,
            'description' => 'Adversarial prompt injection testing, RAG pipeline defense, model weight integrity, and LLM guardrail auditing to secure enterprise AI.'
        ]
    ];
}
$cyberPracticesSettings = function_exists('ck_get_cyber_practices_settings') ? ck_get_cyber_practices_settings() : [
    'tag'      => 'OUR PRACTICES',
    'title'    => 'Core Cyber Practices. One Standard: <span>Uncompromising Defense.</span>',
    'subtitle' => 'Comprehensive offensive and defensive cybersecurity practices engineered for modern digital enterprises.'
];

// Cyber Defense Lifecycle (5 Steps)
$cyberProcessSteps = [
    [
        'num'   => '01',
        'title' => 'Scoping & Reconnaissance',
        'desc'  => 'Map external attack surfaces, identify target domains, cloud assets, and APIs.'
    ],
    [
        'num'   => '02',
        'title' => 'Vulnerability Exploitation',
        'desc'  => 'Execute automated scans and certified manual exploit testing aligned with OWASP & NIST.'
    ],
    [
        'num'   => '03',
        'title' => 'Risk Scoring & Analysis',
        'desc'  => 'Quantify business impact using CVSS v3.1 metrics and map full attack chains.'
    ],
    [
        'num'   => '04',
        'title' => 'Remediation Roadmap',
        'desc'  => 'Deliver executive summaries and technical reports with exact step-by-step fix guides.'
    ],
    [
        'num'   => '05',
        'title' => 'Verification & Attestation',
        'desc'  => 'Perform complimentary re-testing and issue a verifiable Security Attestation Certificate.'
    ]
];

// Cyber Client Tiers
$cyberClientTypes = [
    ['icon' => '🚀', 'title' => 'High-Growth Startups', 'desc' => 'Securing MVP architectures, passing enterprise vendor risk assessments, and pre-launch VAPT.'],
    ['icon' => '🏢', 'title' => 'Regional SaaS & Mid-Market', 'desc' => 'Continuous vulnerability management, SOC 2 compliance readiness, and API protection.'],
    ['icon' => '🏙️', 'title' => 'High-Capacity Enterprises', 'desc' => 'Comprehensive red teaming, multi-cloud hardening, ERP auditing, and zero-trust engineering.'],
    ['icon' => '🏛️', 'title' => 'Institutional & Public Sector', 'desc' => 'Safeguarding critical public infrastructure, sovereign data, and compliance audits.'],
    ['icon' => '🌐', 'title' => 'Global Multinationals', 'desc' => 'Distributed attack surface management, supply chain assessments, and executive vCISO advisory.']
];

// Credentials / Accreditations (Dynamically managed via Admin Panel)
$accreds = function_exists('ck_get_accreditations') ? ck_get_accreditations('cyber', false) : [
    ['img' => 'assets/images/aid.png',   'alt' => 'AID - Association of Investigators and Detectives'],
    ['img' => 'assets/images/tapdi.png', 'alt' => 'TAPDI - Tamilnadu Association of Professional Detectives and Investigators'],
    ['img' => 'assets/images/apdi.png',  'alt' => 'APDI - Association of Professional Detectives & Investigators'],
    ['img' => 'assets/images/unip.svg',   'alt' => 'UNIP - Unified Network of Investigative Professionals']
];

// Cyber Attack Surface Simulator Probes
$cyberRiskTools = [
    ['icon' => '🌐', 'title' => 'Web App & API Vulnerability Probe', 'desc' => 'Scan for SQLi, XSS, SSRF, BOLA, and OWASP Top 10 exploits'],
    ['icon' => '🛡️', 'title' => 'Perimeter & Port Exposure Scan',   'desc' => 'Detect open firewall ports, exposed services & DNS leaks'],
    ['icon' => '☁️', 'title' => 'Cloud Misconfiguration Audit',     'desc' => 'Uncover open S3 buckets, IAM privilege flaws & GCP risks'],
    ['icon' => '🦠', 'title' => 'Ransomware & Malware Resilience',   'desc' => 'Evaluate endpoint defense & lateral movement barriers'],
    ['icon' => '💻', 'title' => 'Source Code & Secret Leak Probe',   'desc' => 'Detect exposed API keys, credentials, and CVE-prone libraries'],
    ['icon' => '🎣', 'title' => 'Phishing & Identity Compromise',   'desc' => 'Simulate credential stuffing, spear-phishing & auth bypass'],
    ['icon' => '📦', 'title' => 'Supply Chain & Third-Party Audit',  'desc' => 'Identify vulnerabilities in vendor dependencies & integrations'],
    ['icon' => '📋', 'title' => 'Regulatory & Compliance Check',    'desc' => 'Evaluate readiness for ISO 27001, SOC 2, HIPAA & NIST CSF']
];

// Cybersecurity FAQs (Dynamically loaded from Storage)
$cyberFaqs = function_exists('ck_get_faqs') ? ck_get_faqs('cyber', false) : [
    [
        'question' => 'What cybersecurity services does Cyber Kovai provide?',
        'answer'   => 'Cyber Kovai provides comprehensive offensive and defensive cybersecurity solutions, including Vulnerability Assessment and Penetration Testing (VAPT), Web & Mobile Application Security, Network Penetration Testing, Cloud Security Audits (AWS, GCP, Azure), API Security, Virtual CISO (vCISO) Advisory, Secure Code Review, and Zero-Trust Architecture Hardening.'
    ],
    [
        'question' => 'What standards and frameworks do you follow during testing?',
        'answer'   => 'Our security testing strictly adheres to industry-leading frameworks including OWASP Top 10, OWASP API Security Top 10, NIST SP 800-115, SANS/CWE 25, and PTES (Penetration Testing Execution Standard), ensuring thorough and standardized vulnerability discovery.'
    ],
    [
        'question' => 'How long does a security assessment or penetration test take?',
        'answer'   => 'Assessment timelines depend on scope and infrastructure size. A typical web application or network VAPT takes between 3 to 10 business days. We provide continuous interim alerts for any critical zero-day discoveries followed by a detailed formal report.'
    ],
    [
        'question' => 'Do you provide re-testing after our engineering team fixes vulnerabilities?',
        'answer'   => 'Yes. We include complimentary verification re-testing within 30 days to confirm that reported vulnerabilities are properly patched, followed by the issuance of a formal Certificate of Security Attestation.'
    ],
    [
        'question' => 'How is our proprietary source code and sensitive infrastructure protected?',
        'answer'   => 'All engagements are conducted under legally binding Non-Disclosure Agreements (NDAs). We utilize encrypted communication channels, secure isolated testing pods, and strict data-handling protocols aligned with ISO 27001.'
    ]
];

// Contact Form Services List (dynamically mapped from active cyber services)
$activeCyberServicesList = function_exists('ck_get_cyber_services') ? ck_get_cyber_services(false) : [];
$cyberFormServices = !empty($activeCyberServicesList)
    ? array_column($activeCyberServicesList, 'title')
    : [
        'Comprehensive VAPT Assessment',
        'Web Application Security Testing',
        'Mobile Application Security (iOS & Android)',
        'REST & GraphQL API Security Testing',
        'Network & Wireless Penetration Testing',
        'Cloud Security Posture & CASA Assessment',
        'Virtual CISO (vCISO) Advisory',
        'Secure Source Code Review (SAST/DAST)',
        'Zero-Trust Architecture & Threat Hardening',
        'AI Security & LLM Red Teaming'
    ];

include_once __DIR__ . '/includes/header.php';
?>

    <main class="df-page">

        <!-- ================= HERO ================= -->

        <section class="hero" id="home">

            <div class="hero-bg"></div>

            <div class="container hero-content">

                <div class="hero-left">

                    <div class="hero-tags-wrapper">
                        <span class="hero-tag-pill">CYBER DEFENSE</span>
                        <span class="hero-tag-pill">ZERO-TRUST SECURITY</span>
                        <span class="hero-tag-pill">OFFENSIVE RESEARCH</span>
                    </div>

                    <h1>
                        Advanced Cyber Security<br>
                        <span class="hero-gradient-text">Solutions</span><br>
                        <span class="hero-by-line"><span class="cyber-glitch-wrapper" title="Explore Cyber Security Services (Click to cycle)" data-phrases='["Application Security", "Network Security", "Cloud Security", "Enterprise Security"]'><span class="cyber-glitch-text" data-text="Application Security">Application Security</span><span class="cyber-cursor" aria-hidden="true">_</span><span class="cyber-scan-bar" aria-hidden="true"></span></span></span>
                    </h1>

                    <p>
                        CyberKovai delivers proactive cybersecurity solutions, certified penetration testing, and enterprise defense for modern businesses. Our certified cyber security experts provide continuous vulnerability management, cloud hardening, application security, and 24/7 digital resilience.
                    </p>

                    <div class="hero-buttons">

                        <a href="#contact" class="btn primary-btn">
                            Schedule Security Audit
                            <span>➔</span>
                        </a>

                        <a href="#services" class="btn outline-btn">
                            Explore Security Practices
                            <span>➔</span>
                        </a>
                    </div>

                    <div class="hero-features-row">
                        <div><span>✓</span> Offensive VAPT &amp; Attack Simulations</div>
                        <div><span>✓</span> Zero-Trust Architecture Hardening</div>
                        <div><span>✓</span> OWASP, NIST &amp; ISO 27001 Aligned</div>
                    </div>

                </div>

                <!-- RIGHT SIDE: Attack Surface Honeycomb Visual -->
                <div class="ck-visual-wrapper">
                    <div class="cap">ATTACK SURFACE · LIVE <span>EXPOSURE <b id="exp">0.0%</b></span></div>

                    <div class="ck-visual" id="ck">
                        <canvas id="cv" aria-hidden="true"></canvas>
                        <div class="chip z0"><i></i><div>Application Security<small><b id="n0">128</b> patched</small></div></div>
                        <div class="chip z1"><i></i><div>Network Security<small><b id="n1">96</b> patched</small></div></div>
                        <div class="chip z2"><i></i><div>Cloud Security<small><b id="n2">74</b> patched</small></div></div>
                        <div class="chip z3"><i></i><div>Enterprise Security<small><b id="n3">51</b> patched</small></div></div>
                    </div>

                    <div class="leg"><span style="--k:#ff4d6d">Vulnerable</span><span style="--k:#5eead4">Patched</span><span style="--k:#a855f7">Secure</span></div>
                </div>

            </div>

        </section>


        


        <!-- ================= ABOUT SECTION ================= -->

        <section class="section about-section cyber-about-section" id="about">
            <!-- Ambient Glow Accents -->
            <div class="about-ambient-glow about-glow-left" aria-hidden="true"></div>
            <div class="about-ambient-glow about-glow-right" aria-hidden="true"></div>

            <div class="container about-grid">

                <div class="about-content">

                    <div class="cyber-badge-tag">
                        <span class="cyber-tag-pulse"></span>
                        <span class="cyber-tag-text">ABOUT CYBER KOVAI</span>
                        <span class="cyber-tag-code">[ SYSTEM // THREAT DEFENSE ACTIVE ]</span>
                    </div>

                    <h2 class="about-headline">
                        Defend Your Digital Infrastructure with
                        <span class="cyber-gradient-text">Elite Cyber Security Experts</span>
                    </h2>

                    <div class="about-lead-box">
                        <p class="about-lead-text">
                            At Cyber Kovai, we provide cutting-edge offensive security, continuous vulnerability assessment, and zero-trust engineering to help organizations safeguard digital assets and defend against complex cyber threats.
                        </p>
                        
                    </div>

                    <!-- Interactive Capability Cards -->
                    <div class="about-capabilities">
                        <div class="capability-card" tabindex="0">
                            <div class="capability-icon-wrap">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                    <path d="m9 12 2 2 4-4"/>
                                </svg>
                            </div>
                            <div class="capability-body">
                                <div class="capability-header">
                                    <h4>Certified Security Experts</h4>
                                    <span class="capability-tag">CISM &amp; CISA</span>
                                </div>
                                <p>Elite red-team specialists simulating real-world adversary tactics to uncover critical vulnerabilities before malicious actors exploit them.</p>
                            </div>
                            <div class="capability-check">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </div>

                        <div class="capability-card" tabindex="0">
                            <div class="capability-icon-wrap icon-cyan">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                    <circle cx="12" cy="16" r="1"/>
                                </svg>
                            </div>
                            <div class="capability-body">
                                <div class="capability-header">
                                    <h4>Continuous Vulnerability Management</h4>
                                    <span class="capability-tag tag-cyan">OWASP &amp; NIST</span>
                                </div>
                                <p>Systematic surface scanning, CVSS v3.1 threat prioritization, and technical remediation roadmaps to eliminate attack surfaces.</p>
                            </div>
                            <div class="capability-check">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </div>

                        <div class="capability-card" tabindex="0">
                            <div class="capability-icon-wrap icon-purple">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17.5 19H9a7 7 0 1 1 6.71-9h1.79a4.5 4.5 0 1 1 0 9Z"/>
                                    <path d="M12 12v4m-2-2h4"/>
                                </svg>
                            </div>
                            <div class="capability-body">
                                <div class="capability-header">
                                    <h4>Multi-Cloud &amp; Zero-Trust Hardening</h4>
                                    <span class="capability-tag tag-purple">AWS, GCP &amp; AZURE</span>
                                </div>
                                <p>Hardening cloud architectures, APIs, and enterprise perimeters against ransomware, lateral movement, and data breaches.</p>
                            </div>
                            <div class="capability-check">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Mini Stat Ticker Row -->
                    <div class="about-stat-strip">
                        <div class="stat-strip-item">
                            <span class="stat-strip-num">500+</span>
                            <span class="stat-strip-lbl">Security Audits Executed</span>
                        </div>
                        <div class="stat-strip-divider"></div>
                        <div class="stat-strip-item">
                            <span class="stat-strip-num">10,000+</span>
                            <span class="stat-strip-lbl">Vulnerabilities Remediated</span>
                        </div>
                        <div class="stat-strip-divider"></div>
                        <div class="stat-strip-item">
                            <span class="stat-strip-num">99.9%</span>
                            <span class="stat-strip-lbl">Threat Mitigation Rate</span>
                        </div>
                    </div>

                </div>

                <!-- Right Cyber Console Stage -->
                <div class="about-visual-column">
                    <div class="cyber-console-card">
                        
                        <!-- Console Header Bar -->
                        <div class="console-top-bar">
                            <div class="console-dots">
                                <span class="dot dot-red"></span>
                                <span class="dot dot-yellow"></span>
                                <span class="dot dot-green"></span>
                            </div>
               
                        </div>

                        <!-- Media Display Window -->
                        <div class="console-media-window">
                            <!-- HUD Crosshair Corners -->
                            <div class="hud-corner hud-tl" aria-hidden="true"></div>
                            <div class="hud-corner hud-tr" aria-hidden="true"></div>
                            <div class="hud-corner hud-bl" aria-hidden="true"></div>
                            <div class="hud-corner hud-br" aria-hidden="true"></div>

                            <!-- Animated Scanning Laser -->
                            <div class="cyber-scan-laser" aria-hidden="true"></div>

                            <!-- Grid Reticle Overlay -->
                            <div class="cyber-grid-mesh" aria-hidden="true"></div>

                            <img src="assets/images/soc_command_center.jpg" alt="Cyber Kovai SOC Command Operations Center" class="about-hero-img" loading="lazy">

                            <!-- Floating Experience Pill: Top Left -->
                            <div class="hologram-pill holo-top-left">
                                <span class="pill-glow-dot"></span>
                                <span><strong>10+ Years</strong> Cyber Defense Mastery</span>
                            </div>

                            <!-- Floating Holographic Badge 1: Top Right -->
                            <div class="hologram-badge holo-top-right">
                                <div class="holo-badge-icon holo-icon-purple">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                        <path d="m9 12 2 2 4-4"/>
                                    </svg>
                                </div>
                                <div class="holo-badge-content">
                                    <span class="holo-badge-label">Verified Security Posture</span>
                                    <div class="holo-badge-value">
                                        <strong>500+</strong> <span>Systems Secured</span>
                                    </div>
                                </div>
                                <div class="holo-sparkle" aria-hidden="true">✦</div>
                            </div>

                            <!-- Floating Holographic Badge 2: Bottom Left -->
                            <div class="hologram-badge holo-bottom-left">
                                <div class="holo-badge-icon holo-icon-emerald">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <circle cx="12" cy="12" r="6"/>
                                        <circle cx="12" cy="12" r="2"/>
                                    </svg>
                                </div>
                                <div class="holo-badge-content">
                                    <span class="holo-badge-label">Defense Efficacy</span>
                                    <div class="holo-badge-value">
                                        <strong class="text-emerald">99.9%</strong> <span>Threat Mitigation</span>
                                    </div>
                                </div>
                                <div class="holo-sparkle holo-sparkle-emerald" aria-hidden="true">✦</div>
                            </div>

                            <!-- Holographic Telemetry Strip at Bottom of Image -->
                            <div class="console-telemetry-bar">
                                <span class="telemetry-item">SOC RADAR: ACTIVE</span>
                                <span class="telemetry-item">STATUS: PERIMETER SECURED</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </section>





        <!-- ================= CYBER CAPABILITIES (3 CORE PILLARS) ================= -->

        <section class="section cyber-capabilities-section" id="capabilities">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        CYBER DEFENSE
                    </span>

                    <h2>
                        Core Cyber <span>Security Capabilities</span>
                    </h2>

                    <p>
                        Offensive attack simulations, continuous vulnerability auditing, and zero-trust architecture hardening designed to neutralize complex adversarial threats.
                    </p>

                </div>

                <div class="cyber-capabilities-grid">

                    <!-- CARD 1: Real-World Attack Simulation -->
                    <div class="cyber-cap-card cap-card-attack">
                        <div class="cap-card-icon-wrap">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M10 16V10H16" stroke="#f43f5e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M38 16V10H32" stroke="#f43f5e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M10 32V38H16" stroke="#f43f5e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M38 32V38H32" stroke="#f43f5e" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="24" cy="24" r="14" stroke="#f43f5e" stroke-width="2" stroke-dasharray="3 3"/>
                                <path d="M24 16L31 19.5V25C31 29.5 28 33 24 34.5C20 33 17 29.5 17 25V19.5L24 16Z" fill="#3b82f6" fill-opacity="0.18" stroke="#2563eb" stroke-width="2.2" stroke-linejoin="round"/>
                                <circle cx="24" cy="24" r="2" fill="#2563eb"/>
                                <path d="M24 26V28.5" stroke="#2563eb" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <h3 class="cap-card-title">Real-World Attack Simulation</h3>
                        <ul class="cap-card-list list-blue">
                            <li><span class="cap-check">✓</span> Offensive red-team tactics simulating real-world adversary behavior.</li>
                            <li><span class="cap-check">✓</span> Led by certified security experts holding CISM &amp; CISA credentials.</li>
                            <li><span class="cap-check">✓</span> Deep exploit validation uncovering critical vulnerabilities before breach.</li>
                            <li><span class="cap-check">✓</span> Post-assessment remediation re-testing and verified certification.</li>
                        </ul>
                    </div>

                    <!-- CARD 2: Continuous Vulnerability Management -->
                    <div class="cyber-cap-card cap-card-vuln">
                        <div class="cap-card-icon-wrap">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <rect x="8" y="9" width="32" height="23" rx="3" stroke="#2563eb" stroke-width="2.2" fill="#2563eb" fill-opacity="0.1"/>
                                <path d="M20 32V37H28V32" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                <line x1="15" y1="37" x2="33" y2="37" stroke="#2563eb" stroke-width="2.2" stroke-linecap="round"/>
                                <circle cx="24" cy="20.5" r="7" stroke="#38bdf8" stroke-width="1.8"/>
                                <circle cx="24" cy="20.5" r="3" stroke="#38bdf8" stroke-width="1.5"/>
                                <line x1="24" y1="13.5" x2="24" y2="27.5" stroke="#38bdf8" stroke-width="1.5"/>
                                <line x1="17" y1="20.5" x2="31" y2="20.5" stroke="#38bdf8" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <h3 class="cap-card-title">Continuous Vulnerability Management</h3>
                        <ul class="cap-card-list list-amber">
                            <li><span class="cap-check">✓</span> Systematic surface scanning across networks, web apps &amp; APIs.</li>
                            <li><span class="cap-check">✓</span> Comprehensive auditing mapped to OWASP Top 10 &amp; NIST frameworks.</li>
                            <li><span class="cap-check">✓</span> CVSS v3.1 dynamic scoring with severity-based risk prioritization.</li>
                            <li><span class="cap-check">✓</span> Actionable remediation roadmaps to eliminate attack surfaces.</li>
                        </ul>
                    </div>

                    <!-- CARD 3: Multi-Cloud & Zero-Trust Hardening -->
                    <div class="cyber-cap-card cap-card-arch">
                        <div class="cap-card-icon-wrap">
                            <svg width="48" height="48" viewBox="0 0 48 48" fill="none">
                                <path d="M34 23C34 19.13 30.87 16 27 16C26.36 16 25.75 16.09 25.17 16.25C23.94 13.73 21.17 12 18 12C13.58 12 10 15.58 10 20C10 20.35 10.02 20.69 10.07 21.03C7.72 21.94 6 24.27 6 27C6 30.87 9.13 34 13 34H33C36.87 34 40 30.87 40 27C40 24.82 39 22.88 37.44 21.61C37.47 21.41 37.5 21.2 37.5 21" stroke="#3b82f6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="#3b82f6" fill-opacity="0.1"/>
                                <path d="M24 19L29 21.5V25.5C29 28.5 27 31 24 32C21 31 19 28.5 19 25.5V21.5L24 19Z" fill="#10b981" fill-opacity="0.22" stroke="#10b981" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M22 25.5L23.5 27L26.5 24" stroke="#10b981" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="16" cy="40" r="2.2" stroke="#10b981" stroke-width="1.8"/>
                                <circle cx="24" cy="40" r="2.2" stroke="#10b981" stroke-width="1.8"/>
                                <circle cx="32" cy="40" r="2.2" stroke="#10b981" stroke-width="1.8"/>
                                <line x1="16" y1="34" x2="16" y2="37.8" stroke="#10b981" stroke-width="1.5"/>
                                <line x1="24" y1="34" x2="24" y2="37.8" stroke="#10b981" stroke-width="1.5"/>
                                <line x1="32" y1="34" x2="32" y2="37.8" stroke="#10b981" stroke-width="1.5"/>
                            </svg>
                        </div>
                        <h3 class="cap-card-title">Multi-Cloud &amp; Zero-Trust Hardening</h3>
                        <ul class="cap-card-list list-green">
                            <li><span class="cap-check">✓</span> Architecture hardening across AWS, Google Cloud (GCP) &amp; Azure.</li>
                            <li><span class="cap-check">✓</span> Zero-Trust perimeter design enforcing strict least-privilege access.</li>
                            <li><span class="cap-check">✓</span> Fortifying cloud APIs and endpoints against ransomware &amp; breaches.</li>
                            <li><span class="cap-check">✓</span> Network micro-segmentation to halt adversary lateral movement.</li>
                        </ul>
                    </div>

                </div>

            </div>

        </section>

        <section class="stats-section cyber-stats-section">

            <div class="container">

                <div class="stats-counter-grid cyber-hud-stats">
                    <?php foreach ($cyberStats as $stat): ?>
                        <div class="stat-counter-card cyber-hud-stat-card">
                            <div class="stat-card-beam" aria-hidden="true"></div>
                            <div class="stat-hud-chip">VERIFIED METRIC</div>
                            <strong class="stat-counter-val" data-counter="true" data-final="<?= sanitize_out($stat['value']) ?>"><?= sanitize_out($stat['value']) ?></strong>
                            <span class="stat-counter-lbl"><?= sanitize_out($stat['label']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>


        <!-- ================= PRACTICES / SERVICES ================= -->

        <section class="section services-section cyber-practices-section" id="services">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        <?= sanitize_out($cyberPracticesSettings['tag'] ?? 'OUR PRACTICES') ?>
                    </span>

                    <h2>
                        <?= !empty($cyberPracticesSettings['title']) ? $cyberPracticesSettings['title'] : 'Core Cyber Practices. One Standard: <span>Uncompromising Defense.</span>' ?>
                    </h2>

                    <p>
                        <?= sanitize_out($cyberPracticesSettings['subtitle'] ?? 'Comprehensive offensive and defensive cybersecurity practices engineered for modern digital enterprises.') ?>
                    </p>

                </div>


                <div class="practices-bento-grid">

                    <?php foreach ($cyberPractices as $index => $service): 
                        $isHero = !empty($service['is_hero']) || in_array($index, [0, 3, 7], true);
                        $practiceSlug = $service['slug'] ?? '';
                        $customLink = trim($service['link'] ?? '');
                        
                        if (!empty($customLink) && (strpos($customLink, 'http://') === 0 || strpos($customLink, 'https://') === 0)) {
                            $practiceUrl = $customLink;
                        } elseif (!empty($customLink) && $customLink !== '#' && $customLink !== 'services/' . $practiceSlug . '.php') {
                            $practiceUrl = function_exists('ck_base_url') ? ck_base_url($customLink) : $basePrefix . $customLink;
                        } elseif ($practiceSlug !== '') {
                            $targetServiceFile = __DIR__ . '/services/' . $practiceSlug . '.php';
                            if (file_exists($targetServiceFile)) {
                                $practiceUrl = function_exists('ck_base_url') ? ck_base_url('services/' . $practiceSlug . '.php') : $basePrefix . 'services/' . $practiceSlug . '.php';
                            } else {
                                $practiceUrl = function_exists('ck_base_url') ? ck_base_url('service.php?slug=' . urlencode($practiceSlug)) : $basePrefix . 'service.php?slug=' . urlencode($practiceSlug);
                            }
                        } else {
                            $practiceUrl = '#';
                        }

                        $bentoClassNum = ($index % 8) + 1;
                        $badgeText = !empty($service['badge']) ? $service['badge'] : ($isHero ? (($index === 7 || $bentoClassNum === 8) ? 'AI DEFENSE PRACTICE' : 'PRIMARY PRACTICE') : '');
                        $statusText = !empty($service['status_text']) ? $service['status_text'] : 'ARMORED';
                    ?>
                        <article class="practice-bento-card <?= $isHero ? 'bento-hero-card' : '' ?> bento-item-<?= $bentoClassNum ?>">
                            <div class="bento-card-header">
                                <div class="bento-icon-wrapper">
                                    <?= get_forensic_icon($service['title'] ?? '', 'bento-svg-icon', 24) ?>
                                </div>
                                <div class="bento-dossier-tag">
                                    <span class="dossier-code"><?= sanitize_out($service['tag'] ?? '') ?></span>
                                    <?php if (!empty($badgeText)): ?>
                                        <span class="dossier-badge"><?= sanitize_out($badgeText) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="bento-card-content">
                                <h3><a href="<?= sanitize_out($practiceUrl) ?>" style="color: inherit; text-decoration: none;"><?= sanitize_out($service['title'] ?? '') ?></a></h3>
                                <p><?= sanitize_out($service['description'] ?? '') ?></p>
                            </div>

                            <div class="bento-card-footer">
                                <a href="<?= sanitize_out($practiceUrl) ?>" class="practice-cyber-link">
                                    <span>Explore Security Practice</span>
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                                <div class="bento-status-indicator">
                                    <span class="status-pulse-dot"></span>
                                    <span class="status-text"><?= sanitize_out($statusText) ?></span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= PROCESS (STRUCTURED LIFECYCLE) ================= -->

        <section class="section process-section cyber-process-section" id="process">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        OUR METHODOLOGY
                    </span>

                    <h2>
                        A Structured <span>Cyber Defense Lifecycle</span>
                    </h2>

                    <p>
                        A systematic 5-stage methodology to detect, neutralize, and safeguard your infrastructure against sophisticated adversaries.
                    </p>

                </div>

                <div class="cyber-pipeline-wrapper">
                    <div class="pipeline-conduit-line" aria-hidden="true">
                        <div class="pipeline-glow-pulse"></div>
                    </div>

                    <div class="cyber-pipeline-track">
                        <?php foreach ($cyberProcessSteps as $i => $step): ?>
                            <div class="pipeline-stage-card" tabindex="0">
                                
                                <div class="stage-node-wrapper">
                                    <div class="stage-node-circle">
                                        <span class="stage-node-pulse"></span>
                                        <span class="stage-node-num"><?= sanitize_out($step['num']) ?></span>
                                    </div>
                                    <div class="stage-phase-label">PHASE <?= sanitize_out($step['num']) ?></div>
                                </div>

                                <div class="stage-card-body">
                                    <div class="stage-icon-capsule">
                                        <?= get_forensic_icon($step['title'], 'stage-svg-icon', 22) ?>
                                    </div>
                                    <h3><?= sanitize_out($step['title']) ?></h3>
                                    <p><?= sanitize_out($step['desc']) ?></p>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </div>

        </section>


        <!-- ================= INDUSTRIES (CYBER INTELLIGENCE FOR EVERY INDUSTRY) ================= -->

        <section class="section industries-section cyber-industries-section" id="industries">

            <div class="container industries-container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        INDUSTRIES
                    </span>

                    <h2>
                        Cyber Intelligence for <span>Every Industry</span>
                    </h2>

                    <p>
                        Tailored intelligence to address industry-specific risks and challenges.
                    </p>

                </div>

                <div class="industries-cyber-grid">

                    <!-- Col 1: Banking & Financial Services -->
                    <div class="industry-cyber-col" tabindex="0">
                        <div class="industry-cyber-icon-orb">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h18M3 10h18M12 3l9 7H3l9-7z"/>
                                <path d="M5 10v11M9 10v11M15 10v11M19 10v11"/>
                            </svg>
                        </div>
                        <h3>Banking &amp; Financial Services</h3>
                        <p>Fraud prevention, threat monitoring and risk visibility.</p>
                    </div>

                    <!-- Col 2: Healthcare & Life Sciences -->
                    <div class="industry-cyber-col" tabindex="0">
                        <div class="industry-cyber-icon-orb">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21h18"/>
                                <path d="M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16"/>
                                <path d="M12 7v6M9 10h6"/>
                                <path d="M10 17h4"/>
                            </svg>
                        </div>
                        <h3>Healthcare &amp; Life Sciences</h3>
                        <p>Protect sensitive data and ensure operational resilience.</p>
                    </div>

                    <!-- Col 3: Technology & SaaS -->
                    <div class="industry-cyber-col" tabindex="0">
                        <div class="industry-cyber-icon-orb">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                                <rect x="9" y="8" width="6" height="6" rx="1"/>
                                <path d="M9 11H7M17 11h-2M12 8V6M12 16v-2"/>
                            </svg>
                        </div>
                        <h3>Technology &amp; SaaS</h3>
                        <p>Monitor threats targeting digital platforms and intellectual property.</p>
                    </div>

                    <!-- Col 4: Manufacturing & Industrial -->
                    <div class="industry-cyber-col" tabindex="0">
                        <div class="industry-cyber-icon-orb">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M2 20h20"/>
                                <path d="M4 20V9l6 4V9l6 4V4h4v16"/>
                                <rect x="7" y="16" width="2" height="4"/>
                                <rect x="13" y="16" width="2" height="4"/>
                            </svg>
                        </div>
                        <h3>Manufacturing &amp; Industrial</h3>
                        <p>Identify risks to OT/IT environments and supply chains.</p>
                    </div>

                    <!-- Col 5: Government & Public Sector -->
                    <div class="industry-cyber-col" tabindex="0">
                        <div class="industry-cyber-icon-orb">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 2L2 7h20L12 2z"/>
                                <path d="M4 10v9M8 10v9M12 10v9M16 10v9M20 10v9"/>
                                <path d="M2 19h20M1 22h22"/>
                            </svg>
                        </div>
                        <h3>Government &amp; Public Sector</h3>
                        <p>Enhance threat visibility and protect critical infrastructure.</p>
                    </div>

                    <!-- Col 6: Retail & E-commerce -->
                    <div class="industry-cyber-col" tabindex="0">
                        <div class="industry-cyber-icon-orb">
                            <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="9" cy="21" r="1.5"/>
                                <circle cx="19" cy="21" r="1.5"/>
                                <path d="M2.5 2.5h3l2.4 12.3a2 2 0 0 0 2 1.6h9.6a2 2 0 0 0 2-1.6l1.5-8.3H6.2"/>
                            </svg>
                        </div>
                        <h3>Retail &amp; E-commerce</h3>
                        <p>Detect fraud, account takeovers and emerging cyber threats.</p>
                    </div>

                </div>

            </div>

        </section>


        <!-- ================= CLIENT SCALES ================= -->

        <section class="section clients-section cyber-clients-section">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        WHO WE SECURE
                    </span>

                    <h2>
                        From Startups to <span>Multinationals</span>
                    </h2>

                    <p>
                        Organizations across every tier trust Cyber Kovai for offensive security testing, multi-cloud hardening, and proactive cyber defense.
                    </p>

                </div>


                <div class="client-tiers-deck">

                    <?php 
                    $tierNames = ['EMERGING VENTURES', 'REGIONAL MID-MARKET', 'HIGH-CAPACITY ENTERPRISE', 'INSTITUTIONAL BODIES', 'GLOBAL CONGLOMERATE'];
                    foreach ($cyberClientTypes as $i => $client): 
                        $tierNum = $i + 1;
                        $tierLabel = $tierNames[$i] ?? 'TIER ' . $tierNum;
                    ?>
                        <div class="client-tier-card" tabindex="0">
                            <div class="tier-top-strip">
                                <span class="tier-chip">TIER 0<?= $tierNum ?></span>
                                <span class="tier-label"><?= $tierLabel ?></span>
                            </div>

                            <div class="tier-icon-orb">
                                <?= get_forensic_icon($client['title'], 'tier-svg-icon', 26) ?>
                            </div>

                            <h3><?= sanitize_out($client['title']) ?></h3>
                            <p><?= sanitize_out($client['desc']) ?></p>

                            <div class="tier-capacity-bar" title="Scale Deployment Tier <?= $tierNum ?> of 5">
                                <div class="tier-fill-track" style="width: <?= $tierNum * 20 ?>%;"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- Featured Client Partnerships Showcase (Cyber Security Track) -->
                <?php 
                $cyberClients = function_exists('ck_get_clients') ? ck_get_clients('cyber', false) : ($clientLogos ?? []);
                if (!empty($cyberClients)): 
                ?>
                <div class="cyber-clients-showcase">
                    <div class="cyber-clients-showcase-label">
                        <span class="pulse-dot"></span>
                        <span>FEATURED CLIENT ENGAGEMENTS</span>
                    </div>
                    <div class="cyber-clients-logos-deck">
                        <?php foreach ($cyberClients as $client): ?>
                        <div class="cyber-client-card">
                            <div class="cyber-client-logo-box">
                                <img src="<?= sanitize_out($client['img']) ?>" alt="<?= sanitize_out($client['alt'] ?? ($client['name'] . ' - ' . ($client['category'] ?? ''))) ?>" class="cyber-client-logo-img" loading="lazy">
                            </div>
                            <div class="cyber-client-meta">
                                <div class="cyber-client-header">
                                    <h4><?= sanitize_out($client['name']) ?></h4>
                                </div>
                                <span class="cyber-client-cat"><?= sanitize_out($client['category']) ?></span>
                                <?php if (!empty($client['desc'])): ?>
                                    <p class="cyber-client-desc"><?= sanitize_out($client['desc']) ?></p>
                                <?php endif; ?>
                                <div class="cyber-client-footer">
                                    <span class="pulse-dot"></span>
                                    <span>ARMORED PARTNERSHIP</span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>

        </section>


        <!-- ================= REACH / COVERAGE ================= -->

        <section class="section coverage-section" id="coverage">

            <div class="container">

                <div class="coverage-grid">

                    <!-- Left Side: Interactive 3D Globe -->
                    <div class="coverage-globe-col">
                        <div id="globe-wrap" class="globe-box">
                            <canvas id="c"></canvas>
                            <div id="hint">
                                Drag to rotate &bull; auto-rotates when idle
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Worldwide Service Content -->
                    <div class="coverage-content-col">

                        <span class="section-tag">
                            GLOBAL REACH
                        </span>

                        <h2>
                            From Coimbatore <span>to the World</span>
                        </h2>

                        <p class="coverage-subtitle">
                            Delivering offensive security testing, cloud defense, and cyber resilience across India and globally.
                        </p>

                        <div class="coverage-features">

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Global Remote &amp; On-Premises Security Audits</h4>
                                    <p>Seamless security testing and penetration assessments across Asia-Pacific, Middle East, Europe, and North America.</p>
                                </div>
                            </div>

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Certified Security Researchers &amp; Penetration Testers</h4>
                                    <p>Direct access to CISA, CISM, OSCP, CEH, and CISSP certified ethical hackers with proven track records.</p>
                                </div>
                            </div>

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Strict International Security Compliance</h4>
                                    <p>All assessments are conducted strictly adhering to OWASP Top 10, NIST CSF, ISO 27001, and regional data protection mandates.</p>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= ACCREDITATIONS & CREDENTIALS ================= -->

        <?php if (!empty($accreds)): ?>
        <section class="section credentials-section" id="credentials">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        OUR CREDENTIALS
                    </span>

                    <h2>
                        Memberships, Associations &amp; <span>Certifications</span>
                    </h2>

                    <p>
                        We are associated with reputable organizations and certified bodies to ensure the highest standards of professionalism and ethics.
                    </p>

                </div>

                <!-- Badges Display -->
                <div class="credentials-grid">
                    <?php foreach ($accreds as $badge): ?>
                        <div class="credentials-card">
                            <?php if (!empty($badge['website'])): ?>
                                <a href="<?= sanitize_out($badge['website']) ?>" target="_blank" rel="noopener" class="badge-card" title="<?= sanitize_out($badge['name'] ?? $badge['alt'] ?? '') ?>">
                                    <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                                </a>
                            <?php else: ?>
                                <div class="badge-card" title="<?= sanitize_out($badge['name'] ?? $badge['alt'] ?? '') ?>">
                                    <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>
        <?php endif; ?>


        <!-- ================= BUSINESS RISK SIMULATOR (TOOL) ================= -->

        <section class="section tools-section cyber-tools-section" id="company">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        DIAGNOSTICS
                    </span>

                    <h2>
                        Cyber Attack Surface <span>Simulator</span>
                    </h2>

                    <p>
                        Identify potential security exposures and evaluate your defense readiness across critical attack vectors.
                    </p>

                </div>


                <div class="simulator-matrix-deck">

                    <?php 
                    $vectors = ['WEB & API', 'NETWORK', 'CLOUD INFRA', 'RANSOMWARE', 'CODE AUDIT', 'IDENTITY', 'SUPPLY CHAIN', 'COMPLIANCE'];
                    foreach ($cyberRiskTools as $i => $tool): 
                        $vectorTag = $vectors[$i] ?? 'THREAT VECTOR';
                    ?>
                        <div class="simulator-probe-card" tabindex="0">
                            <!-- Scanning Probe Laser on hover -->
                            <div class="probe-sweep-laser" aria-hidden="true"></div>

                            <div class="probe-card-header">
                                <div class="probe-terminal-meta">
                                    <span class="probe-live-dot"></span>
                                    <span class="probe-meta-text">PROBE 0<?= $i + 1 ?> // ACTIVE</span>
                                </div>
                                <span class="probe-vector-chip"><?= $vectorTag ?></span>
                            </div>

                            <div class="probe-icon-wrap">
                                <?= get_forensic_icon($tool['title'], 'probe-svg-icon', 24) ?>
                            </div>

                            <h3><?= sanitize_out($tool['title']) ?></h3>
                            <p><?= sanitize_out($tool['desc']) ?></p>

                            <div class="probe-card-footer">
                                <span class="probe-action-text">Run Diagnostic</span>
                                <span class="probe-reticle-arrow">➔</span>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= FAQ SECTION ================= -->

        <section class="section faq-section cyber-faq-section" id="faq">

            <div class="container" style="max-width: 860px;">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        FAQ
                    </span>

                    <h2>
                        Frequently Asked <span>Questions</span>
                    </h2>

                </div>


                <div class="faq-accordion-list">

                    <?php foreach ($cyberFaqs as $faq): ?>
                        <div class="faq-item">

                            <button class="faq-question">
                                <?= sanitize_out($faq['question']) ?>
                                <span class="arrow-icon">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="6 9 12 15 18 9"></polyline>
                                    </svg>
                                </span>
                            </button>

                            <div class="faq-answer">
                                <p><?= sanitize_out($faq['answer']) ?></p>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="text-center" style="margin-top: 2rem;">
                    <a href="#contact" class="btn outline-btn">View All FAQs <span>→</span></a>
                </div>

            </div>

        </section>


        <!-- ================= CTA BANNER & CONTACT FORM ================= -->

        <section class="contact-section" id="contact">

            <div class="container">

                <div class="cta-banner-box">

                    <span class="section-tag">
                        GET STARTED
                    </span>

                    <h2>
                        Ready to Strengthen Your <span>Cyber Defenses?</span>
                    </h2>

                    <p>
                        Partner with Cyber Kovai for certified penetration testing, cloud security hardening, and enterprise cyber resilience.
                    </p>

                    <div class="contact-buttons">

                        <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn primary-btn">
                            Schedule Security Consultation ➔
                        </a>

                        <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" class="btn outline-btn">
                            Email Security Team
                        </a>

                    </div>

                    <!-- Interactive PHP Contact Form -->
                    <div class="contact-form-wrapper" style="margin-top: 3rem; width: 100%; text-align: left;">
                        <form id="contactForm" action="process-contact.php" method="POST">
                            <div id="formResponse" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;"></div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                                <div>
                                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Your Name / Pseudonym *</label>
                                    <input type="text" id="name" name="name" required placeholder="John Doe" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                                <div>
                                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Secure Email Address *</label>
                                    <input type="email" id="email" name="email" required placeholder="john@company.com" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem; align-items: start;">
                                <div>
                                    <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone / WhatsApp / Signal *</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="<?= sanitize_out(SITE_PHONE) ?>" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                                <div>
                                    <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Service Required *</label>
                                    <select id="service" name="service" required style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                        <option value="">Select a Cybersecurity Practice</option>
                                        <?php foreach ($cyberFormServices as $formService): ?>
                                            <option value="<?= sanitize_out($formService) ?>"><?= sanitize_out($formService) ?></option>
                                        <?php endforeach; ?>
                                        <option value="Other">Other (Please specify)</option>
                                    </select>
                                    <div class="service-other-wrap" style="display: none; margin-top: 0.75rem;">
                                        <label for="service_other" style="display: block; margin-bottom: 0.35rem; font-size: 0.82rem; opacity: 0.9; color: var(--purple-light);">Specify Your Requirement *</label>
                                        <input type="text" id="service_other" name="service_other" placeholder="Type your custom service or practice requirement..." style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                    </div>
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label for="message" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Details / Message *</label>
                                <textarea id="message" name="message" rows="4" required placeholder="Describe your web/mobile/cloud environment, compliance deadline, or specific testing requirements..." style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; resize: vertical;"></textarea>
                            </div>

                            <?php if (defined('ENABLE_RECAPTCHA') && ENABLE_RECAPTCHA): ?>
                            <!-- Google reCAPTCHA -->
                            <div class="recaptcha-wrapper" style="margin-bottom: 1.5rem;">
                                <div class="g-recaptcha" data-sitekey="<?= sanitize_out(RECAPTCHA_SITE_KEY) ?>" data-theme="dark"></div>
                            </div>
                            <?php endif; ?>

                            <button type="submit" class="btn primary-btn" style="cursor: pointer; border: none; width: 100%; justify-content: center; font-size: 1.05rem;">
                                Request Security Assessment ➔
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </section>

    </main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
