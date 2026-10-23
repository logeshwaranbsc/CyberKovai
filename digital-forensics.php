<?php
/**
 * Cyber Kovai — Digital Investigation & Forensics Home Page
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/forensic-icons.php';

$pageTitle       = 'Digital Investigation & Forensics | Cyber Kovai';
$pageDescription = 'Professional investigation solutions and digital forensics by CyberKovai. Confidential corporate intelligence, evidence collection, and cybercrime defense.';

include_once __DIR__ . '/includes/header.php';
?>

    <main class="df-page">

        <!-- ================= HERO ================= -->

        <section class="hero" id="home">

            <div class="hero-bg"></div>

            <div class="container hero-content">

                <div class="hero-left">

                    <div class="hero-tags-wrapper">
                        <span class="hero-tag-pill">BUSINESS INTELLIGENCE</span>
                        <span class="hero-tag-pill">RISK REDUCTION</span>
                        <span class="hero-tag-pill">ADAPTIVE INSIGHTS</span>
                    </div>

                    <h1>
                        Professional Investigation<br>
                        <span class="hero-gradient-text">Solutions</span><br>
                        <span class="hero-by-line">by <span class="cyber-glitch-wrapper" title="CyberKovai Cyber Systems"><span class="cyber-glitch-text" data-text="CyberKovai">CyberKovai</span><span class="cyber-cursor" aria-hidden="true">_</span><span class="cyber-scan-bar" aria-hidden="true"></span></span></span>
                    </h1>

                    <p>
                        CyberKovai delivers confidential and result-oriented investigation services for individuals, families, and businesses. Our experienced investigators provide accurate reports, discreet operations, and trusted support across matrimonial, employment, fraud, and cyber investigations.
                    </p>

                    <div class="hero-buttons">

                        <a href="#contact" class="btn primary-btn">
                            Get a Consultation
                            <span>➔</span>
                        </a>

                        <a href="cyber-intelligence.php?section=forensics" class="btn outline-btn">
                            Explore Investigation Services
                            <span>➔</span>
                        </a>
                    </div>

                    <div class="hero-features-row">
                        <div><span>✓</span> Due Diligence</div>
                        <div><span>✓</span> Actionable</div>
                        <div><span>✓</span> Actionable Insights</div>
                    </div>

                </div>

                <!-- RIGHT SIDE: Hologram Shield Stage + Orbiting Services -->
                <div class="hero-visual inv-hero-visual">

                    <canvas id="fx" aria-hidden="true"></canvas>

                    <!-- Arc label text around the ring -->
                    <div class="ci-arc-labels" aria-hidden="true">
                        <div class="ci-arc-label ci-arc-top">APPLICATION SECURITY</div>
                        <div class="ci-arc-label ci-arc-right">NETWORK SECURITY</div>
                        <div class="ci-arc-label ci-arc-bottom">ENTERPRISE SECURITY</div>
                        <div class="ci-arc-label ci-arc-left">CLOUD SECURITY</div>
                    </div>

                    <!-- Floating service cards (4 corners) -->
                    <div class="ci-float-card inv-fc-1">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                        <span>Application Security</span>
                    </div>
                    <div class="ci-float-card inv-fc-2">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="8" rx="2"/><rect x="2" y="14" width="20" height="8" rx="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
                        <span>Network Security</span>
                    </div>
                    <div class="ci-float-card inv-fc-3">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        <span>Enterprise Security</span>
                    </div>
                    <div class="ci-float-card inv-fc-4">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>
                        <span>Cloud Security</span>
                    </div>

                    <div class="stage" id="stage">
                        <!-- Background HUD rings -->
                        <svg class="hud" viewBox="0 0 800 800" fill="none" aria-hidden="true">
                            <g class="c">
                                <circle cx="400" cy="400" r="388" stroke="#e9dcff" stroke-opacity=".28" stroke-width="8" stroke-dasharray="1 14" />
                            </g>
                            <g class="a">
                                <circle cx="400" cy="400" r="370" stroke="#c84bff" stroke-opacity=".25" />
                                <circle cx="400" cy="400" r="340" stroke="#e9dcff" stroke-opacity=".4" stroke-dasharray="2 10" />
                                <circle cx="400" cy="400" r="355" pathLength="100" stroke="#c84bff" stroke-width="3" stroke-linecap="round" stroke-dasharray="16 84" />
                                <circle cx="400" cy="400" r="355" pathLength="100" stroke="#7b2ff7" stroke-width="3" stroke-linecap="round" stroke-dasharray="9 91" stroke-dashoffset="-50" />
                            </g>
                            <g class="b">
                                <circle cx="400" cy="400" r="320" stroke="#c84bff" stroke-opacity=".2" />
                                <g class="node">
                                    <circle cx="677" cy="560" r="14" fill="var(--node-fill)" stroke="#c84bff" stroke-width="2" />
                                    <circle cx="677" cy="560" r="4" fill="#c84bff" />
                                </g>
                                <g class="node">
                                    <circle cx="123" cy="560" r="14" fill="var(--node-fill)" stroke="#c84bff" stroke-width="2" />
                                    <circle cx="123" cy="560" r="4" fill="#c84bff" />
                                </g>
                                <g class="node">
                                    <circle cx="400" cy="80" r="14" fill="var(--node-fill)" stroke="#c84bff" stroke-width="2" />
                                    <circle cx="400" cy="80" r="4" fill="#c84bff" />
                                </g>
                            </g>
                        </svg>

                        <!-- Glowing platform -->
                        <div class="platform" aria-hidden="true">
                            <i class="ring pulse"></i><i class="ring pulse p2"></i><i class="ring pulse p3"></i>
                            <i class="ring r1"></i><i class="ring r2"></i><i class="ring r3"></i><i class="ring r4"></i><i class="ring disc"></i>
                        </div>

                        <div class="beam" aria-hidden="true"></div>

                        <!-- Shield -->
                        <div class="shield-pos">
                            <div class="shield">
                                <img src="assets/images/logo.png" alt="Cyber Kovai Shield Logo" class="shield-logo-img">
                            </div>
                        </div>
                    </div>

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
                        <span class="cyber-tag-code">[ SYSTEM // VERIFIED ]</span>
                    </div>

                    <h2 class="about-headline">
                        Make Confident Decisions with Trusted
                        <span class="cyber-gradient-text">Business Intelligence</span>
                    </h2>

                    <div class="about-lead-box">
                        <p class="about-lead-text">
                            At Cyber Kovai, we provide reliable and discreet investigation and verification services to help individuals, businesses, and organizations make informed, confident decisions.
                        </p>
                        <p class="about-sub-text">
                            Combining <strong>20+ years of investigative mastery</strong> with modern cyber-analytics to deliver swift, court-admissible, and actionable intelligence.
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
                                    <h4>Experienced Investigators</h4>
                                    <span class="capability-tag">20+ YRS EXP</span>
                                </div>
                                <p>Licensed forensic specialists executing rigorous field and cyber analytics with verified precision.</p>
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
                                    <h4>Discreet & Confidential Process</h4>
                                    <span class="capability-tag tag-cyan">100% NDA</span>
                                </div>
                                <p>Zero-digital footprint operations with ironclad chain of custody and attorney-client discretion.</p>
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
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="2" y1="12" x2="22" y2="12"/>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
                                </svg>
                            </div>
                            <div class="capability-body">
                                <div class="capability-header">
                                    <h4>Tailored Solutions for Individuals & Businesses</h4>
                                    <span class="capability-tag tag-purple">CUSTOM OPS</span>
                                </div>
                                <p>Adaptive intelligence packages tailored for background checks, fraud auditing, and counter-surveillance.</p>
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
                            <span class="stat-strip-num">20+</span>
                            <span class="stat-strip-lbl">Years Field Mastery</span>
                        </div>
                        <div class="stat-strip-divider"></div>
                        <div class="stat-strip-item">
                            <span class="stat-strip-num">2,000+</span>
                            <span class="stat-strip-lbl">Verified Inquiries</span>
                        </div>
                        <div class="stat-strip-divider"></div>
                        <div class="stat-strip-item">
                            <span class="stat-strip-num">99.4%</span>
                            <span class="stat-strip-lbl">Accuracy Rate</span>
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
                            <div class="console-title">
                                <span class="console-icon">◈</span>
                                SOC COMMAND FEED // CAM-04
                            </div>
                            <div class="console-live-badge">
                                <span class="rec-pulse"></span>
                                LIVE FEED
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

                            <img src="assets/images/15_investigation_monitoring_room.png" alt="Cyber Kovai Investigation Monitoring Room" class="about-hero-img" loading="lazy">

                            <!-- Floating Experience Pill: Top Left (20+ Years) -->
                            <div class="hologram-pill holo-top-left">
                                <span class="pill-glow-dot"></span>
                                <span><strong>20+ Years</strong> Field Forensics</span>
                            </div>

                            <!-- Floating Holographic Badge 1: Top Right (Trusted by 2000+ Clients) -->
                            <div class="hologram-badge holo-top-right">
                                <div class="holo-badge-icon holo-icon-purple">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                        <circle cx="9" cy="7" r="4"/>
                                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                    </svg>
                                </div>
                                <div class="holo-badge-content">
                                    <span class="holo-badge-label">Verified Track Record</span>
                                    <div class="holo-badge-value">
                                        <strong>2,000+</strong> <span>Clients</span>
                                    </div>
                                </div>
                                <div class="holo-sparkle" aria-hidden="true">✦</div>
                            </div>

                            <!-- Floating Holographic Badge 2: Bottom Left (99% Accuracy) -->
                            <div class="hologram-badge holo-bottom-left">
                                <div class="holo-badge-icon holo-icon-emerald">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <circle cx="12" cy="12" r="10"/>
                                        <circle cx="12" cy="12" r="6"/>
                                        <circle cx="12" cy="12" r="2"/>
                                    </svg>
                                </div>
                                <div class="holo-badge-content">
                                    <span class="holo-badge-label">Evidentiary Precision</span>
                                    <div class="holo-badge-value">
                                        <strong class="text-emerald">99.4%</strong> <span>Accuracy</span>
                                    </div>
                                </div>
                                <div class="holo-sparkle holo-sparkle-emerald" aria-hidden="true">✦</div>
                            </div>

                            <!-- Holographic Telemetry Strip at Bottom of Image -->
                            <div class="console-telemetry-bar">
                                <span class="telemetry-item"><span class="telemetry-dot"></span> ENCRYPTION: AES-256</span>
                                <span class="telemetry-item">NODE: IN-COV-SOC-01</span>
                                <span class="telemetry-item">STATUS: ACTIVE</span>
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

                    <!-- CARD 1: Realworld Attack Simulation -->
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
                        <h3 class="cap-card-title">Realworld Attack Simulation</h3>
                        <ul class="cap-card-list list-blue">
                            <li><span class="cap-check">✓</span> Offensive approach to find vulnerabilities.</li>
                            <li><span class="cap-check">✓</span> Mapping with OWASP, CREST &amp; NIST standards</li>
                            <li><span class="cap-check">✓</span> Detailed Report with remediation steps</li>
                            <li><span class="cap-check">✓</span> Re-evaluation and issuance of certificates.</li>
                        </ul>
                    </div>

                    <!-- CARD 2: Vulnerability Management -->
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
                        <h3 class="cap-card-title">Vulnerability Management</h3>
                        <ul class="cap-card-list list-amber">
                            <li><span class="cap-check">✓</span> Vulnerabilities prioritization based on severity</li>
                            <li><span class="cap-check">✓</span> Comprehensive scans to detect vulnerabilities</li>
                            <li><span class="cap-check">✓</span> Detailed Report with remediation steps</li>
                            <li><span class="cap-check">✓</span> Establishment of vulnerability disclosure process.</li>
                        </ul>
                    </div>

                    <!-- CARD 3: Secure Architecture Design -->
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
                        <h3 class="cap-card-title">Secure Architecture Design</h3>
                        <ul class="cap-card-list list-green">
                            <li><span class="cap-check">✓</span> Conducting thorough reviews of system architecture.</li>
                            <li><span class="cap-check">✓</span> Assessment architecture against industry standards.</li>
                            <li><span class="cap-check">✓</span> Recommendations for enhancing security posture</li>
                            <li><span class="cap-check">✓</span> Check for potential points of entry for attackers.</li>
                        </ul>
                    </div>

                </div>

            </div>

        </section>

        <section class="stats-section cyber-stats-section">

            <div class="container">

                <div class="stats-counter-grid cyber-hud-stats">
                    <?php foreach ($stats as $stat): ?>
                        <div class="stat-counter-card cyber-hud-stat-card">
                            <div class="stat-card-beam" aria-hidden="true"></div>
                            <div class="stat-hud-chip">VERIFIED METRIC</div>
                            <strong class="stat-counter-val"><?= sanitize_out($stat['value']) ?></strong>
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
                        OUR PRACTICES
                    </span>

                    <h2>
                        Seven Practices. One Standard: <span>Verified Truth.</span>
                    </h2>

                    <p>
                        Comprehensive investigation and business intelligence services for individuals and organizations.
                    </p>

                </div>


                <div class="practices-bento-grid">

                    <?php foreach ($services as $index => $service): 
                        $isHero = ($index === 0 || $index === 3);
                        $refNum = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                    ?>
                        <article class="practice-bento-card <?= $isHero ? 'bento-hero-card' : '' ?> bento-item-<?= $index + 1 ?>">
                            <div class="bento-card-header">
                                <div class="bento-icon-wrapper">
                                    <?= get_forensic_icon($service['title'], 'bento-svg-icon', 24) ?>
                                </div>
                                <div class="bento-dossier-tag">
                                    <span class="dossier-code">// CASE-<?= $refNum ?></span>
                                    <?php if ($isHero): ?>
                                        <span class="dossier-badge">FEATURED DOSSIER</span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="bento-card-content">
                                <h3><?= sanitize_out($service['title']) ?></h3>
                                <p><?= sanitize_out($service['description']) ?></p>
                            </div>

                            <div class="bento-card-footer">
                                <a href="#contact" class="practice-cyber-link">
                                    <span>Explore Casefile</span>
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                        <line x1="5" y1="12" x2="19" y2="12"></line>
                                        <polyline points="12 5 19 12 12 19"></polyline>
                                    </svg>
                                </a>
                                <div class="bento-status-indicator">
                                    <span class="status-pulse-dot"></span>
                                    <span class="status-text">CLEARED</span>
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
                        OUR PROCESS
                    </span>

                    <h2>
                        A Structured <span>Intelligence Lifecycle</span>
                    </h2>

                    <p>
                        A systematic approach to deliver solutions and actionable insights.
                    </p>

                </div>

                <div class="cyber-pipeline-wrapper">
                    <div class="pipeline-conduit-line" aria-hidden="true">
                        <div class="pipeline-glow-pulse"></div>
                    </div>

                    <div class="cyber-pipeline-track">
                        <?php foreach ($processSteps as $i => $step): ?>
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

                                <div class="stage-hud-meta">
                                    <span class="stage-meta-code">STATUS: SYNCHRONIZED</span>
                                    <span class="stage-arrow">→</span>
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
                        OUR CLIENTS
                    </span>

                    <h2>
                        From Startups to <span>Multinationals</span>
                    </h2>

                    <p>
                        Organizations across industries trust Cyber Kovai for accurate and reliable insights.
                    </p>

                </div>


                <div class="client-tiers-deck">

                    <?php 
                    $tierNames = ['EMERGING VENTURES', 'REGIONAL MID-MARKET', 'HIGH-CAPACITY ENTERPRISE', 'INSTITUTIONAL BODIES', 'GLOBAL CONGLOMERATE'];
                    foreach ($clientTypes as $i => $client): 
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
                            OUR REACH
                        </span>

                        <h2>
                            From Coimbatore <span>to the World</span>
                        </h2>

                        <p class="coverage-subtitle">
                            Delivering trusted investigation and intelligence services to clients across India and internationally.
                        </p>

                        <div class="coverage-features">

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Global Network & Cross-Border Intelligence</h4>
                                    <p>Seamless operational capabilities across Asia-Pacific, Middle East, Europe, North America, and beyond.</p>
                                </div>
                            </div>

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>On-The-Ground Local Operatives</h4>
                                    <p>Direct access to vetted field investigators and legal intelligence partners in 50+ key international jurisdictions.</p>
                                </div>
                            </div>

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Strict International Legal Compliance</h4>
                                    <p>All inquiries are executed strictly within regional regulatory frameworks and data privacy mandates.</p>
                                </div>
                            </div>

                        </div>

                        <div class="coverage-locations-header">
                            <span>Key Operational Hubs & Coverage:</span>
                        </div>

                        <div class="locations-pill-bar">
                            <?php foreach ($locations as $loc): ?>
                                <span class="location-pill"><?= sanitize_out($loc) ?></span>
                            <?php endforeach; ?>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= ACCREDITATIONS & CREDENTIALS ================= -->

        <section class="section credentials-section">

            <div class="container text-center">

                <span class="section-tag">
                    OUR CREDENTIALS
                </span>

                <h2>
                    Memberships, Associations & <span>Certifications</span>
                </h2>

                <p style="max-width: 680px; margin: 0 auto 2.5rem; opacity: 0.85;">
                    We are associated with reputable organizations and certified bodies to ensure the highest standards of professionalism and ethics.
                </p>

                <!-- 4 Badges Static Display -->
                <div class="credentials-grid">
                    <?php foreach ($accreds as $badge): ?>
                        <div class="credentials-card">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>


        <!-- ================= BUSINESS RISK SIMULATOR (TOOL) ================= -->

        <section class="section tools-section cyber-tools-section" id="company">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        TOOLS
                    </span>

                    <h2>
                        Business Risk <span>Simulator</span>
                    </h2>

                    <p>
                        Assess potential risk and make informed decisions with our interactive tools.
                    </p>

                </div>


                <div class="simulator-matrix-deck">

                    <?php 
                    $vectors = ['IDENTITY', 'FINANCIAL', 'GEOLOCATION', 'PERSONNEL', 'PARTNERSHIP', 'SUPPLY CHAIN', 'ASSET INFRA', 'REGULATORY'];
                    foreach ($riskTools as $i => $tool): 
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

                    <?php foreach ($faqs as $faq): ?>
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
                        Ready to Reduce <span>Business Risk?</span>
                    </h2>

                    <p>
                        Partner with Cyber Kovai for trusted, confidential and professional investigation and business intelligence services.
                    </p>

                    <div class="contact-buttons">

                        <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn primary-btn">
                            Get a Consultation Ô×ö
                        </a>

                        <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" class="btn outline-btn">
                            Learn More
                        </a>

                    </div>

                    <!-- Interactive PHP Contact Form -->
                    <div class="contact-form-wrapper" style="margin-top: 3rem; width: 100%; text-align: left;">
                        <form id="contactForm" action="process-contact.php" method="POST">
                            <div id="formResponse" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;"></div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                                <div>
                                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Your Name *</label>
                                    <input type="text" id="name" name="name" required placeholder="John Doe" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                                <div>
                                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Email Address *</label>
                                    <input type="email" id="email" name="email" required placeholder="john@example.com" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                                <div>
                                    <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="+91 98765 43210" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                                <div>
                                    <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Service Required</label>
                                    <select id="service" name="service" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                        <option value="">Select a Practice</option>
                                        <?php foreach ($services as $service): ?>
                                            <option value="<?= sanitize_out($service['title']) ?>"><?= sanitize_out($service['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label for="message" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Details / Message *</label>
                                <textarea id="message" name="message" rows="4" required placeholder="Describe your requirement in brief..." style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; resize: vertical;"></textarea>
                            </div>

                            <button type="submit" class="btn primary-btn" style="cursor: pointer; border: none; width: 100%; justify-content: center; font-size: 1.05rem;">
                                Submit Confidential Request Ô×ö
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </section>

    </main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
