<?php
/**
 * Cyber Kovai — Cyber Intelligence Services Page
 */
require_once __DIR__ . '/config.php';

$pageTitle       = 'Cyber Intelligence Services';
$pageDescription = 'Proactive cyber intelligence solutions to detect risks, investigate digital threats, conduct advanced forensics and protect your sensitive information. CyberKovai, Coimbatore.';

// 4-Panel showcase data
$cyberPanels = [
    [
        'num'   => '01',
        'title' => 'Threat Intelligence',
        'short' => 'Threat Intelligence',
        'desc'  => 'Identify and analyze emerging threats before they impact your business. Real-time monitoring across digital channels, dark web and threat databases.',
        'image' => 'assets/images/22_threat_intelligence.jpg',
    ],
    [
        'num'   => '02',
        'title' => 'Digital Forensics',
        'short' => 'Digital Forensics',
        'desc'  => 'Recover, analyze and preserve digital evidence for legal proceedings and internal investigations using advanced forensic methodologies.',
        'image' => 'assets/images/23_digital_forensics.jpg',
    ],
    [
        'num'   => '03',
        'title' => 'Cyber Risk Assessment',
        'short' => 'Cyber Risk',
        'desc'  => 'Systematic evaluation of your digital attack surface, vulnerabilities and risk exposure across all online channels and infrastructure.',
        'image' => 'assets/images/24_cyber_risk_assessment.jpg',
    ],
    [
        'num'   => '04',
        'title' => 'Data Protection',
        'short' => 'Data Protection',
        'desc'  => 'Protect sensitive data and prevent unauthorized access with robust information security frameworks and data loss prevention strategies.',
        'image' => 'assets/images/25_data_protection.jpg',
    ],
];

// 6 Cyber Services
$cyberServices = [
    ['icon'=>'🛡️','title'=>'Cyber Risk Assessment','desc'=>'Identify vulnerabilities, analyze risks and strengthen your security posture with a comprehensive cyber risk assessment.'],
    ['icon'=>'🔬','title'=>'Digital Forensics','desc'=>'Recover, analyze and preserve digital evidence for investigations and legal proceedings using industry-standard forensic tools.'],
    ['icon'=>'🔍','title'=>'Social Media Investigation','desc'=>'Uncover digital footprints, monitor online activity and verify social media identities for personal and corporate matters.'],
    ['icon'=>'🔒','title'=>'Data & Information Security','desc'=>'Protect sensitive data and prevent unauthorized access with robust information security frameworks and data loss prevention.'],
    ['icon'=>'📡','title'=>'Cyber Security Advisory','desc'=>'Strategic guidance to strengthen your cyber infrastructure, policies and incident response capabilities.'],
    ['icon'=>'🏢','title'=>'Brand & Executive Protection','desc'=>'Detect online threats and safeguard your brand, executives and critical information from impersonation and defamation.'],
];

// Protection process
$cyberProcess = [
    ['num'=>'01','title'=>'Detect',   'desc'=>'Identify potential threats and risks across your digital environment.'],
    ['num'=>'02','title'=>'Investigate','desc'=>'Analyze and trace the source of the threat or breach.'],
    ['num'=>'03','title'=>'Analyze',  'desc'=>'Uncover patterns, assess impact and map vulnerabilities.'],
    ['num'=>'04','title'=>'Respond',  'desc'=>'Take actionable measures to mitigate risks and contain incidents.'],
    ['num'=>'05','title'=>'Protect',  'desc'=>'Strengthen defenses and prevent future threats with ongoing support.'],
];

// Cyber risk tags
$cyberRisks = [
    'Malware & Ransomware','Phishing Attacks','Data Breaches','Insider Threats',
    'Social Engineering','Account Takeover','Dark Web Monitoring','Business Email Compromise',
    'Brand Impersonation','IP Theft',
];

