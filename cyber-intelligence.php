<?php
/**
 * Cyber Kovai — Digital Investigation & Forensics Solutions
 */
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/forensic-icons.php';

$activeSection   = 'forensics';
$pageTitle       = 'Digital Investigation & Forensics Services';
$pageDescription = 'Confidential digital investigations, accredited forensic evidence recovery, OSINT threat intelligence, and cyber fraud tracing by CyberKovai, Coimbatore.';

// Interactive Investigation Console 8-Pillar Data
$investigationPillars = [
    [
        'id'          => 'pillar-forensics',
        'target_slug' => 'cybercrime-victim-assistance-account-recovery',
        'num'         => '01',
        'code'        => 'INV-01 // DIGITAL_FORENSICS',
        'badge'       => 'COURT ADMISSIBLE',
        'title'       => 'Digital Forensics & Artifact Analysis',
        'short'       => 'Digital Forensics',
        'metric'      => '100% Cryptographic Verification',
        'meter'       => '100',
        'encryption'  => 'SHA-256 VAULT / HSM',
        'standard'    => 'ISO/IEC 27037 COURT STANDARD',
        'log'         => 'Forensic Triage: Cryptographic SHA-256 hash verified. Chain-of-custody sealed.',
        'desc'        => 'Court-admissible bit-stream imaging, volatile memory capture, deleted artifact carving, timestamp tampering detection, and root-cause breach tracing.',
        'target_id'   => 'target-forensics',
        'coords'      => 'SEC-HASH: SHA256-VAULT-VERIFIED',
        'status'      => 'CHAIN-OF-CUSTODY READY',
        'status_color'=> '#8b20ff',
        'capabilities'=> ['Memory & Disk Imaging', 'Deleted File Carving', 'Cryptographic Hashing', 'Court-Ready Expert Reports'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 0 0-7.07 17.07l.07.07"/><path d="M12 6a6 6 0 0 0-4.24 10.24"/><path d="M12 10a2 2 0 0 0-1.41 3.41"/><path d="M12 18v4"/><path d="M8 22h8"/><circle cx="12" cy="12" r="1"/></svg>'
    ],
    [
        'id'          => 'pillar-osint',
        'target_slug' => 'digital-investigations-osint',
        'num'         => '02',
        'code'        => 'INV-02 // OSINT_INTEL',
        'badge'       => 'DEEP INTELLIGENCE',
        'title'       => 'Digital Investigations & OSINT',
        'short'       => 'OSINT & Tracing',
        'metric'      => '99.4% Attribution Confidence',
        'metric_sub'  => 'Surface, Deep & Dark Web Profiling',
        'meter'       => '99',
        'encryption'  => 'ANONYMIZED TELEMETRY',
        'standard'    => 'ETHICAL INVESTIGATION PROTOCOL',
        'log'         => 'OSINT Recon: Multi-source footprint correlated. Digital identity confirmed across 8 platforms.',
        'desc'        => 'Comprehensive digital investigations using Open-Source Intelligence (OSINT) techniques to uncover online footprints, verify identities, and assess potential risks. Our reports provide actionable insights for personal, legal, and business decision-making.',
        'target_id'   => 'target-osint',
        'coords'      => 'OSINT: MULTI-VECTOR TRACE ACTIVE',
        'status'      => 'RECONNAISSANCE ACTIVE',
        'status_color'=> '#00f0ff',
        'image'       => 'assets/images/showcase_02_osint.jpg',
        'capabilities'=> ['Digital Footprint Tracing', 'Multi-Source Intelligence', 'Identity Verification', 'Actionable Risk Reports'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/><circle cx="11" cy="11" r="3"/></svg>'
    ],
    [
        'id'          => 'pillar-social',
        'target_slug' => 'social-media-investigations-impersonation-removal',
        'num'         => '03',
        'code'        => 'INV-03 // SOCIAL_INTEL',
        'badge'       => 'IDENTITY DEFENSE',
        'title'       => 'Social Media Investigations & Impersonation Removal',
        'short'       => 'Social Media Intel',
        'metric'      => '99.1% Impersonation Removal Rate',
        'metric_sub'  => 'Evidence Capture & Takedown Support',
        'meter'       => '99',
        'encryption'  => 'METADATA ARCHIVE / HASH SEAL',
        'standard'    => 'PLATFORM TOS & LEGAL COMPLIANCE',
        'log'         => 'Identity Verification: Fake profiles identified, metadata archived, takedown notice dispatched.',
        'desc'        => 'Identify and investigate fake profiles, impersonation attempts, account takeovers, and unauthorized content usage across major social media platforms. We help document evidence and support platform reporting and removal processes.',
        'target_id'   => 'target-social',
        'coords'      => 'IDENTITY: PROFILE ANOMALY DETECTED',
        'status'      => 'TAKEDOWN STREAM ACTIVE',
        'status_color'=> '#10b981',
        'image'       => 'assets/images/showcase_03_social_media.jpg',
        'capabilities'=> ['Fake Profile & Botnet Tracing', 'Harassment & Defamation Evidence', 'Account Takeover Recovery', 'Platform Legal Reporting Support'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
    ],
    [
        'id'          => 'pillar-fraud',
        'target_slug' => 'cyber-fraud-investigation-support',
        'num'         => '04',
        'code'        => 'INV-04 // FRAUD_TRACE',
        'badge'       => 'FINANCIAL FORENSICS',
        'title'       => 'Cyber Fraud Investigation Support',
        'short'       => 'Cyber Fraud Tracing',
        'metric'      => '₹50Cr+ Traced In Fraud Cases',
        'metric_sub'  => 'Crypto, Banking & Wire Scam Tracing',
        'meter'       => '98',
        'encryption'  => 'FIN-TRACE / BLOCKCHAIN AUDIT',
        'standard'    => 'LEA-READY EVIDENTIARY DOSSIER',
        'log'         => 'Fraud Trace: Transaction trail mapped across payment gateways and blockchain ledgers.',
        'desc'        => 'Professional investigation support for financial scams, investment fraud, crypto fraud, romance scams, and online marketplace deception. We analyze digital evidence, trace fraud indicators, and prepare detailed reports suitable for law enforcement review.',
        'target_id'   => 'target-fraud',
        'coords'      => 'TRACE: FINANCIAL TRAIL IDENTIFIED',
        'status'      => 'FRAUD INTEL ACTIVE',
        'status_color'=> '#f59e0b',
        'image'       => 'assets/images/showcase_04_fraud_support.jpg',
        'capabilities'=> ['Cryptocurrency Ledger Tracing', 'Phishing & Wire Scam Tracking', 'Mule Account Identification', 'LEA Complaint Dossier Prep'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/><circle cx="7" cy="15" r="1"/></svg>'
    ],
    [
        'id'          => 'pillar-evidence',
        'target_slug' => 'digital-evidence-preservation-forensics',
        'num'         => '05',
        'code'        => 'INV-05 // EVIDENCE_PRESERVATION',
        'badge'       => 'CHAIN OF CUSTODY',
        'title'       => 'Digital Evidence Preservation & Forensics',
        'short'       => 'Evidence Forensics',
        'metric'      => '100% Evidentiary Integrity',
        'metric_sub'  => 'Device, Email & Online Preservation',
        'meter'       => '100',
        'encryption'  => 'EVIDENCE ARCHIVE / HASH VAULT',
        'standard'    => 'FORENSIC EVIDENCE STANDARDS',
        'log'         => 'Evidence Custody: Digital evidence acquired and cryptographically sealed under strict chain-of-custody.',
        'desc'        => 'Secure collection, preservation, and analysis of digital evidence from devices, emails, screenshots, and online accounts. Our forensic documentation helps maintain evidence integrity for investigations, disputes, and legal proceedings.',
        'target_id'   => 'target-evidence',
        'coords'      => 'EVIDENCE: FORENSIC ACQUISITION SEALED',
        'status'      => 'EVIDENCE SEALED',
        'status_color'=> '#8b20ff',
        'image'       => 'assets/images/showcase_05_evidence_forensic.jpg',
        'capabilities'=> ['Secure Device Imaging', 'Tamper-Proof Metadata Capture', 'Email & Cloud Acquisition', 'Court-Admissible Dossiers'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>'
    ],
    [
        'id'          => 'pillar-executive',
        'target_slug' => 'executive-family-digital-protection',
        'num'         => '06',
        'code'        => 'INV-06 // VIP_DEFENSE',
        'badge'       => 'VIP PROTECTION',
        'title'       => 'Executive & Family Digital Protection',
        'short'       => 'Executive Defense',
        'metric'      => '24/7 Dark Web Monitoring',
        'metric_sub'  => 'Founders, Executives & Family Offices',
        'meter'       => '99',
        'encryption'  => 'VIP HARDENED TELEMETRY',
        'standard'    => 'EXECUTIVE RISK MANAGEMENT',
        'log'         => 'VIP Telemetry: Perimeter scan clear, personal device isolation verified.',
        'desc'        => 'Proactive cybersecurity services designed to protect business leaders, public figures, families, and high-profile individuals from digital threats. We assess security risks, improve privacy controls, and strengthen account and device protection.',
        'target_id'   => 'target-executive',
        'coords'      => 'VIP-SHIELD: SURVEILLANCE CLEARED',
        'status'      => 'VIP SHIELD ACTIVE',
        'status_color'=> '#00f0ff',
        'image'       => 'assets/images/showcase_06_executive_defense.jpg',
        'capabilities'=> ['VIP Dark Web Exposure Audits', 'Personal Device Hardening', 'Anti-Doxxing & Privacy Controls', 'Family Home Network Defense'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l7 4v6c0 5-3.5 9-7 10-3.5-1-7-5-7-10V6l7-4z"/><circle cx="12" cy="9" r="2.5"/><path d="M8 16c0-2.2 1.8-4 4-4s4 1.8 4 4"/></svg>'
    ],
    [
        'id'          => 'pillar-lea',
        'target_slug' => 'cybersecurity-awareness-lea-training',
        'num'         => '07',
        'code'        => 'INV-07 // LEA_ACADEMY',
        'badge'       => 'ACCREDITED TRAINING',
        'title'       => 'Cybersecurity Awareness & LEA Training',
        'short'       => 'LEA Training',
        'metric'      => '5,000+ Personnel Trained',
        'metric_sub'  => 'Police Academies & Enterprise Teams',
        'meter'       => '100',
        'encryption'  => 'CERTIFIED SYLLABUS',
        'standard'    => 'POLICE & CORPORATE ACCREDITATION',
        'log'         => 'Training Module: Digital evidence handling and live forensic extraction drills completed.',
        'desc'        => 'Specialized training programs for law enforcement agencies, educational institutions, NGOs, and corporate teams on cybercrime prevention and investigation techniques. Sessions focus on practical skills, digital evidence handling, fraud awareness, and incident response readiness.',
        'target_id'   => 'target-lea',
        'coords'      => 'ACADEMY: SESSIONS SCHEDULED',
        'status'      => 'ACCREDITED DRILLS',
        'status_color'=> '#eab308',
        'image'       => 'assets/images/showcase_07_lea_training.jpg',
        'capabilities'=> ['Forensic Seizure Protocols', 'Chain-of-Custody Procedures', 'Fraud Awareness Training', 'Incident Response Readiness'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>'
    ],
    [
        'id'          => 'pillar-child',
        'target_slug' => 'child-digital-safety-protection',
        'num'         => '08',
        'code'        => 'INV-08 // CHILD_SAFETY',
        'badge'       => 'ETHICAL SAFEGUARDING',
        'title'       => 'Child Digital Safety & Protection',
        'short'       => 'Child Protection',
        'metric'      => '100% Confidential Inquiry',
        'metric_sub'  => 'Anti-Bullying & Threat Assessment',
        'meter'       => '100',
        'encryption'  => 'ETHICAL DATA PRESERVATION',
        'standard'    => 'CHILD PROTECTION PROTOCOLS',
        'log'         => 'Safe Sentinel: Online interaction vectors assessed. Sensitive evidence captured for legal relief.',
        'desc'        => 'We help safeguard children in the digital world through confidential investigations, online threat assessment, and digital evidence analysis. Our services focus on identifying cyberbullying, online harassment, suspicious digital interactions, and potential child exploitation risks, including the identification and reporting of Child Sexual Abuse Material (CSAM).',
        'target_id'   => 'target-child',
        'coords'      => 'SAFEGUARD: MONITORING ACTIVE',
        'status'      => 'ETHICAL DEFENSE ACTIVE',
        'status_color'=> '#ec4899',
        'image'       => 'assets/images/showcase_08_child_safety.jpg',
        'capabilities'=> ['Cyberbullying Identification', 'Online Harassment Analysis', 'Suspicious Interaction Triage', 'CSAM Escalation & Reporting'],
        'svg_icon'    => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><circle cx="12" cy="10" r="3"/><path d="M7 18a5 5 0 0 1 10 0"/></svg>'
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

// Investigation Threat & Incident Tags (Word Cloud Format)
$investigationThreatsCloud = [
    ['text' => 'Cybercrime & Online Fraud',             'size' => 'xl', 'accent' => 'purple'],
    ['text' => 'Volatile Memory Extraction',            'size' => 'sm', 'accent' => 'cyan'],
    ['text' => 'Crypto & Blockchain Tracing',           'size' => 'lg', 'accent' => 'cyan'],
    ['text' => 'SIM Swapping & OTP Fraud',              'size' => 'md', 'accent' => 'amber'],
    ['text' => 'Digital Evidence Preservation',         'size' => 'lg', 'accent' => 'emerald'],
    ['text' => 'Metadata & Timestamp Forensics',        'size' => 'sm', 'accent' => 'purple'],
    ['text' => 'Ransomware Incident Triage',            'size' => 'xl', 'accent' => 'rose'],
    ['text' => 'WhatsApp & Telegram Forensics',         'size' => 'sm', 'accent' => 'emerald'],
    ['text' => 'Social Media Impersonation',            'size' => 'lg', 'accent' => 'purple'],
    ['text' => 'Business Email Compromise (BEC)',       'size' => 'md', 'accent' => 'amber'],
    ['text' => 'Device Bit-Stream Imaging',             'size' => 'sm', 'accent' => 'cyan'],
    ['text' => 'Corporate Data Theft & Espionage',      'size' => 'xl', 'accent' => 'amber'],
    ['text' => 'Fake Profile & Botnet Tracking',        'size' => 'sm', 'accent' => 'purple'],
    ['text' => 'Deepfake & AI Media Abuse',             'size' => 'md', 'accent' => 'cyan'],
    ['text' => 'Matrimonial & Personal Disputes',       'size' => 'md', 'accent' => 'purple'],
    ['text' => 'Investment & Ponzi Scams',              'size' => 'sm', 'accent' => 'amber'],
    ['text' => 'OSINT Threat Intelligence',             'size' => 'xl', 'accent' => 'cyan'],
    ['text' => 'Malicious APK & Spyware Analysis',      'size' => 'sm', 'accent' => 'rose'],
    ['text' => 'Cyberstalking & Harassment',            'size' => 'md', 'accent' => 'rose'],
    ['text' => 'Chain of Custody Certification',        'size' => 'sm', 'accent' => 'emerald'],
    ['text' => 'Extortion & Blackmail Tracing',         'size' => 'lg', 'accent' => 'rose'],
    ['text' => 'UPI & Banking Scams',                   'size' => 'md', 'accent' => 'cyan'],
    ['text' => 'Dark Web Data Leak Tracing',            'size' => 'md', 'accent' => 'purple'],
    ['text' => 'E-Commerce Marketplace Fraud',          'size' => 'sm', 'accent' => 'amber'],
    ['text' => 'Digital Forensics & Artifact Analysis',  'size' => 'xl', 'accent' => 'cyan'],
    ['text' => 'Cryptographic SHA-256 Hashing',         'size' => 'sm', 'accent' => 'emerald'],
    ['text' => 'Account Takeovers & Hacking',           'size' => 'md', 'accent' => 'purple'],
    ['text' => 'Cloud & Email Forensics',               'size' => 'sm', 'accent' => 'purple'],
    ['text' => 'Child Digital Safety Threats',          'size' => 'md', 'accent' => 'emerald'],
    ['text' => 'Phishing & Credential Theft',           'size' => 'md', 'accent' => 'rose'],
    ['text' => 'Defamation & Slander Evidence',         'size' => 'sm', 'accent' => 'purple'],
    ['text' => 'Court-Admissible Evidence Dossiers',    'size' => 'lg', 'accent' => 'emerald'],
    ['text' => 'Sextortion Emergency Takedowns',        'size' => 'sm', 'accent' => 'rose'],
    ['text' => 'Insider Threat Investigation',          'size' => 'md', 'accent' => 'amber'],
    ['text' => 'Deleted File & Artifact Carving',       'size' => 'md', 'accent' => 'cyan'],
    ['text' => 'Cross-Border LEA Reporting',            'size' => 'sm', 'accent' => 'cyan'],
    ['text' => 'Cell Tower & GPS Geolocation Tracing',  'size' => 'sm', 'accent' => 'cyan'],
    ['text' => 'Executive Anti-Doxxing & Privacy',      'size' => 'sm', 'accent' => 'emerald'],
];

// Fallback compatibility arrays
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
                <span class="ci-hero-rotator ci-typewriter-rotator" id="ciHeroRotator" aria-label="Cybercrime Investigations &amp; Digital Forensics Services: Cybercrime Analysis, Digital Forensics, OSINT Intelligence, Evidence Recovery, Cyber Fraud Tracing, Incident Investigation, Malware Analysis, Evidence Preservation" data-phrases='["Cybercrime Analysis","Digital Forensics","OSINT Intelligence","Evidence Recovery","Cyber Fraud Tracing","Incident Investigation","Malware Analysis","Evidence Preservation"]'>
                    <span class="ci-grad-text ci-typewriter-text" id="ciTypewriterText">Cybercrime Analysis</span><span class="ci-typewriter-cursor" aria-hidden="true"></span>
                </span>
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

            <!-- Central Forensic Intelligence Matrix (Zero Logo) -->
            <div class="ci-intel-stage ci-shield-wrap" id="ciIntelStage">
                <!-- Multi-layer ambient radial glow -->
                <div class="ci-intel-ambient-glow" aria-hidden="true"></div>

                <!-- Tactical HUD Reticle with Dual Counter-Rotating Radar Rings -->
                <svg class="ci-intel-reticle-svg" viewBox="0 0 160 160" fill="none" aria-hidden="true">
                    <!-- Fixed Outer Dial & Angle Brackets -->
                    <circle cx="80" cy="80" r="76" stroke="rgba(200, 75, 255, 0.22)" stroke-width="1" stroke-dasharray="2 6"/>
                    <path d="M56 8 H48 A4 4 0 0 0 44 12 V20" stroke="rgba(0, 240, 255, 0.55)" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M104 8 H112 A4 4 0 0 1 116 12 V20" stroke="rgba(0, 240, 255, 0.55)" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M56 152 H48 A4 4 0 0 1 44 148 V140" stroke="rgba(0, 240, 255, 0.55)" stroke-width="1.4" stroke-linecap="round"/>
                    <path d="M104 152 H112 A4 4 0 0 0 116 148 V140" stroke="rgba(0, 240, 255, 0.55)" stroke-width="1.4" stroke-linecap="round"/>

                    <!-- CW Rotating Ring with Calibration Ticks -->
                    <g class="ci-radar-spin-cw">
                        <circle cx="80" cy="80" r="70" stroke="url(#reticleGradCW)" stroke-width="1.5" stroke-dasharray="14 18 36 12"/>
                        <circle cx="80" cy="10" r="2.5" fill="#00f0ff"/>
                        <circle cx="80" cy="150" r="2.5" fill="#c84bff"/>
                    </g>

                    <!-- CCW Rotating Precision Ring -->
                    <g class="ci-radar-spin-ccw">
                        <circle cx="80" cy="80" r="62" stroke="url(#reticleGradCCW)" stroke-width="1.2" stroke-dasharray="6 8 2 8 20 14"/>
                        <line x1="80" y1="14" x2="80" y2="22" stroke="#c84bff" stroke-width="1.8"/>
                        <line x1="80" y1="138" x2="80" y2="146" stroke="#c84bff" stroke-width="1.8"/>
                        <line x1="14" y1="80" x2="22" y2="80" stroke="#00f0ff" stroke-width="1.8"/>
                        <line x1="138" y1="80" x2="146" y2="80" stroke="#00f0ff" stroke-width="1.8"/>
                    </g>

                    <defs>
                        <linearGradient id="reticleGradCW" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#00f0ff" stop-opacity="0.8"/>
                            <stop offset="50%" stop-color="#c84bff" stop-opacity="0.3"/>
                            <stop offset="100%" stop-color="#7b2ff7" stop-opacity="0.9"/>
                        </linearGradient>
                        <linearGradient id="reticleGradCCW" x1="100%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" stop-color="#c84bff" stop-opacity="0.9"/>
                            <stop offset="50%" stop-color="#7b2ff7" stop-opacity="0.2"/>
                            <stop offset="100%" stop-color="#00f0ff" stop-opacity="0.7"/>
                        </linearGradient>
                    </defs>
                </svg>

                <!-- Central Investigation Emblem Wrapper -->
                <div class="ci-intel-emblem-wrap" title="Forensic Investigation Core">
                    <svg class="ci-forensic-badge-svg" viewBox="0 0 130 146" fill="none" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Digital Forensic Evidence Scanner">
                        <defs>
                            <radialGradient id="forensicBodyGrad" cx="50%" cy="30%" r="75%">
                                <stop offset="0%" stop-color="#241447" stop-opacity="0.95"/>
                                <stop offset="50%" stop-color="#130c2a" stop-opacity="0.98"/>
                                <stop offset="100%" stop-color="#090514" stop-opacity="1"/>
                            </radialGradient>
                            <linearGradient id="forensicBorderGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" stop-color="#00f0ff"/>
                                <stop offset="30%" stop-color="#c84bff"/>
                                <stop offset="70%" stop-color="#7b2ff7"/>
                                <stop offset="100%" stop-color="#00f0ff"/>
                            </linearGradient>
                            <linearGradient id="forensicLaserGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                                <stop offset="0%" stop-color="#00f0ff" stop-opacity="0"/>
                                <stop offset="25%" stop-color="#00f0ff" stop-opacity="0.85"/>
                                <stop offset="50%" stop-color="#ffffff" stop-opacity="1"/>
                                <stop offset="75%" stop-color="#c84bff" stop-opacity="0.85"/>
                                <stop offset="100%" stop-color="#c84bff" stop-opacity="0"/>
                            </linearGradient>
                            <filter id="forensicLaserGlow" x="-30%" y="-150%" width="160%" height="400%">
                                <feGaussianBlur stdDeviation="3.5" result="blur"/>
                                <feMerge>
                                    <feMergeNode in="blur"/>
                                    <feMergeNode in="SourceGraphic"/>
                                </feMerge>
                            </filter>
                        </defs>

                        <!-- Outer Faceted Tactical Shield Shape -->
                        <path d="M65 6 L118 24 L118 78 C118 112 65 140 65 140 C65 140 12 112 12 78 L12 24 Z" 
                              fill="url(#forensicBodyGrad)" 
                              stroke="url(#forensicBorderGrad)" 
                              stroke-width="2.2" 
                              stroke-linejoin="round"/>

                        <!-- Inner Precision Border -->
                        <path d="M65 14 L110 30 L110 76 C110 106 65 131 65 131 C65 131 20 106 20 76 L20 30 Z" 
                              fill="none" 
                              stroke="rgba(200, 75, 255, 0.42)" 
                              stroke-width="1.2" 
                              stroke-dasharray="4 3" 
                              stroke-linejoin="round"/>

                        <!-- Forensic Biometric / Fingerprint Evidence Ridge Arcs -->
                        <g class="ci-biometric-group" opacity="0.85">
                            <path d="M54 84 C54 70 76 70 76 84" stroke="rgba(200, 75, 255, 0.75)" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M48 86 C48 64 82 64 82 86" stroke="rgba(0, 240, 255, 0.7)" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M42 88 C42 58 88 58 88 88" stroke="rgba(200, 75, 255, 0.6)" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M36 90 C36 52 94 52 94 90" stroke="rgba(123, 47, 247, 0.5)" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M60 82 C60 75 70 75 70 82" stroke="#00f0ff" stroke-width="2" stroke-linecap="round"/>
                        </g>

                        <!-- Forensic Target Crosshairs & Calibration Nodes -->
                        <g class="ci-reticle-nodes">
                            <line x1="65" y1="46" x2="65" y2="56" stroke="#00f0ff" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="65" y1="90" x2="65" y2="100" stroke="#00f0ff" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="38" y1="73" x2="48" y2="73" stroke="#00f0ff" stroke-width="1.5" stroke-linecap="round"/>
                            <line x1="82" y1="73" x2="92" y2="73" stroke="#00f0ff" stroke-width="1.5" stroke-linecap="round"/>
                            <!-- Precision Target Ring -->
                            <circle cx="65" cy="73" r="10" stroke="#00f0ff" stroke-width="1.4" stroke-dasharray="3 3"/>
                            <!-- Central Core Node -->
                            <circle cx="65" cy="73" r="3" fill="#ffffff" filter="url(#forensicLaserGlow)"/>
                        </g>

                        <!-- Active Laser Scanning Group -->
                        <g class="ci-laser-scan-group">
                            <line x1="22" y1="73" x2="108" y2="73" stroke="#00f0ff" stroke-width="5" opacity="0.35" filter="url(#forensicLaserGlow)"/>
                            <line x1="24" y1="73" x2="106" y2="73" stroke="url(#forensicLaserGrad)" stroke-width="2" stroke-linecap="round"/>
                            <circle cx="65" cy="73" r="3.5" fill="#ffffff" filter="url(#forensicLaserGlow)"/>
                            <circle cx="65" cy="73" r="1.5" fill="#00f0ff"/>
                        </g>

                        <!-- Top & Bottom Hex Accent Ticks -->
                        <circle cx="65" cy="22" r="2" fill="#00f0ff"/>
                        <circle cx="65" cy="122" r="2" fill="#c84bff"/>
                    </svg>

                    <!-- Live Investigation Telemetry Status Pill -->
                    <div class="ci-intel-core-status">
                        <span class="ci-intel-core-dot"></span>
                        <span class="ci-intel-core-txt">FORENSIC CORE</span>
                    </div>
                </div>
            </div>

            <!-- Data lines from center to 4 corner cards -->
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
                Court-grade forensic artifact analysis, OSINT intelligence mapping, financial fraud indicators tracing, and evidentiary preservation across our specialized investigation pillars.
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
                    <?php if (!empty($panel['image'])): ?><div class="ci-panel-bg" style="background-image: url('<?= sanitize_out($panel['image']) ?>');"></div><?php endif; ?>

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
                                <?php if (!empty($panel['metric_sub'])): ?><div class="ci-metric-sub"><?= sanitize_out($panel['metric_sub']) ?></div><?php endif; ?>
                            </div>

                            <a href="#svc-<?= sanitize_out($panel['target_slug'] ?? '') ?>" class="ci-panel-cta" data-target-slug="<?= sanitize_out($panel['target_slug'] ?? '') ?>" title="Explore <?= sanitize_out($panel['title']) ?>">
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
     ABOUT OUR INVESTIGATIVE METHODOLOGY
================================================================ -->



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
            <?php foreach ($investigationServices as $svcIndex => $svc): ?>
            <article class="ci-svc-card ci-reveal" id="svc-<?= sanitize_out($svc['slug']) ?>" data-slug="<?= sanitize_out($svc['slug']) ?>" data-index="<?= $svcIndex ?>">
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
            <div class="ci-process-line" aria-hidden="true">
                <div class="ci-process-flow-stream"></div>
                <div class="ci-process-glow-pulse ci-pulse-primary">
                    <span class="ci-pulse-photon"></span>
                </div>
                <div class="ci-process-glow-pulse ci-pulse-secondary">
                    <span class="ci-pulse-photon"></span>
                </div>
            </div>
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
     INCIDENTS & THREATS WE INVESTIGATE (WORD-CLOUD CHIPS FORMAT)
================================================================ -->
<section class="section ci-risks-section" id="ci-risks">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <h2>Incidents &amp; Threats We <span class="ci-grad-text">Investigate</span></h2>
            <p>Specialized investigative capabilities across diverse cybercrime, financial fraud, and digital dispute categories.</p>
        </div>

        <div class="ci-risks-cloud ci-reveal">
            <?php foreach ($investigationThreatsCloud as $tag): ?>
                <?php 
                    $text   = is_array($tag) ? ($tag['text'] ?? '') : $tag;
                    $size   = is_array($tag) ? ($tag['size'] ?? 'md') : 'md';
                    $accent = is_array($tag) ? ($tag['accent'] ?? 'purple') : 'purple';
                ?>
                <div class="ci-risk-tag tag-<?= sanitize_out($size) ?> accent-<?= sanitize_out($accent) ?>">
                    <span class="ci-risk-dot"></span>
                    <span><?= sanitize_out($text) ?></span>
                </div>
            <?php endforeach; ?>
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

        <!-- 4 Badges Display (Single Line) -->
        <div class="credentials-grid ci-reveal">
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


<!-- ================================================================
     GLOBAL FOOTPRINT
================================================================ -->
<section class="section ci-coverage-section" id="ci-coverage">
    <div class="container">
        <div class="ci-coverage-grid">

            <div class="ci-coverage-map-col ci-reveal">
                <div class="ci-map-card">
                    <div class="ci-map-head">
                        <div class="ci-map-title">GLOBAL INVESTIGATION FOOTPRINT</div>
                        <div class="ci-live"><span class="ci-live-dot"></span>Live Investigation Network</div>
                    </div>

                    <div class="ci-world-map-wrap" id="ciMap">
                        <canvas id="ciDots" width="2028" height="1330"></canvas>
                        <svg class="ci-map-svg" id="ciMapSvg" viewBox="0 0 1014 665" aria-hidden="true">
                            <defs>
                                <linearGradient id="ciArcGrad" x1="0" y1="0" x2="1" y2="0">
                                    <stop offset="0" stop-color="#22d3ee"/>
                                    <stop offset="1" stop-color="#a855f7"/>
                                </linearGradient>
                                <filter id="ciGlow" x="-50%" y="-50%" width="200%" height="200%">
                                    <feGaussianBlur stdDeviation="3" result="b"/>
                                    <feMerge><feMergeNode in="b"/><feMergeNode in="SourceGraphic"/></feMerge>
                                </filter>
                            </defs>
                            <g id="ciArcs"></g><g id="ciPackets"></g><g id="ciNodes"></g>
                        </svg>
                        <div class="ci-tip" id="ciTip" role="status" aria-live="polite">
                            <h4 id="ciTipName"></h4>
                            <div class="ci-tip-count"><b id="ciTipCases"></b> Cases Investigated</div>
                            <ul id="ciTipList"></ul>
                        </div>
                    </div>

                    <div class="ci-region-tabs" id="ciTabs">
                        <button class="is-active" data-region="all">All Regions</button>
                        <button data-region="asia">Asia</button>
                        <button data-region="na">North America</button>
                        <button data-region="europe">Europe</button>
                        <button data-region="me">Middle East</button>
                        <button data-region="aus">Australia</button>
                        <button data-region="africa">Africa</button>
                    </div>
                </div>
            </div>

            <div class="ci-coverage-content">
                <span class="section-tag ci-reveal"><span class="pulse-dot"></span>GLOBAL FOOTPRINT</span>
                <h2 class="ci-reveal">From Coimbatore <span class="ci-grad-text">to the World</span></h2>
                <p class="ci-reveal">We provide discreet digital investigation and forensics services to individuals, legal practices, corporations, and law enforcement agencies across India and internationally.</p>
                <div class="ci-stats-row ci-reveal">
                    <div class="ci-stat-item"><strong data-count="15" data-suffix="+">15+</strong><span>Countries Covered</span></div>
                    <div class="ci-stat-item"><strong data-count="500" data-suffix="+">500+</strong><span>Cases Investigated</span></div>
                    <div class="ci-stat-item"><strong data-count="100" data-suffix="%">100%</strong><span>Confidentiality Guaranteed</span></div>
                    <div class="ci-stat-item"><strong data-count="99.4" data-suffix="%" data-decimals="1">99.4%</strong><span>Evidentiary Precision</span></div>
                </div>
            </div>

        </div>
    </div>
</section>



<!-- ================================================================
     OUR CLIENTS & PARTNER ENGAGEMENTS
================================================================ -->
<section class="section ci-clients-section" id="ci-clients">
    <div class="container">

        <div class="section-heading text-center ci-reveal">
            <span class="section-tag">
                <span class="pulse-dot"></span>
                OUR CLIENTS
            </span>
            <h2>Organizations That <span class="ci-grad-text">Trust CyberKovai</span></h2>
            <p>From institutional intelligence analysis centers to premier hospitality brands, we deliver discreet digital investigation and cybersecurity services.</p>
        </div>

        <div class="ci-clients-deck ci-reveal">
            <?php foreach ($clientLogos as $client): ?>
            <div class="ci-client-card">
                <div class="ci-client-logo-box">
                    <img src="<?= sanitize_out($client['img']) ?>" alt="<?= sanitize_out($client['alt']) ?>" class="ci-client-logo-img" loading="lazy">
                </div>
                <div class="ci-client-card-body">
                    <h3><?= sanitize_out($client['name']) ?></h3>
                    <div class="ci-client-category-badge">
                        <span class="ci-client-badge-dot"></span>
                        <span><?= sanitize_out($client['category']) ?></span>
                    </div>
                    <?php if (!empty($client['desc'])): ?>
                    <p><?= sanitize_out($client['desc']) ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
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
                    <span class="btn-arrow" aria-hidden="true">&rarr;</span>
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
                        <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Your Name / Pseudonym *</label>
                        <input type="text" id="name" name="name" required placeholder="John Doe" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                    </div>
                    <div>
                        <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Secure Email Address *</label>
                        <input type="email" id="email" name="email" required placeholder="john@example.com" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                    <div>
                        <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone / WhatsApp / Signal *</label>
                        <input type="tel" id="phone" name="phone" required placeholder="+91 63820 19821" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                    </div>
                    <div>
                        <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Service Required *</label>
                        <select id="service" name="service" required style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; background: #130f28; border: 1px solid rgba(255,255,255,0.18); color: #fff;">
                            <option value="">Select an Investigation Practice</option>
                            <?php foreach ($investigationFormServices as $formService): ?>
                                <option value="<?= sanitize_out($formService) ?>"><?= sanitize_out($formService) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label for="message" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Details / Message *</label>
                    <textarea id="message" name="message" rows="4" required placeholder="Describe the suspected breach, affected devices/platforms, or required evidence preservation (strictly confidential)..." style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; resize: vertical; background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.18); color: #fff;"></textarea>
                </div>

                <?php if (defined('ENABLE_RECAPTCHA') && ENABLE_RECAPTCHA): ?>
                <!-- Google reCAPTCHA -->
                <div class="recaptcha-wrapper" style="margin-bottom: 1.5rem;">
                    <div class="g-recaptcha" data-sitekey="<?= sanitize_out(RECAPTCHA_SITE_KEY) ?>" data-theme="dark"></div>
                </div>
                <?php endif; ?>

                <button type="submit" class="btn primary-btn" style="cursor: pointer; border: none; width: 100%; justify-content: center; font-size: 1.05rem; padding: 1.05rem;">
                    Submit Confidential Investigation Request ➔
                </button>
            </form>
        </div>

    </div>
</section>



<script>
(() => {
  const W=1014,H=665,NS='http://www.w3.org/2000/svg';
  const reduce=matchMedia('(prefers-reduced-motion: reduce)').matches;

  // ===== Dotted world map (land mask, 144x95 grid) =====
  const MASK="AAAH/4///+AAV4AAAADwAAAAAAAD/w///8AAeAAAAABwAAAAAABDvj///8AAfAAAAAA8AAAAAAZr/n///8AAeAAAAAAMAAAAAAAoPv///8AAOgAAAAAIAAAAAAQEfH///8AAEgAAAAAAAAAAACAAeD///8AAMAAAAAAEAAAAAGAG/H///4AAAAAAGAAOAAAAANozCD///8AAAAAAeAAfwAAAAB2xEAH//8AAAAAA4AD/4AOAAB8V+AH//8AAAAABgAP/wAOwAAQA+AD//8AAAAABAAf/gAAAAeACAAD//4AAAAADAAf/gAAAAPCfVAB//4AAAAACAD//+YGAAfee+AB//4AAAAAGBj///8EAAf6Y/gB//wAAAAAEBl///8HwAL+O/4A//4AAAAAODf///9/wAD/G/8Bf/oAAAcAGD///////CR/mO+B//4AAB8AAD///////v9/LMeAf/wAAD/AAb/////////GLseA//AAAH/wFdv//////////svA/8AAAH/5f/v//////////8Pw/4AAAP/5f/f//////////wOg/wLgAP/H/////////////4+A/AHgAfPX/////////////sPA/AHAA/f//////////////IHAeAAAB+//////////////+EhAOAAAD8//////////////8A4AOAAAD8//////////+///8A8gCAAAD+z/////////8f//8A8gAAAADcf////////8EH//+A/wAAABAcf////////4BH///gfwAAABAo/////////wBD///w/4AAABhQ/////////gBB///9/8AAAGg3/////////yBB///8/+AAAHz//////////+BA/////8AAAB3//////////+BA/////4AAAAP//////////6AAf///9HAAAAf//////////6AAH////AAAAA///////////6AAP////oAAAAf/8vn//////wAAP///+gAAAAf38PP//////iAAf///4AAAAH4T4Hn/////+GAAP///4AAAAH4N93j/////8AAAP///wAAAAHwFv/n////+oEAAP///gAAAAHgIv/j////+MEAAH///gAAAAAPgBf//////EcAAH///AAAAAD/gAf//////BQAAB//+AAAAAH/wg///////CAAABf/8AAAAAH/9////////AAAAA/8CAAAAAP////v/////gAAAA/4CAAAAAf///f3/////AAAAAX4AAAAAA////PyD///+AAAAALwCAAAAA////v/B///8AAAAAB4wgAAAB////3/Afz+AAAAAAB4gMAAAA////3/Afh+gAAAAAAfgAAAAA////z8AeB+AgAAAAAB4AAAAB////7wAcAfAAAAAAAAYAAAAB////8AAMAfAQAAAAAAIeQAAA////+wAMATAgAAAAAAG/4AAAf////wACAQAIAAAAAAA/8AAAP////gACAIAAAAAAAAA//gAAAC///gAAAsGAAAAAAAA//gAAAA///AAAAceAAAAAAAB//gAAAA//8AAAAM9AAAAAAAD//8AAAA//4AAAAMdBYAAAAAD///gAAAf/4AAAAGBgfEAAAAB///4AAAP/wAAAABAAviAAAAB///4AAAP/4AAAAADoGgAAAAA///wAAAP/4AAAAAAAAAAAAAAf//gAAAP/4QAAAAADyAAAAAAf//gAAAf/4wAAAAAPjAAAAAAH//gAAAf/xwAAAAAf7AAAAAAD//AAAAP/hgAAAAA//gAAAAAD//AAAAP/hgAAAAH//wAAAAAD/8AAAAH/hgAAAAH//wAAAAAH/wAAAAH/BAAAAAH//4AAAAAH/wAAAAH+AAAAAAH//8AAAAAH/wAAAAD+AAAAAAH//8AAAAAH/gAAAAD8AAAAAAH//8AAAAAH/AAAAAD4AAAAAAHw/4AAAAAH+AAAAAAAAAAAAACAPwAAAAAP8AAAAAAAAAAAAAAAHwAAAAAP8AAAAAAAAAAAAAAACgAAAAAPwAAAAAAAAAAAAAAAAAAAAAAPAAAAAAAAAAAAAAAAAgAAAAAPAAAAAAAAAAAAAAAAAgAAAAAPAAAAAAAAAAAAAAAAAAAAAAAeAAAAAAAAAAAAAAAAAAAAAAAfAAAAAAAAAAAAAAAAAAAAAAAeAAAAAAAAAAAAAAAAAAAAAAAcAAAAAAAAAAAAAAAAAAAAAAAcMAAAAAAAAAAAAAAAAAAAAAAKAAAAAAAAAAAAAAAAAAAAAAAGAAAAAAAAAAAAAAAAAA";
  const COLS=144,STEP=7;
  (function drawDots(){
    const bin=atob(MASK),cv=document.getElementById('ciDots'),cx=cv.getContext('2d'),k=cv.width/W;
    for(let i=0;i<COLS*95;i++){
      if(!((bin.charCodeAt(i>>3)>>(7-(i&7)))&1))continue;
      const c=i%COLS,r=(i/COLS)|0;
      cx.fillStyle=`rgba(${70+r%3*20},${90+c%4*10},255,${.35+((c*7+r*13)%10)/22})`;
      cx.beginPath();cx.arc((c+.5)*STEP*k,(r+.5)*STEP*k,1.6*k,0,6.283);cx.fill();
    }
  })();

  // ===== Nodes (x,y in map pixels, viewBox 1014x665) =====
  const HUB={name:'Coimbatore',x:733,y:415};
  const NODES=[
    {name:'Canada',x:135,y:232,region:'na',cases:18,tags:['Cyber Fraud','Online Harassment']},
    {name:'United States',x:142,y:314,region:'na',cases:42,tags:['Cyber Fraud','Data Breach Investigation','Intellectual Property Theft']},
    {name:'UK',x:466,y:248,region:'europe',cases:31,tags:['Financial Fraud','Digital Forensics']},
    {name:'Germany',x:507,y:259,region:'europe',cases:16,tags:['Data Breach Investigation']},
    {name:'UAE',x:656,y:371,region:'me',cases:37,tags:['Financial Fraud','Crypto Tracing']},
    {name:'India',x:737,y:382,region:'asia',cases:290,tags:['Cyber Fraud','Digital Forensics','Social Media Crimes'],ly:-10},
    {name:'Singapore',x:824,y:447,region:'asia',cases:22,tags:['Corporate Investigation']},
    {name:'Australia',x:926,y:535,region:'aus',cases:19,tags:['IP Theft','Data Breach Investigation'],lx:-70},
    {name:'South Africa',x:558,y:549,region:'africa',cases:12,tags:['Financial Fraud']}
  ];
  // cases / tags above are placeholders — put your real numbers.

  const gArcs=document.getElementById('ciArcs'),gPk=document.getElementById('ciPackets'),gNodes=document.getElementById('ciNodes'),tip=document.getElementById('ciTip');
  const el=(n,a={})=>{const e=document.createElementNS(NS,n);for(const k in a)e.setAttribute(k,a[k]);return e};
  const packets=[];

  NODES.forEach((n,i)=>{
    const dx=HUB.x-n.x,dy=HUB.y-n.y,dist=Math.hypot(dx,dy),sign=n.y<=HUB.y?-1:1;
    const cx=(n.x+HUB.x)/2,cy=(n.y+HUB.y)/2+sign*dist*.22;
    const path=el('path',{d:`M${n.x},${n.y} Q${cx},${cy} ${HUB.x},${HUB.y}`,class:'ci-arc'});
    gArcs.appendChild(path);n.arc=path;const len=path.getTotalLength();
    if(!reduce){
      path.style.strokeDasharray=len;path.style.strokeDashoffset=len;
      path.animate([{strokeDashoffset:len},{strokeDashoffset:0}],{duration:1600,delay:300+i*180,fill:'forwards',easing:'ease-out'})
        .onfinish=()=>{path.style.strokeDasharray='';path.style.strokeDashoffset='';path.classList.add('is-flow')};
      const pk=el('circle',{r:3,fill:'#fff',filter:'url(#ciGlow)',opacity:0});gPk.appendChild(pk);
      packets.push({pk,path,len,speed:.00012+(i%3)*.00004,t:(i*.17)%1});
    }
    const g=el('g',{class:'ci-node',tabindex:0,role:'button','aria-label':n.name});
    g.append(el('circle',{class:'ring',cx:n.x,cy:n.y,r:7}),el('circle',{class:'halo',cx:n.x,cy:n.y,r:11}),el('circle',{class:'core',cx:n.x,cy:n.y,r:4.5}));
    const t=el('text',{x:n.x+(n.lx??12),y:n.y+(n.ly??-9)});t.textContent=n.name;g.appendChild(t);
    ['mouseenter','focus','click'].forEach(ev=>g.addEventListener(ev,()=>focusNode(n,true)));
    gNodes.appendChild(g);n.g=g;
  });

  const hub=el('g',{class:'ci-node is-hub'});
  hub.append(el('circle',{class:'ring',cx:HUB.x,cy:HUB.y,r:9}),el('circle',{class:'halo',cx:HUB.x,cy:HUB.y,r:14}),el('circle',{class:'core',cx:HUB.x,cy:HUB.y,r:6}));
  const ht=el('text',{x:HUB.x-30,y:HUB.y+30});ht.textContent=HUB.name;hub.appendChild(ht);gNodes.appendChild(hub);

  if(!reduce){let last=performance.now();(function f(now){const dt=now-last;last=now;
    packets.forEach(p=>{p.t+=p.speed*dt;if(p.t>1)p.t=0;const pt=p.path.getPointAtLength(p.t*p.len);
      p.pk.setAttribute('cx',pt.x);p.pk.setAttribute('cy',pt.y);
      p.pk.setAttribute('opacity',p.path.classList.contains('is-dim')?0:Math.sin(p.t*Math.PI))});
    requestAnimationFrame(f)})(last)}

  const $=id=>document.getElementById(id);let paused=false,rt;
  function focusNode(n,user){
    if(n.g.classList.contains('is-dim'))return;
    NODES.forEach(o=>o.g.classList.toggle('is-active',o===n));
    $('ciTipName').textContent=n.name;$('ciTipCases').textContent=n.cases;
    $('ciTipList').innerHTML=n.tags.map(t=>`<li>${t}</li>`).join('');
    const px=n.x/W*100,py=n.y/H*100;
    tip.style.left=px>55?'auto':`calc(${px}% + 16px)`;
    tip.style.right=px>55?`calc(${100-px}% + 16px)`:'auto';
    tip.style.top=`min(${py}%, calc(100% - 150px))`;
    tip.classList.add('is-show');
    if(user){paused=true;clearTimeout(rt);rt=setTimeout(()=>paused=false,8000)}
  }
  let idx=0;
  setInterval(()=>{if(paused||reduce)return;const v=NODES.filter(n=>!n.g.classList.contains('is-dim'));if(v.length)focusNode(v[idx++%v.length],false)},4000);
  focusNode(NODES[1],false);

  $('ciTabs').addEventListener('click',e=>{
    const b=e.target.closest('button');if(!b)return;
    document.querySelectorAll('#ciTabs button').forEach(x=>x.classList.toggle('is-active',x===b));
    const r=b.dataset.region;
    NODES.forEach(n=>{const d=r!=='all'&&n.region!==r;n.g.classList.toggle('is-dim',d);n.arc.classList.toggle('is-dim',d)});
    const f=NODES.find(n=>r==='all'||n.region===r);if(f)focusNode(f,true);
  });

  const io=new IntersectionObserver(es=>es.forEach(en=>{
    if(!en.isIntersecting)return;io.unobserve(en.target);
    const s=en.target,end=+s.dataset.count,d=+(s.dataset.decimals||0),suf=s.dataset.suffix||'';
    if(reduce)return;
    const t0=performance.now();
    (function tick(now){const p=Math.min((now-t0)/1800,1),e=1-Math.pow(1-p,3);s.textContent=(end*e).toFixed(d)+suf;if(p<1)requestAnimationFrame(tick)})(t0);
  }),{threshold:.4});
  document.querySelectorAll('.ci-stat-item strong[data-count]').forEach(s=>io.observe(s));
})();
</script>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
