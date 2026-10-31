<?php
/**
 * Cyber Kovai - Configuration & Site Metadata
 */

// Load Environment Variables (.env)
if (!function_exists('loadEnv')) {
    function loadEnv($path = __DIR__ . '/.env') {
        if (!file_exists($path)) {
            return false;
        }
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '' || strpos($line, '#') === 0) {
                continue;
            }
            $parts = explode('=', $line, 2);
            if (count($parts) === 2) {
                $key = trim($parts[0]);
                $val = trim($parts[1]);
                $len = strlen($val);
                if ($len >= 2 && (($val[0] === '"' && $val[$len - 1] === '"') || ($val[0] === "'" && $val[$len - 1] === "'"))) {
                    $val = substr($val, 1, -1);
                }
                if (getenv($key) === false) {
                    putenv("{$key}={$val}");
                }
                if (!isset($_ENV[$key])) {
                    $_ENV[$key] = $val;
                }
                if (!isset($_SERVER[$key])) {
                    $_SERVER[$key] = $val;
                }
            }
        }
        return true;
    }
}
loadEnv(__DIR__ . '/.env');

if (!function_exists('env')) {
    function env($key, $default = null) {
        $val = getenv($key);
        if ($val !== false) {
            return $val;
        }
        return $_ENV[$key] ?? $_SERVER[$key] ?? $default;
    }
}

// Google reCAPTCHA Configuration (set ENABLE_RECAPTCHA to false for testing)
define('ENABLE_RECAPTCHA', filter_var(env('ENABLE_RECAPTCHA', false), FILTER_VALIDATE_BOOLEAN));
define('RECAPTCHA_SITE_KEY', env('RECAPTCHA_SITE_KEY', '6LfIJwYuAAAAAGqRA8w9Y_gV0Dg13VyMmKtIB36q'));
define('RECAPTCHA_SECRET_KEY', env('RECAPTCHA_SECRET_KEY', '6LfIJwYuAAAAABb1O5gIL9wZ5Q8Wx_dWPMj6Z6AQ'));

// Google Sheets Integration (Apps Script Web App)
define('GOOGLE_SCRIPT_URL', env('GOOGLE_SCRIPT_URL', 'https://script.google.com/macros/s/AKfycbxCF61hcrOSjTVht96TrymhNCjzLCRPyeRByyD4t1OYRy96c6SMkjqyh-PLnsR_3zztfA/exec'));
define('GOOGLE_SHEETS_SECRET', env('GOOGLE_SHEETS_SECRET', ''));
define('GOOGLE_SPREADSHEET_ID', env('GOOGLE_SPREADSHEET_ID', '1L6CQ3_fQQymHvjt3jhyzvGVU3OK-jlYlxkkca_8gLKw'));
define('GOOGLE_SHEET_TAB', env('GOOGLE_SHEET_TAB', 'Website Leads'));

// Site Information
define('SITE_NAME', 'Cyber Kovai');
define('SITE_TAGLINE', 'Verified Facts, Confident Decisions.');
define('SITE_EMAIL', 'info@cyberkovai.com');
define('SITE_PHONE', '+91 63820 19821');
define('SITE_PHONE_TEL', '+919876543210');
define('SITE_LOCATION', 'Coimbatore, Tamil Nadu, India');

// Navigation Links
$navLinks = [
    'index.php' => 'Home',
    'about.php' => 'About',
    '#services' => 'Services',
    '#contact'  => 'Contact'
];

// Focus Categories (Corporate Intelligence)
$focusCategories = [
    'Market Insights',
    'Competitive Analysis',
    'Risk Alerts',
    'Compliance Support',
    'Strategic Guidance'
];

// Stats Array
$stats = [
    ['value' => '2000+', 'label' => 'SATISFIED CLIENTS'],
    ['value' => '99%',   'label' => 'ACCURACY'],
    ['value' => '15+',   'label' => 'YEARS EXPERIENCE'],
    ['value' => '19+',   'label' => 'INDUSTRIES SERVED'],
    ['value' => '5',     'label' => 'COUNTRIES']
];

