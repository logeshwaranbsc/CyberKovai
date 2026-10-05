<?php
/**
 * Cyber Kovai - Configuration & Site Metadata
 */

// Site Information
define('SITE_NAME', 'Cyber Kovai');
define('SITE_TAGLINE', 'Verified Facts, Confident Decisions.');
define('SITE_EMAIL', 'info@cyberkovai.com');
define('SITE_PHONE', '+91 98765 43210');
define('SITE_PHONE_TEL', '+919876543210');
define('SITE_LOCATION', 'Coimbatore, Tamil Nadu, India');

// Navigation Links
$navLinks = [
    'index.php' => 'Home',
    'about.php' => 'About',
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

// Accreditation Badges
$accreds = [
    ['img' => 'assets/images/apdi.webp', 'alt' => 'APDI Certification'],
    ['img' => 'assets/images/tapdi.webp', 'alt' => 'TAPDI Certification'],
    ['img' => 'assets/images/aid.webp', 'alt' => 'AID Certification'],
    ['img' => 'assets/images/iso-9001.webp', 'alt' => 'ISO 9001'],
    ['img' => 'assets/images/iso-27001(1).webp', 'alt' => 'ISO 27001'],
    ['img' => 'assets/images/iso-27701.webp', 'alt' => 'ISO 27701'],
    ['img' => 'assets/images/msme.webp', 'alt' => 'MSME Govt of India'],
    ['img' => 'assets/images/dpiit.webp', 'alt' => 'DPIIT Startup India'],
    ['img' => 'assets/images/asis.webp', 'alt' => 'ASIS International'],
    ['img' => 'assets/images/nasscom.webp', 'alt' => 'NASSCOM'],
    ['img' => 'assets/images/osac.webp', 'alt' => 'OSAC'],
    ['img' => 'assets/images/psara.webp', 'alt' => 'PSARA'],
    ['img' => 'assets/images/tnsdc.webp', 'alt' => 'TNSDC']
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