// Testimonials
$testimonials = [
    [
        'quote' => 'CyberKovai helped us identify critical vulnerabilities in our infrastructure and prevented a potential data breach. Their threat intelligence is invaluable.',
        'name'  => 'Ramesh S.',
        'role'  => 'Director, Manufacturing',
    ],
    [
        'quote' => 'Their digital forensics expertise was instrumental in resolving a complex cybersecurity incident for our organization. Highly professional team.',
        'name'  => 'Priya L.',
        'role'  => 'CTO, Financial Services',
    ],
    [
        'quote' => 'Professional, responsive and highly knowledgeable team. Their threat intelligence services are extremely valuable for our business.',
        'name'  => 'Arun G.',
        'role'  => 'Manager, IT & Commerce',
    ],
];

// FAQs
$cyberFaqs = [
    ['q'=>'What cyber intelligence services do you offer?',        'a'=>'We offer Cyber Risk Assessment, Digital Forensics, Social Media Investigation, Data & Information Security, Cyber Security Advisory, and Brand & Executive Protection services.'],
    ['q'=>'How long does an investigation take?',                   'a'=>'Investigation timelines vary based on complexity, typically ranging from 3 to 21 working days. We provide regular progress updates throughout.'],
    ['q'=>'Is my information kept confidential?',                   'a'=>'Yes. 100% confidentiality is guaranteed. All client information, case details and findings are protected under strict non-disclosure protocols.'],
    ['q'=>'Do you provide support for international cases?',        'a'=>'Yes. We extend our cyber intelligence services to clients across India and internationally, with coverage in Singapore, Australia, Germany, Canada, UAE and more.'],
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
                <a href="index.php" class="btn outline-btn">
                    <span>&#x2190;</span> Explore Investigation
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
     4-PANEL HORIZONTAL SHOWCASE
================================================================ -->
<section class="ci-showcase" id="ci-showcase">

    <div class="ci-showcase-panels" id="ciShowcasePanels">

        <?php foreach ($cyberPanels as $i => $panel): ?>
        <div class="ci-panel <?= $i === 0 ? 'ci-panel-active' : '' ?>"
             data-panel="<?= $i ?>"
             id="ciPanel<?= $i ?>"
             style="background-image: url('<?= sanitize_out($panel['image']) ?>')">

            <div class="ci-panel-overlay"></div>

            <div class="ci-panel-particles" aria-hidden="true">
                <?php for ($p=0;$p<5;$p++): ?><span class="ci-ptcl"></span><?php endfor; ?>
            </div>

            <!-- Collapsed state -->
            <div class="ci-panel-collapsed">
                <span class="ci-panel-num"><?= sanitize_out($panel['num']) ?></span>
                <div class="ci-panel-short-title">
                    <?php foreach (explode(' ', $panel['short']) as $word): ?>
                        <span><?= sanitize_out($word) ?></span>
                    <?php endforeach; ?>
                </div>
                <div class="ci-panel-expand-icon">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9,18 15,12 9,6"/>
                    </svg>
                </div>
            </div>

            <!-- Expanded state -->
            <div class="ci-panel-expanded">
                <div class="ci-panel-exp-num"><?= sanitize_out($panel['num']) ?></div>
                <h3 class="ci-panel-exp-title"><?= sanitize_out($panel['title']) ?></h3>
                <p class="ci-panel-exp-desc"><?= sanitize_out($panel['desc']) ?></p>
                <a href="#contact" class="ci-panel-cta">
                    Explore
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12,5 19,12 12,19"/>
                    </svg>
                </a>
            </div>

        </div><!-- /ci-panel -->
        <?php endforeach; ?>

    </div><!-- /ci-showcase-panels -->

</section><!-- /ci-showcase -->


<!-- ================================================================
     ABOUT OUR APPROACH
================================================================ -->
<section class="section ci-approach" id="ci-approach">
    <div class="container">
        <div class="ci-approach-grid">

            <!-- Left: Image -->
            <div class="ci-approach-img-col ci-reveal">
                <div class="ci-approach-img-wrap">
                    <img src="assets/images/15_investigation_monitoring_room.png"
                         alt="Cyber Analyst Operations Center" class="ci-approach-img" loading="lazy">
                    <div class="ci-approach-img-border"></div>
                    <div class="ci-approach-badge">
                        <div class="ci-approach-badge-icon">🕐</div>
                        <div>
                            <strong>24/7</strong>
                            <span>Threat Monitoring</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right: Content -->
            <div class="ci-approach-content">
                <span class="section-tag ci-reveal">ABOUT OUR APPROACH</span>

                <h2 class="ci-reveal">
                    Proactive Intelligence<br>
                    for a <span>Safer Tomorrow</span>
                </h2>

                <p class="ci-reveal">
                    We combine advanced technology, cyber intelligence and deep expertise to identify threats early, analyze risks and help organizations stay ahead of evolving cyber challenges.
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
                        <?= sanitize_out($point) ?>
                    </li>
                    <?php endforeach; ?>
                </ul>

                <a href="#contact" class="btn primary-btn ci-reveal" style="margin-top:1.5rem;display:inline-flex;">
                    Learn More About Cyber Intelligence &#x2192;
                </a>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================
     CYBER SERVICES (6 CARDS)
================================================================ -->
<section class="section ci-services-section" id="ci-services">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">OUR SERVICES</span>
            <h2>Comprehensive <span>Cyber Intelligence</span> Solutions</h2>
            <p>End-to-end cyber intelligence services to help businesses detect, investigate, respond and stay protected.</p>
        </div>

        <div class="ci-services-grid">
            <?php foreach ($cyberServices as $svc): ?>
            <article class="ci-svc-card ci-reveal">
                <div class="ci-svc-icon"><?= $svc['icon'] ?></div>
                <h3><?= sanitize_out($svc['title']) ?></h3>
                <p><?= sanitize_out($svc['desc']) ?></p>
                <a href="#contact" class="ci-svc-link">
                    Learn More
                    <svg viewBox="0 0 24 24" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="5" y1="12" x2="19" y2="12"/>
                        <polyline points="12,5 19,12 12,19"/>
                    </svg>
                </a>
            </article>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     PROTECTION PROCESS (5 STEPS)
================================================================ -->
<section class="section ci-process-section" id="ci-process">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">OUR PROCESS</span>
            <h2>How We <span>Protect Your Business</span></h2>
            <p>A systematic and proactive approach to cyber intelligence.</p>
        </div>

        <div class="ci-process-track">
            <?php foreach ($cyberProcess as $idx => $step): ?>
            <div class="ci-process-step ci-reveal">
                <div class="ci-process-num"><?= sanitize_out($step['num']) ?></div>
                <div class="ci-process-icon">
                    <?php
                    $icons = ['🔎','🕵️','📊','⚡','🛡️'];
                    echo $icons[$idx] ?? '🔵';
                    ?>
                </div>
                <h4><?= sanitize_out($step['title']) ?></h4>
                <p><?= sanitize_out($step['desc']) ?></p>
            </div>
            <?php if ($idx < count($cyberProcess)-1): ?>
            <div class="ci-process-arrow" aria-hidden="true">
                <svg viewBox="0 0 32 16" width="32" height="16" fill="none">
                    <path d="M0 8h28" stroke="url(#arrowGrad)" stroke-width="1.5" stroke-dasharray="3 3"/>
                    <path d="M24 4l6 4-6 4" stroke="url(#arrowGrad)" stroke-width="1.5" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="arrowGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" stop-color="#7b2ff7"/>
                            <stop offset="100%" stop-color="#c84bff"/>
                        </linearGradient>
                    </defs>
                </svg>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     CYBER RISKS
================================================================ -->
<section class="section ci-risks-section" id="ci-risks">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <h2>Cyber Risks We Help You <span>Identify</span></h2>
            <p>Stay ahead of evolving threats with continuous monitoring and intelligence.</p>
        </div>

        <div class="ci-risks-grid ci-reveal">
            <?php foreach ($cyberRisks as $risk): ?>
            <div class="ci-risk-tag">
                <span class="ci-risk-dot"></span>
                <?= sanitize_out($risk) ?>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>


<!-- ================================================================
     GLOBAL COVERAGE
================================================================ -->
<section class="section ci-coverage-section" id="ci-coverage">
    <div class="container">

        <div class="ci-coverage-grid">

            <!-- Map side -->
            <div class="ci-coverage-map-col ci-reveal">
                <div class="ci-world-map-wrap">
                    <!-- SVG world map placeholder with glowing dots -->
                    <svg class="ci-world-map-svg" viewBox="0 0 800 400" preserveAspectRatio="xMidYMid meet" aria-label="Global coverage map">
                        <!-- Simplified world map paths -->
                        <rect width="800" height="400" fill="transparent"/>
                        <!-- Grid lines -->
                        <?php for ($g=0;$g<8;$g++): ?>
                            <line x1="<?= $g*100 ?>" y1="0" x2="<?= $g*100 ?>" y2="400" stroke="rgba(139,32,255,0.08)" stroke-width="1"/>
                        <?php endfor; ?>
                        <?php for ($g=0;$g<5;$g++): ?>
                            <line x1="0" y1="<?= $g*100 ?>" x2="800" y2="<?= $g*100 ?>" stroke="rgba(139,32,255,0.08)" stroke-width="1"/>
                        <?php endfor; ?>

                        <!-- Continent blobs (simplified) -->
                        <!-- North America -->
                        <ellipse cx="160" cy="160" rx="90" ry="70" fill="rgba(139,32,255,0.12)" stroke="rgba(139,32,255,0.2)" stroke-width="1"/>
                        <!-- South America -->
                        <ellipse cx="200" cy="300" rx="50" ry="65" fill="rgba(139,32,255,0.10)" stroke="rgba(139,32,255,0.18)" stroke-width="1"/>
                        <!-- Europe -->
                        <ellipse cx="390" cy="130" rx="55" ry="50" fill="rgba(139,32,255,0.12)" stroke="rgba(139,32,255,0.2)" stroke-width="1"/>
                        <!-- Africa -->
                        <ellipse cx="400" cy="270" rx="60" ry="85" fill="rgba(139,32,255,0.10)" stroke="rgba(139,32,255,0.18)" stroke-width="1"/>
                        <!-- Asia -->
                        <ellipse cx="580" cy="150" rx="120" ry="80" fill="rgba(139,32,255,0.12)" stroke="rgba(139,32,255,0.2)" stroke-width="1"/>
                        <!-- Australia -->
                        <ellipse cx="660" cy="310" rx="60" ry="40" fill="rgba(139,32,255,0.10)" stroke="rgba(139,32,255,0.18)" stroke-width="1"/>

                        <!-- Coimbatore hub -->
                        <circle cx="550" cy="195" r="6" fill="#c84bff" opacity="0.9">
                            <animate attributeName="r" values="6;10;6" dur="2s" repeatCount="indefinite"/>
                            <animate attributeName="opacity" values="0.9;0.4;0.9" dur="2s" repeatCount="indefinite"/>
                        </circle>
                        <circle cx="550" cy="195" r="3" fill="#fff"/>
                        <text x="558" y="191" fill="rgba(255,255,255,0.7)" font-size="9" font-family="Inter,sans-serif">Coimbatore</text>

                        <!-- Location dots -->
                        <?php
                        $dotLocations = [
                            [160,155,'Delhi'],[200,120,'Mumbai'],[390,125,'Germany'],
                            [620,190,'Singapore'],[665,310,'Australia'],[140,120,'Canada'],
                            [410,260,'S. Africa'],[500,175,'Saudi Arabia'],[640,170,'Thailand'],
                        ];
                        foreach ($dotLocations as [$dx,$dy,$dn]):
                        ?>
                        <circle cx="<?=$dx?>" cy="<?=$dy?>" r="4" fill="rgba(200,75,255,0.7)">
                            <animate attributeName="opacity" values="0.7;0.3;0.7" dur="<?= (rand(15,30)/10) ?>s" repeatCount="indefinite"/>
                        </circle>
                        <!-- connecting line to hub -->
                        <line x1="<?=$dx?>" y1="<?=$dy?>" x2="550" y2="195"
                              stroke="rgba(139,32,255,0.18)" stroke-width="1" stroke-dasharray="3 5">
                            <animate attributeName="stroke-dashoffset" values="0;-16" dur="<?= (rand(18,35)/10) ?>s" repeatCount="indefinite"/>
                        </line>
                        <?php endforeach; ?>
                    </svg>
                </div>
            </div>

            <!-- Content side -->
            <div class="ci-coverage-content">
                <span class="section-tag ci-reveal">GLOBAL COVERAGE</span>

                <h2 class="ci-reveal">From Coimbatore <span>to the World</span></h2>

                <p class="ci-reveal">
                    We provide cyber intelligence services to businesses and organizations across India and internationally, with a trusted network of partners worldwide.
                </p>

                <div class="ci-stats-row">
                    <?php foreach ([
                        ['15+','Countries'],['500+','Investigations'],['24/7','Threat Monitoring'],['99%','Success Rate'],
                    ] as $stat): ?>
                    <div class="ci-stat-item ci-reveal">
                        <strong><?= $stat[0] ?></strong>
                        <span><?= $stat[1] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="ci-coverage-locations ci-reveal">
                    <?php foreach (['India','UAE','Singapore','Canada','Germany','Malaysia','Thailand','Australia','Saudi Arabia','South Africa','Other Regions'] as $loc): ?>
                    <span class="ci-loc-pill"><?= sanitize_out($loc) ?></span>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- ================================================================
     TESTIMONIALS
================================================================ -->
<section class="section ci-testimonials" id="ci-testimonials">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">CLIENT FEEDBACK</span>
            <h2>What Our <span>Clients Say</span></h2>
        </div>

        <div class="ci-testi-grid">
            <?php foreach ($testimonials as $t): ?>
            <div class="ci-testi-card ci-reveal">
                <div class="ci-testi-quote-icon">&#x201C;</div>
                <p class="ci-testi-quote"><?= sanitize_out($t['quote']) ?></p>
                <div class="ci-testi-author">
                    <div class="ci-testi-avatar">
                        <?= strtoupper(substr($t['name'], 0, 1)) ?>
                    </div>
                    <div>
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
     FAQ
================================================================ -->
<section class="section ci-faq-section" id="ci-faq">
    <div class="container" style="max-width:800px">

        <div class="ci-faq-grid">

            <div class="ci-faq-left ci-reveal">
                <span class="section-tag">FAQ</span>
                <h2>Frequently Asked <span>Questions</span></h2>
                <p>Have more questions? Our team is ready to help.</p>
                <a href="#contact" class="btn primary-btn" style="margin-top:1.5rem;display:inline-flex;">
                    Talk to Our<br>Cyber Intelligence Experts
                </a>
            </div>

            <div class="ci-faq-list">
                <?php foreach ($cyberFaqs as $faq): ?>
                <div class="ci-faq-item ci-reveal">
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

    </div>
</section>


<!-- ================================================================
     FINAL CTA
================================================================ -->
<section class="ci-final-cta" id="contact">
    <!-- Background digital network canvas -->
    <canvas id="ciCtaCanvas" class="ci-cta-canvas" aria-hidden="true"></canvas>

    <div class="container ci-cta-inner">
        <span class="section-tag ci-reveal">SECURE YOUR BUSINESS</span>
        <h2 class="ci-reveal">Secure Your <span>Digital Future</span></h2>
        <p class="ci-reveal">
            Partner with CyberKovai for proactive cyber intelligence and comprehensive security solutions.
        </p>
        <div class="ci-cta-btns ci-reveal">
            <a href="#ci-services" class="btn primary-btn">
                Explore Cyber Services &#x2192;
            </a>
            <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn outline-btn">
                Talk to an Expert
            </a>
        </div>
    </div>
</section>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