// 8 Investigation Services Array (Image 3)
$investigationServices = [
    [
        'id'          => '1',
        'slug'        => 'cybercrime-victim-assistance-account-recovery',
        'title'       => 'Cybercrime Victim Assistance & Account Recovery',
        'short'       => 'Victim & Account Recovery',
        'icon'        => '🛡️',
        'image'       => 'assets/images/investigation_01_victim_recovery.jpg',
        'description' => 'Support for individuals affected by account hacking, online fraud, phishing, impersonation, and cyber extortion incidents. We assist with incident assessment, evidence preservation, recovery guidance, and strengthening account security to prevent future attacks.'
    ],
    [
        'id'          => '2',
        'slug'        => 'digital-investigations-osint',
        'title'       => 'Digital Investigations & OSINT',
        'short'       => 'Digital Investigations & OSINT',
        'icon'        => '🔍',
        'image'       => 'assets/images/investigation_02_osint.jpg',
        'description' => 'Comprehensive digital investigations using Open-Source Intelligence (OSINT) techniques to uncover online footprints, verify identities, and assess potential risks. Our reports provide actionable insights for personal, legal, and business decision-making.'
    ],
    [
        'id'          => '3',
        'slug'        => 'social-media-investigations-impersonation-removal',
        'title'       => 'Social Media Investigations & Impersonation Removal',
        'short'       => 'Social Media Investigations',
        'icon'        => '📱',
        'image'       => 'assets/images/investigation_03_social_media.jpg',
        'description' => 'Identify and investigate fake profiles, impersonation attempts, account takeovers, and unauthorized content usage across major social media platforms. We help document evidence and support platform reporting and removal processes.'
    ],
    [
        'id'          => '4',
        'slug'        => 'cyber-fraud-investigation-support',
        'title'       => 'Cyber Fraud Investigation Support',
        'short'       => 'Cyber Fraud Investigation',
        'icon'        => '💳',
        'image'       => 'assets/images/investigation_04_fraud_support.jpg',
        'description' => 'Professional investigation support for financial scams, investment fraud, crypto fraud, romance scams, and online marketplace deception. We analyse digital evidence, trace fraud indicators, and prepare detailed reports suitable for law enforcement review.'
    ],
    [
        'id'          => '5',
        'slug'        => 'digital-evidence-preservation-forensics',
        'title'       => 'Digital Evidence Preservation & Forensics',
        'short'       => 'Digital Evidence & Forensics',
        'icon'        => '💾',
        'image'       => 'assets/images/investigation_05_digital_forensics.jpg',
        'description' => 'Secure collection, preservation, and analysis of digital evidence from devices, emails, screenshots, and online accounts. Our forensic documentation helps maintain evidence integrity for investigations, disputes, and legal proceedings.'
    ],
    [
        'id'          => '6',
        'slug'        => 'executive-family-digital-protection',
        'title'       => 'Executive & Family Digital Protection',
        'short'       => 'Executive & Family Protection',
        'icon'        => '👨‍👩‍👧‍👦',
        'image'       => 'assets/images/investigation_06_executive_family.jpg',
        'description' => 'Proactive cybersecurity services designed to protect business leaders, public figures, families, and high-profile individuals from digital threats. We assess security risks, improve privacy controls, and strengthen account and device protection.'
    ],
    [
        'id'          => '7',
        'slug'        => 'cybersecurity-awareness-lea-training',
        'title'       => 'Cybersecurity Awareness & LEA Training',
        'short'       => 'Cyber Awareness & LEA Training',
        'icon'        => '🎓',
        'image'       => 'assets/images/investigation_07_lea_training.jpg',
        'description' => 'Specialized training programs for law enforcement agencies, educational institutions, NGOs, and corporate teams on cybercrime prevention and investigation techniques. Sessions focus on practical skills, digital evidence handling, fraud awareness, and incident response readiness.'
    ],
    [
        'id'          => '8',
        'slug'        => 'child-digital-safety-protection',
        'title'       => 'Child Digital Safety & Protection',
        'short'       => 'Child Digital Safety',
        'icon'        => '👶',
        'image'       => 'assets/images/investigation_08_child_safety.jpg',
        'description' => 'We help safeguard children in the digital world through confidential investigations, online threat assessment, and digital evidence analysis. Our services focus on identifying cyberbullying, online harassment, suspicious digital interactions, and potential child exploitation risks, including the identification and reporting of Child Sexual Abuse Material (CSAM).'
    ]
];

// 7 Practices / Services Array (Image 1)
$services = [
    [
        'id'          => '01',
        'title'       => 'Pre Matrimonial Screening',
        'icon'        => '💍',
        'image'       => 'assets/images/04_pre_matrimonial_screening.png',
        'description' => 'Detailed background verification to help you make informed personal decisions.'
    ],
    [
        'id'          => '02',
        'title'       => 'Post Matrimonial Disputes',
        'icon'        => '⚖️',
        'image'       => 'assets/images/05_post_matrimonial_disputes.png',
        'description' => 'Discreet investigations to support legal proceedings and marital disputes.'
    ],
    [
        'id'          => '03',
        'title'       => 'Document Verification',
        'icon'        => '📑',
        'image'       => 'assets/images/06_character_verification.png',
        'description' => 'Authentic verification of documents, certificates and credentials.'
    ],
    [
        'id'          => '04',
        'title'       => 'Corporate Investigation',
        'icon'        => '🏢',
        'image'       => 'assets/images/07_corporate_investigation.png',
        'description' => 'In-depth investigations to protect your business interests.'
    ],
    [
        'id'          => '05',
        'title'       => 'Cyber Investigation',
        'icon'        => '🛡️',
        'image'       => 'assets/images/08_cyber_investigation.png',
        'description' => 'Digital forensics and online threat intelligence.'
    ],
    [
        'id'          => '06',
        'title'       => 'Surveillance',
        'icon'        => '🔍',
        'image'       => 'assets/images/09_surveillance_services.png',
        'description' => 'Professional surveillance to gather reliable and verifiable facts.'
    ],
    [
        'id'          => '07',
        'title'       => 'Background Verification',
        'icon'        => '👤',
        'image'       => 'assets/images/06_character_verification.png',
        'description' => 'Comprehensive verification for individuals, tenants and employees.'
    ]
];

// Process Steps (5 Steps)
$processSteps = [
    [
        'num'   => '01',
        'title' => 'Consultation',
        'desc'  => 'Understand your needs confidentially.'
    ],
    [
        'num'   => '02',
        'title' => 'Information Gathering',
        'desc'  => 'Gather data through discreet sources & tech.'
    ],
    [
        'num'   => '03',
        'title' => 'Analysis',
        'desc'  => 'Analyse information to uncover key insights.'
    ],
    [
        'num'   => '04',
        'title' => 'Report Delivery',
        'desc'  => 'Deliver actionable intelligence reports.'
    ],
    [
        'num'   => '05',
        'title' => 'Ongoing Support',
        'desc'  => 'Continued support for your strategic needs.'
    ]
];

// Industry Categories (15 items)
$industries = [
    ['icon' => '🏥', 'name' => 'Healthcare'],
    ['icon' => '💳', 'name' => 'Finance'],
    ['icon' => '🎓', 'name' => 'Education'],
    ['icon' => '🏭', 'name' => 'Manufacturing'],
    ['icon' => '🏢', 'name' => 'Real Estate'],
    ['icon' => '💻', 'name' => 'IT & Technology'],
    ['icon' => '🛍️', 'name' => 'Retail'],
    ['icon' => '🏨', 'name' => 'Hospitality'],
    ['icon' => '🏛️', 'name' => 'Government'],
    ['icon' => '⚖️', 'name' => 'Legal'],
    ['icon' => '🎬', 'name' => 'Media & Entertainment'],
    ['icon' => '🚀', 'name' => 'MSE & Aerospace'],
    ['icon' => '🚗', 'name' => 'Automotive'],
    ['icon' => '💡', 'name' => 'Startups'],
    ['icon' => '🌐', 'name' => 'Other Industries']
];

// Client Scales
$clientTypes = [
    ['icon' => '🚀', 'title' => 'Startups', 'desc' => 'Supporting new ventures with verified information.'],
    ['icon' => '🏢', 'title' => 'SMEs', 'desc' => 'Helping growing businesses manage risk.'],
    ['icon' => '🏙️', 'title' => 'Large Enterprises', 'desc' => 'Comprehensive intelligence support.'],
    ['icon' => '🏛️', 'title' => 'Government Bodies', 'desc' => 'Providing meticulous analytical reports.'],
    ['icon' => '🌐', 'title' => 'Multinationals', 'desc' => 'Global intelligence solutions.']
];

// Reach locations
$locations = ['Delhi', 'CHN', 'HYD', 'BLR', 'Singapore', 'Australia', 'Canada', 'Germany', 'Taiwan', 'Sri Lanka', 'Malaysia', 'Thailand', 'Saudi Arabia', 'South Africa', 'Vietnam'];

// Risk Simulator Tools
$riskTools = [
    ['icon' => '🔍', 'title' => 'Background & Risk Assessment', 'desc' => 'Track background & risk profiles'],
    ['icon' => '💰', 'title' => 'Financial Risk Analysis', 'desc' => 'Financial sanity & credit checks'],
    ['icon' => '📍', 'title' => 'Location Risk Mapping', 'desc' => 'Detect geographic vulnerabilities'],
    ['icon' => '👤', 'title' => 'Employment Verification', 'desc' => 'Check candidate antecedents'],
    ['icon' => '🤝', 'title' => 'Business Partner Screening', 'desc' => 'Assess potential business partners'],
    ['icon' => '📦', 'title' => 'Vendor Risk Check', 'desc' => 'Supply chain risk evaluation'],
    ['icon' => '🛡️', 'title' => 'Asset Risk Assessment', 'desc' => 'Physical & digital asset protection'],
    ['icon' => '📑', 'title' => 'Compliance Risk Review', 'desc' => 'Regulatory & compliance reviews']
];

// Accreditation Badges (Approved Investigative Association Licenses)
$accreds = [
    ['img' => 'assets/images/aid.png', 'alt' => 'AID - Association of Investigators and Detectives'],
    ['img' => 'assets/images/tapdi.png', 'alt' => 'TAPDI - Tamilnadu Association of Professional Detectives and Investigators'],
    ['img' => 'assets/images/apdi.png', 'alt' => 'APDI - Association of Professional Detectives & Investigators'],
    ['img' => 'assets/images/unip.svg', 'alt' => 'UNIP - Unified Network of Investigative Professionals']
];

// Trusted Clients & Partner Organizations
$clientLogos = [
    [
        'name'     => 'CopConnect',
        'category' => 'Information Sharing and Analysis Center',
        'desc'     => 'Strategic collaboration in cyber threat intelligence sharing, awareness, and digital incident advisory.',
        'img'      => 'assets/images/client_copconnect.jpg',
        'alt'      => 'CopConnect - Information Sharing and Analysis Center'
    ],
    [
        'name'     => 'Gokarna Samudra',
        'category' => 'Beach Resort & Hospitality',
        'desc'     => 'Digital infrastructure protection, cyber dispute resolution, and guest data privacy security.',
        'img'      => 'assets/images/client_gokarna_samudra.jpg',
        'alt'      => 'Gokarna Samudra Beach Resort'
    ]
];

// FAQs Array
$faqs = [
    [
        'question' => 'What services do you offer?',
        'answer'   => 'We offer Pre Matrimonial Screening, Corporate Investigation, Document Verification, Cyber Investigation, Surveillance, Background Verification, and Risk Intelligence.'
    ],
    [
        'question' => 'How long does an investigation take?',
        'answer'   => 'The duration depends on the complexity of the case, typically ranging from 3 to 14 working days.'
    ],
    [
        'question' => 'Is my information kept strictly confidential?',
        'answer'   => 'Yes, 100% confidentiality is guaranteed. All client information and case files are strictly protected.'
    ],
    [
        'question' => 'Do you provide international investigation coverage?',
        'answer'   => 'Yes. Based in Coimbatore, India, we extend our network globally across Singapore, Australia, US, UK, and UAE.'
    ]
];

// Globe Route Hub & Cities
$hub = ['n' => 'Coimbatore (Hub)', 'll' => [76.9558, 11.0168], 'o' => [14, -4], 'hub' => 1];
$globeCities = [
  ['n' => 'Delhi',        'll' => [77.2, 28.6],    'o' => [10, -14]],
  ['n' => 'Hyderabad',    'll' => [78.48, 17.38],  'o' => [-70, -20]],
  ['n' => 'Bengaluru',    'll' => [77.59, 12.97],  'o' => [-78, 8]],
  ['n' => 'Sri Lanka',    'll' => [79.86, 6.93],   'o' => [-66, 18]],
  ['n' => 'Singapore',    'll' => [103.82, 1.35],  'o' => [10, 8]],
  ['n' => 'Malaysia',     'll' => [101.69, 3.14],  'o' => [-62, 0]],
  ['n' => 'Thailand',     'll' => [100.5, 13.75],  'o' => [10, -4]],
  ['n' => 'Vietnam',      'll' => [106.63, 10.82], 'o' => [10, 4]],
  ['n' => 'Taiwan',       'll' => [121.56, 25.03], 'o' => [10, -8]],
  ['n' => 'Australia',    'll' => [151.2, -33.87], 'o' => [10, 0]],
  ['n' => 'Canada',       'll' => [-79.38, 43.65], 'o' => [-58, -12]],
  ['n' => 'Germany',      'll' => [8.68, 50.11],   'o' => [-58, -10]],
  ['n' => 'Saudi Arabia', 'll' => [46.7, 24.7],    'o' => [-84, -4]],
  ['n' => 'South Africa', 'll' => [28.05, -26.2],  'o' => [10, 4]],
];

/**
 * Helper function to escape HTML special characters
 */
function sanitize_out($string) {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

