<?php
/**
 * Cyber Kovai - File Storage Engine & Data Access Layer
 * Handles JSON file storage, auto-seeding, file locks, atomic writes, uploads, and data sync.
 */

require_once __DIR__ . '/env.php';

if (!defined('CK_DATA_DIR')) {
    $envDataDir = function_exists('env') ? env('CK_DATA_DIR') : null;
    define('CK_DATA_DIR', ($envDataDir && trim((string) $envDataDir) !== '') ? rtrim((string) $envDataDir, '/\\') : dirname(__DIR__) . '/data');
}
if (!defined('CK_UPLOADS_DIR')) {
    define('CK_UPLOADS_DIR', CK_DATA_DIR . '/uploads');
}

/**
 * Returns absolute path for a data file.
 */
function ck_data_path($filename) {
    return CK_DATA_DIR . '/' . ltrim($filename, '/\\');
}

/**
 * Read JSON file with error handling and fallback default.
 */
function ck_read_json($filename, $default = []) {
    $path = ck_data_path($filename);
    if (!file_exists($path)) {
        return $default;
    }
    $raw = @file_get_contents($path);
    if ($raw === false || trim($raw) === '') {
        return $default;
    }
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : $default;
}

/**
 * Write JSON file safely with exclusive file lock and atomic rename.
 */
function ck_write_json($filename, $data) {
    if (!is_dir(CK_DATA_DIR)) {
        @mkdir(CK_DATA_DIR, 0755, true);
    }
    $path = ck_data_path($filename);
    $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    if ($json === false) {
        return false;
    }

    $tmpPath = $path . '.tmp.' . getmypid() . '.' . bin2hex(random_bytes(4));
    $fp = @fopen($tmpPath, 'wb');
    if ($fp === false) {
        return @file_put_contents($path, $json, LOCK_EX) !== false;
    }

    try {
        $written = fwrite($fp, $json);
        if ($written !== strlen($json)) {
            return false;
        }
        fflush($fp);
    } finally {
        fclose($fp);
    }

    for ($i = 0; $i < 5; $i++) {
        if (@rename($tmpPath, $path)) {
            if (basename($path) === 'admins.json') {
                @chmod($path, 0600);
            }
            return true;
        }
        usleep(5000);
    }

    @unlink($tmpPath);
    return @file_put_contents($path, $json, LOCK_EX) !== false;
}

/**
 * Generates URL-friendly slug from string.
 */
function ck_slugify($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'service-' . time() : $text;
}

/**
 * Ensure services/<slug>.php exists so direct URLs resolve correctly.
 */
function ck_sync_service_file($slug) {
    if (empty($slug)) {
        return false;
    }
    $servicesDir = dirname(__DIR__) . '/services';
    if (!is_dir($servicesDir)) {
        @mkdir($servicesDir, 0755, true);
    }
    $targetFile = $servicesDir . '/' . $slug . '.php';
    if (!file_exists($targetFile)) {
        $content = "<?php\n/**\n * Dynamically Generated Service Page for {$slug}\n */\n\$serviceSlug = " . var_export($slug, true) . ";\nrequire_once __DIR__ . '/../service.php';\n";
        return @file_put_contents($targetFile, $content) !== false;
    }
    return true;
}

/**
 * Remove services/<slug>.php if it exists when a service is deleted.
 */
function ck_remove_service_file($slug) {
    if (empty($slug)) {
        return false;
    }
    $targetFile = dirname(__DIR__) . '/services/' . $slug . '.php';
    if (file_exists($targetFile)) {
        @unlink($targetFile);
    }
    return true;
}

/**
 * Handle secure file upload for images (logos, avatars, team photos, service images).
 */
function ck_handle_upload($fileArray, $prefix = 'img') {
    if (empty($fileArray) || !isset($fileArray['error']) || $fileArray['error'] === UPLOAD_ERR_NO_FILE) {
        return ['success' => false, 'error' => 'No file provided.'];
    }

    if ($fileArray['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'Upload error code: ' . $fileArray['error']];
    }

    // Limit size to 8MB
    if ($fileArray['size'] > 8 * 1024 * 1024) {
        return ['success' => false, 'error' => 'File size exceeds maximum 8MB limit.'];
    }

    $allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml', 'image/gif'];

    $originalName = basename($fileArray['name']);
    $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if (!in_array($ext, $allowedExts, true)) {
        return ['success' => false, 'error' => 'Invalid file extension. Allowed: ' . implode(', ', $allowedExts)];
    }

    // Verify mime type if finfo is available
    if (function_exists('finfo_open')) {
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $fileArray['tmp_name']);
        finfo_close($finfo);
        if ($mime && !in_array($mime, $allowedMimes, true) && $ext !== 'svg') {
            return ['success' => false, 'error' => 'Invalid image MIME type: ' . $mime];
        }
    }

    if (!is_dir(CK_UPLOADS_DIR)) {
        @mkdir(CK_UPLOADS_DIR, 0755, true);
    }

    $cleanBase = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($originalName, PATHINFO_FILENAME));
    $cleanBase = substr($cleanBase, 0, 30);
    $newFilename = $prefix . '_' . time() . '_' . substr(md5(uniqid('', true)), 0, 6) . '.' . $ext;
    $destination = CK_UPLOADS_DIR . '/' . $newFilename;

    if (!move_uploaded_file($fileArray['tmp_name'], $destination)) {
        return ['success' => false, 'error' => 'Failed to move uploaded file.'];
    }

    // Return path relative to project root
    $relPath = 'data/uploads/' . $newFilename;
    return ['success' => true, 'path' => $relPath, 'filename' => $newFilename];
}

/* ==========================================================================
   SETTINGS (Mail ID, Phone numbers, Address, Location, Metadata)
   ========================================================================== */

function ck_get_settings() {
    $defaults = [
        'site_name'        => 'Cyber Kovai',
        'site_tagline'     => 'Verified Facts, Confident Decisions.',
        'site_email'       => 'info@cyberkovai.com',
        'site_phone'       => '+91 63820 19821',
        'site_phone_tel'   => '+916382019821',
        'site_phone_alt'   => '+91 98765 43210',
        'site_location'    => 'Coimbatore, Tamil Nadu, India',
        'site_address'     => 'Cyber Kovai Intelligence & Forensics Center, Coimbatore, Tamil Nadu, India',
        'working_hours'    => '24/7 Incident Response & Emergency Support',
        'social_linkedin'  => 'https://linkedin.com',
        'social_twitter'   => 'https://twitter.com',
        'show_team'        => true,
        'show_testimonials'=> true,
        'updated_at'       => date('Y-m-d H:i:s')
    ];
    $saved = ck_read_json('settings.json', []);
    return array_merge($defaults, $saved);
}

function ck_save_settings($data) {
    $current = ck_get_settings();
    $allowedKeys = [
        'site_name', 'site_tagline', 'site_email', 'site_phone',
        'site_phone_tel', 'site_phone_alt', 'site_location', 'site_address',
        'working_hours', 'social_linkedin', 'social_twitter', 'show_team', 'show_testimonials'
    ];
    foreach ($allowedKeys as $k) {
        if (isset($data[$k])) {
            if ($k === 'show_team' || $k === 'show_testimonials') {
                $current[$k] = filter_var($data[$k], FILTER_VALIDATE_BOOLEAN);
            } else {
                $current[$k] = trim((string)$data[$k]);
            }
        }
    }
    // Clean telephone string for tel: link
    if (isset($data['site_phone']) && empty($data['site_phone_tel'])) {
        $current['site_phone_tel'] = preg_replace('/[^\d+]/', '', $data['site_phone']);
    }
    $current['updated_at'] = date('Y-m-d H:i:s');
    $savedSettings = ck_write_json('settings.json', $current);
    if ($savedSettings && file_exists(ck_data_path('sections.json'))) {
        $secMap = ck_read_json('sections.json', []);
        $secChanged = false;
        if (isset($data['show_team'])) {
            $secMap['show_team'] = (bool)$current['show_team'];
            $secChanged = true;
        }
        if (isset($data['show_testimonials'])) {
            $secMap['show_testimonials'] = (bool)$current['show_testimonials'];
            $secChanged = true;
        }
        if ($secChanged) {
            ck_write_json('sections.json', $secMap);
            ck_get_section_visibility(true);
        }
    }
    return $savedSettings;
}

/* ==========================================================================
   PAGE SECTION VISIBILITY CONTROLS (HIDE / UNHIDE EVERY WEBSITE SECTION)
   ========================================================================== */

function ck_get_section_registry() {
    return [
        'cyber' => [
            'group_title' => 'Cyber Security Page',
            'group_file'  => 'digital-forensics.php',
            'group_icon'  => '🛡️',
            'group_desc'  => 'Show or hide individual sections on the main Cyber Security landing page.',
            'sections'    => [
                'cyber_hero' => [
                    'label'   => 'Hero Banner & Honeycomb Visual',
                    'desc'    => 'Top headline banner, CTAs, and live attack surface honeycomb animation.',
                    'default' => true,
                ],
                'cyber_about' => [
                    'label'   => 'About Cyber Kovai Section',
                    'desc'    => 'Overview of offensive threat defense and interactive 3D SOC command visual.',
                    'default' => true,
                ],
                'cyber_capabilities' => [
                    'label'   => 'Core Cyber Security Capabilities',
                    'desc'    => '3-pillar capability cards (Offensive VAPT, Cloud Defense, Zero-Trust Architecture).',
                    'default' => true,
                ],
                'cyber_stats' => [
                    'label'   => 'Security Audit Stats Strip',
                    'desc'    => 'Key metrics strip (500+ Audits, 10k+ Vulnerabilities, Zero-False-Positives, etc.).',
                    'default' => true,
                ],
                'cyber_practices' => [
                    'label'   => 'Core Cyber Practices (Bento Grid)',
                    'desc'    => '8 interactive practice cards linking into detailed security services.',
                    'default' => true,
                ],
                'cyber_process' => [
                    'label'   => 'Methodology / Defense Lifecycle',
                    'desc'    => 'Structured step-by-step cyber defense assessment process.',
                    'default' => true,
                ],
                'cyber_industries' => [
                    'label'   => 'Industries We Protect',
                    'desc'    => 'Interactive industry sector selector (Healthcare, Finance, SaaS, Govt, etc.).',
                    'default' => true,
                ],
                'cyber_clients' => [
                    'label'   => 'Clients & Partner Engagements',
                    'desc'    => 'From Startups to Multinationals scale cards and featured partner logos.',
                    'default' => true,
                ],
                'cyber_coverage' => [
                    'label'   => 'Global Reach & Coimbatore Hub',
                    'desc'    => 'Interactive world reach map and global security audit coverage details.',
                    'default' => true,
                ],
                'cyber_credentials' => [
                    'label'   => 'Memberships, Associations & Certifications',
                    'desc'    => 'Accreditation badges and verified industry credential logos.',
                    'default' => true,
                ],
                'cyber_simulator' => [
                    'label'   => 'Cyber Attack Surface Simulator',
                    'desc'    => 'Interactive diagnostic assessment simulator section.',
                    'default' => true,
                ],
                'cyber_faq' => [
                    'label'   => 'Cyber Security FAQs',
                    'desc'    => 'Frequently asked questions accordion for cybersecurity engagements.',
                    'default' => true,
                ],
                'cyber_contact' => [
                    'label'   => 'Consultation CTA & Contact Form',
                    'desc'    => 'Bottom encrypted security audit booking form and direct inquiry section.',
                    'default' => true,
                ],
            ],
        ],
        'investigation' => [
            'group_title' => 'Digital Investigation & Forensics Page',
            'group_file'  => 'cyber-intelligence.php',
            'group_icon'  => '🔍',
            'group_desc'  => 'Show or hide individual sections on the Digital Investigation & Forensics landing page.',
            'sections'    => [
                'inv_hero' => [
                    'label'   => 'Hero Banner & Live Trace Animation',
                    'desc'    => 'Hero headline with typewriter rotator and interactive Live Trace network visual.',
                    'default' => true,
                ],
                'inv_showcase' => [
                    'label'   => 'Core Investigation Pillars Showcase',
                    'desc'    => 'Expandable multi-pillar investigation & forensic matrix panels.',
                    'default' => true,
                ],
                'inv_services' => [
                    'label'   => 'Digital Investigation Practices Grid',
                    'desc'    => 'Service cards grid (BGV, Victim Recovery, OSINT, Fraud Tracing, etc.).',
                    'default' => true,
                ],
                'inv_process' => [
                    'label'   => 'Evidentiary Process Timeline',
                    'desc'    => '5-step chain-of-custody investigation workflow timeline.',
                    'default' => true,
                ],
                'inv_risks' => [
                    'label'   => 'Incidents & Threats 3D Globe',
                    'desc'    => 'Interactive 3D rotating sphere of investigation threat tags.',
                    'default' => true,
                ],
                'inv_credentials' => [
                    'label'   => 'Memberships, Associations & Accreditations',
                    'desc'    => 'Investigative accreditation logos and certified body badges.',
                    'default' => true,
                ],
                'inv_coverage' => [
                    'label'   => 'Global Investigation Footprint Map',
                    'desc'    => 'Interactive dotted world map with regional filters and investigation stats.',
                    'default' => true,
                ],
                'inv_clients' => [
                    'label'   => 'Organizations That Trust CyberKovai (Clients)',
                    'desc'    => 'Partner organizations and institutional investigation engagements deck.',
                    'default' => true,
                ],
                'show_testimonials' => [
                    'label'   => 'Client Case Testimonials',
                    'desc'    => 'Client reviews section on the investigation page and testimonial links in footer.',
                    'default' => true,
                ],
                'inv_faq' => [
                    'label'   => 'Investigation FAQs',
                    'desc'    => 'Frequently asked questions accordion for digital investigations.',
                    'default' => true,
                ],
                'inv_contact' => [
                    'label'   => 'Confidential Investigation CTA & Form',
                    'desc'    => 'Bottom discreet inquiry form and direct investigator contact section.',
                    'default' => true,
                ],
            ],
        ],
        'about' => [
            'group_title' => 'About Us & Leadership Pages',
            'group_file'  => 'about.php / team.php',
            'group_icon'  => '👥',
            'group_desc'  => 'Control visibility of sections on the About Us page and Leadership Team page.',
            'sections'    => [
                'about_hero' => [
                    'label'   => 'About Page Header & Breadcrumb',
                    'desc'    => 'Top page title banner and breadcrumb navigation on about.php.',
                    'default' => true,
                ],
                'about_who_we_are' => [
                    'label'   => 'Who We Are & Overview',
                    'desc'    => 'Company story, mission highlights, and visual card on about.php.',
                    'default' => true,
                ],
                'about_principles' => [
                    'label'   => 'Guiding Principles Section',
                    'desc'    => 'Confidentiality, legal rigor, and ethical investigation principles grid.',
                    'default' => true,
                ],
                'about_cta' => [
                    'label'   => 'About Page Call-to-Action Banner',
                    'desc'    => 'Bottom consultation invitation banner on about.php.',
                    'default' => true,
                ],
                'show_team' => [
                    'label'   => 'Our Team Page & Menu Links',
                    'desc'    => 'Controls /team.php page access plus "Our Team" links in header dropdown and footer.',
                    'default' => true,
                ],
            ],
        ],
        'service_detail' => [
            'group_title' => 'Service Detail Pages',
            'group_file'  => 'service.php / services/*.php',
            'group_icon'  => '📄',
            'group_desc'  => 'Show or hide sections across all individual Cyber Security & Investigation service detail pages.',
            'sections'    => [
                'svc_hero' => [
                    'label'   => 'Service Hero & Summary HUD Card',
                    'desc'    => 'Service headline, trust highlights, preview visual, and audit specs card.',
                    'default' => true,
                ],
                'svc_overview' => [
                    'label'   => 'Executive Summary & Regulatory Compliance',
                    'desc'    => 'Detailed overview, business context box, and compliance standard tags.',
                    'default' => true,
                ],
                'svc_capabilities' => [
                    'label'   => 'Core Capabilities / What We Assess',
                    'desc'    => 'Numbered capability cards detailing what is covered in the engagement.',
                    'default' => true,
                ],
                'svc_methodology' => [
                    'label'   => 'Engagement Methodology Timeline',
                    'desc'    => 'Phased execution timeline for the selected service.',
                    'default' => true,
                ],
                'svc_deliverables' => [
                    'label'   => 'Tangible Deliverables Checklist',
                    'desc'    => 'List of reports, certificates, and evidence packs delivered.',
                    'default' => true,
                ],
                'svc_faqs' => [
                    'label'   => 'Service-Specific FAQs',
                    'desc'    => 'Accordion of common questions specific to the viewed service.',
                    'default' => true,
                ],
                'svc_related' => [
                    'label'   => 'Related Services Grid',
                    'desc'    => 'Cross-linked sibling services from the same practice category.',
                    'default' => true,
                ],
                'svc_booking' => [
                    'label'   => 'Confidential Engagement & Booking Form',
                    'desc'    => 'Bottom proposal request form with trust badges and certification summary.',
                    'default' => true,
                ],
            ],
        ],
        'contact_global' => [
            'group_title' => 'Contact Page & Global Elements',
            'group_file'  => 'contact.php / footer.php',
            'group_icon'  => '🌐',
            'group_desc'  => 'Control sections on the Contact page and global widgets shown across the entire site.',
            'sections'    => [
                'contact_hero' => [
                    'label'   => 'Contact Page Header Banner',
                    'desc'    => 'Top headline banner and breadcrumb on contact.php.',
                    'default' => true,
                ],
                'contact_form_section' => [
                    'label'   => 'Contact Form & Consultation Block',
                    'desc'    => 'Main NDA consultation card and encrypted inquiry form on contact.php.',
                    'default' => true,
                ],
                'global_service_areas' => [
                    'label'   => 'Footer Service Coverage Bar',
                    'desc'    => 'India Hub & Global Delivery location strip shown above the footer bottom bar.',
                    'default' => true,
                ],
                'global_chat_widget' => [
                    'label'   => 'Floating Online Chat Widget',
                    'desc'    => 'Persistent floating Online support pill and welcome popup across all pages.',
                    'default' => true,
                ],
            ],
        ],
    ];
}

function ck_get_section_visibility($forceReload = false) {
    static $cached = null;
    if ($cached !== null && !$forceReload) {
        return $cached;
    }

    $registry = ck_get_section_registry();
    $saved    = ck_read_json('sections.json', []);
    $settings = ck_get_settings();
    $result   = [];

    foreach ($registry as $group) {
        foreach ($group['sections'] as $key => $meta) {
            if ($key === 'show_team' || $key === 'show_testimonials') {
                $val = $settings[$key] ?? ($saved[$key] ?? ($meta['default'] ?? true));
            } else {
                $val = array_key_exists($key, $saved) ? $saved[$key] : ($meta['default'] ?? true);
            }
            $result[$key] = filter_var($val, FILTER_VALIDATE_BOOLEAN);
        }
    }

    $cached = $result;
    return $result;
}

function ck_is_section_visible($key) {
    $visibility = ck_get_section_visibility();
    return array_key_exists($key, $visibility) ? (bool)$visibility[$key] : true;
}

function ck_save_section_visibility($submittedMap) {
    $registry = ck_get_section_registry();
    $current  = ck_get_section_visibility(true);
    $toSave   = [];
    $settingsSync = [];

    foreach ($registry as $group) {
        foreach ($group['sections'] as $key => $meta) {
            if (array_key_exists($key, $submittedMap)) {
                $val = filter_var($submittedMap[$key], FILTER_VALIDATE_BOOLEAN);
            } else {
                $val = $current[$key] ?? ($meta['default'] ?? true);
            }
            $toSave[$key] = (bool)$val;
            if ($key === 'show_team' || $key === 'show_testimonials') {
                $settingsSync[$key] = (bool)$val;
            }
        }
    }

    $toSave['updated_at'] = date('Y-m-d H:i:s');
    $ok = ck_write_json('sections.json', $toSave);

    if ($ok && !empty($settingsSync)) {
        $settingsCurrent = ck_get_settings();
        foreach ($settingsSync as $sk => $sv) {
            $settingsCurrent[$sk] = $sv;
        }
        $settingsCurrent['updated_at'] = date('Y-m-d H:i:s');
        ck_write_json('settings.json', $settingsCurrent);
    }

    ck_get_section_visibility(true);
    return $ok;
}

function ck_set_single_section_visibility($key, $visible) {
    $registry = ck_get_section_registry();
    $valid = false;
    foreach ($registry as $group) {
        if (isset($group['sections'][$key])) {
            $valid = true;
            break;
        }
    }
    if (!$valid) {
        return false;
    }

    $current = ck_get_section_visibility(true);
    $current[$key] = filter_var($visible, FILTER_VALIDATE_BOOLEAN);
    return ck_save_section_visibility($current);
}

/* ==========================================================================
   INVESTIGATION SERVICES CRUD
   ========================================================================== */

function ck_get_investigation_services($includeInactive = true) {
    $services = ck_read_json('investigation_services.json', []);
    if (empty($services)) {
        ck_seed_storage();
        $services = ck_read_json('investigation_services.json', []);
    }
    if (!$includeInactive) {
        $services = array_filter($services, function($s) {
            return !isset($s['status']) || $s['status'] === 'active';
        });
    }
    usort($services, function($a, $b) {
        return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
    });
    return array_values($services);
}

function ck_get_investigation_service($slug) {
    $list = ck_get_investigation_services(true);
    foreach ($list as $s) {
        if (($s['slug'] ?? '') === $slug || ($s['id'] ?? '') === $slug) {
            return $s;
        }
    }
    return null;
}

function ck_save_investigation_service($data, $originalSlug = null) {
    $list = ck_get_investigation_services(true);
    $slug = !empty($data['slug']) ? ck_slugify($data['slug']) : ck_slugify($data['title'] ?? 'investigation-service');

    $record = [
        'id'          => !empty($data['id']) ? (string)$data['id'] : (string)(count($list) + 1),
        'slug'        => $slug,
        'title'       => trim($data['title'] ?? ''),
        'short'       => trim($data['short'] ?? ($data['title'] ?? '')),
        'footer_name' => trim(!empty($data['footer_name']) ? $data['footer_name'] : ($data['short'] ?? ($data['title'] ?? ''))),
        'icon'        => trim($data['icon'] ?? '🛡️'),
        'image'       => trim($data['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg'),
        'description' => trim($data['description'] ?? ''),
        'order'       => isset($data['order']) ? (int)$data['order'] : (count($list) + 1),
        'status'      => $data['status'] ?? 'active',
        'overview'    => trim($data['overview'] ?? ''),
        'updated_at'  => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    $targetLookup = $originalSlug ?: $slug;
    foreach ($list as $i => $item) {
        if (($item['slug'] ?? '') === $targetLookup || ($item['id'] ?? '') === $targetLookup) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $list[] = $record;
    }

    $saved = ck_write_json('investigation_services.json', $list);
    if ($saved) {
        ck_sync_service_file($slug);
        if ($originalSlug && $originalSlug !== $slug) {
            ck_remove_service_file($originalSlug);
        }
    }
    return $saved;
}

function ck_delete_investigation_service($slug) {
    $list = ck_get_investigation_services(true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['slug'] ?? '') === $slug || ($item['id'] ?? '') === $slug) {
            continue;
        }
        $newList[] = $item;
    }
    $saved = ck_write_json('investigation_services.json', $newList);
    if ($saved) {
        ck_remove_service_file($slug);
    }
    return $saved;
}

function ck_toggle_investigation_service_status($slug) {
    $list = ck_get_investigation_services(true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['slug'] ?? '') === $slug || ($item['id'] ?? '') === $slug) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false && ck_write_json('investigation_services.json', $list)) {
        return $newStatus;
    }
    return false;
}

/* ==========================================================================
   INVESTIGATION THREATS & INCIDENT TAGS (WORD CLOUD) CRUD
   ========================================================================== */

function ck_get_investigation_threats($includeInactive = true) {
    $threats = ck_read_json('investigation_threats.json', []);
    if (empty($threats)) {
        ck_seed_storage();
        $threats = ck_read_json('investigation_threats.json', []);
    }
    if (!$includeInactive) {
        $threats = array_filter($threats, function($t) {
            return !isset($t['status']) || $t['status'] === 'active';
        });
    }
    usort($threats, function($a, $b) {
        return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
    });
    return array_values($threats);
}

function ck_get_investigation_threat($id) {
    $list = ck_get_investigation_threats(true);
    foreach ($list as $t) {
        if (($t['id'] ?? '') === (string)$id) {
            return $t;
        }
    }
    return null;
}

function ck_save_investigation_threat($data, $id = null) {
    $list = ck_get_investigation_threats(true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : null);

    if (!$id) {
        $maxId = 0;
        foreach ($list as $item) {
            if (is_numeric($item['id'] ?? null)) {
                $maxId = max($maxId, (int)$item['id']);
            }
        }
        $id = (string)($maxId + 1);
    }

    $validSizes = ['xl', 'lg', 'md', 'sm'];
    $validAccents = ['purple', 'cyan', 'emerald', 'amber', 'rose'];

    $size   = in_array($data['size'] ?? '', $validSizes, true) ? $data['size'] : 'md';
    $accent = in_array($data['accent'] ?? '', $validAccents, true) ? $data['accent'] : 'purple';
    $status = in_array($data['status'] ?? '', ['active', 'inactive'], true) ? $data['status'] : 'active';
    $order  = isset($data['order']) && $data['order'] !== '' ? (int)$data['order'] : (count($list) + 1);

    $record = [
        'id'         => (string)$id,
        'text'       => trim($data['text'] ?? ''),
        'size'       => $size,
        'accent'     => $accent,
        'order'      => $order,
        'status'     => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $record['created_at'] = $list[$foundIndex]['created_at'] ?? date('Y-m-d H:i:s');
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $record['created_at'] = date('Y-m-d H:i:s');
        $list[] = $record;
    }

    return ck_write_json('investigation_threats.json', $list);
}

function ck_delete_investigation_threat($id) {
    $list = ck_get_investigation_threats(true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        $newList[] = $item;
    }
    return ck_write_json('investigation_threats.json', $newList);
}

function ck_toggle_investigation_threat_status($id) {
    $list = ck_get_investigation_threats(true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false && ck_write_json('investigation_threats.json', $list)) {
        return $newStatus;
    }
    return false;
}

/* ==========================================================================
   CORE CYBER PRACTICES CRUD (BENTO GRID)
   ========================================================================== */

function ck_get_cyber_practices_settings() {
    $defaults = [
        'tag'      => 'OUR PRACTICES',
        'title'    => 'Core Cyber Practices. One Standard: <span>Uncompromising Defense.</span>',
        'subtitle' => 'Comprehensive offensive and defensive cybersecurity practices engineered for modern digital enterprises.'
    ];
    $saved = ck_read_json('cyber_practices_settings.json', []);
    return array_merge($defaults, $saved);
}

function ck_save_cyber_practices_settings($settings) {
    $current = ck_get_cyber_practices_settings();
    $updated = [
        'tag'        => trim($settings['tag'] ?? $current['tag']),
        'title'      => trim($settings['title'] ?? $current['title']),
        'subtitle'   => trim($settings['subtitle'] ?? $current['subtitle']),
        'updated_at' => date('Y-m-d H:i:s')
    ];
    return ck_write_json('cyber_practices_settings.json', $updated);
}

function ck_get_cyber_practices($includeInactive = true) {
    $practices = ck_read_json('cyber_practices.json', []);
    if (empty($practices)) {
        $practices = [
            ['id' => '1', 'code' => '01', 'title' => 'Vulnerability Assessment & Pen Testing (VAPT)', 'slug' => 'vulnerability-assessment-penetration-testing', 'link' => 'services/vulnerability-assessment-penetration-testing.php', 'tag' => '// APPSEC-01', 'badge' => 'PRIMARY PRACTICE', 'status_text' => 'ARMORED', 'icon' => '🛡️', 'is_hero' => true, 'order' => 1, 'status' => 'active', 'description' => 'Simulate real-world attacks across web applications, APIs, mobile apps, and systems to uncover exploitable flaws before adversaries do.'],
            ['id' => '2', 'code' => '02', 'title' => 'Network & Wireless Penetration Testing', 'slug' => 'network-penetration-testing', 'link' => 'services/network-penetration-testing.php', 'tag' => '// NETSEC-02', 'badge' => '', 'status_text' => 'ARMORED', 'icon' => '🌐', 'is_hero' => false, 'order' => 2, 'status' => 'active', 'description' => 'Comprehensive perimeter and internal network auditing, firewall rulebase evaluations, and rogue wireless access point testing.'],
            ['id' => '3', 'code' => '03', 'title' => 'Cloud Security & Posture Management (CSPM)', 'slug' => 'cloud-configuration-review', 'link' => 'services/cloud-configuration-review.php', 'tag' => '// CLOUD-03', 'badge' => '', 'status_text' => 'ARMORED', 'icon' => '☁️', 'is_hero' => false, 'order' => 3, 'status' => 'active', 'description' => 'Audit AWS, Azure, and GCP architectures for misconfigurations, excessive IAM privileges, CASA compliance, and container vulnerabilities.'],
            ['id' => '4', 'code' => '04', 'title' => 'Virtual CISO (vCISO) & Executive Advisory', 'slug' => 'virtual-ciso-services', 'link' => 'services/virtual-ciso-services.php', 'tag' => '// ENTPR-04', 'badge' => 'PRIMARY PRACTICE', 'status_text' => 'ARMORED', 'icon' => '👔', 'is_hero' => true, 'order' => 4, 'status' => 'active', 'description' => 'Strategic cybersecurity leadership, governance, vendor risk management, and regulatory alignment with ISO 27001, SOC 2, and NIST.'],
            ['id' => '5', 'code' => '05', 'title' => 'REST & GraphQL API Security Testing', 'slug' => 'api-penetration-testing', 'link' => 'services/api-penetration-testing.php', 'tag' => '// APISEC-05', 'badge' => '', 'status_text' => 'ARMORED', 'icon' => '⚡', 'is_hero' => false, 'order' => 5, 'status' => 'active', 'description' => 'Deep technical auditing for OWASP API Security Top 10 vulnerabilities, broken authentication, rate-limiting flaws, and mass assignment.'],
            ['id' => '6', 'code' => '06', 'title' => 'Secure Source Code Review (SAST/DAST)', 'slug' => 'secure-source-code-review', 'link' => 'services/secure-source-code-review.php', 'tag' => '// DEVSEC-06', 'badge' => '', 'status_text' => 'ARMORED', 'icon' => '💻', 'is_hero' => false, 'order' => 6, 'status' => 'active', 'description' => 'Automated and manual line-by-line static analysis to identify hidden backdoors, cryptographic bugs, and code injection vulnerabilities.'],
            ['id' => '7', 'code' => '07', 'title' => 'Zero-Trust Architecture & Threat Hardening', 'slug' => 'security-architecture-review', 'link' => 'services/security-architecture-review.php', 'tag' => '// ZEROTRUST-07', 'badge' => '', 'status_text' => 'ARMORED', 'icon' => '🔒', 'is_hero' => false, 'order' => 7, 'status' => 'active', 'description' => 'Enterprise identity defense, Microsoft 365 hardening, network segmentation, and micro-perimeter security to stop ransomware spread.'],
            ['id' => '8', 'code' => '08', 'title' => 'AI Security & LLM Red Teaming', 'slug' => 'ai-security', 'link' => 'services/ai-security.php', 'tag' => '// AISEC-08', 'badge' => 'AI DEFENSE PRACTICE', 'status_text' => 'ARMORED', 'icon' => '🤖', 'is_hero' => true, 'order' => 8, 'status' => 'active', 'description' => 'Adversarial prompt injection testing, RAG pipeline defense, model weight integrity, and LLM guardrail auditing to secure enterprise AI.']
        ];
        ck_write_json('cyber_practices.json', $practices);
    }

    if (!$includeInactive) {
        $practices = array_filter($practices, function($p) {
            return !isset($p['status']) || $p['status'] === 'active';
        });
    }

    usort($practices, function($a, $b) {
        return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
    });

    return array_values($practices);
}

function ck_get_cyber_practice($id) {
    $list = ck_get_cyber_practices(true);
    foreach ($list as $p) {
        if (($p['id'] ?? '') === (string)$id) {
            return $p;
        }
    }
    return null;
}

function ck_save_cyber_practice($data, $id = null) {
    $list = ck_get_cyber_practices(true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : null);

    if (!$id) {
        $maxId = 0;
        foreach ($list as $item) {
            if (is_numeric($item['id'] ?? null)) {
                $maxId = max($maxId, (int)$item['id']);
            }
        }
        $id = (string)($maxId + 1);
    }

    $title = trim($data['title'] ?? '');
    $slug  = !empty($data['slug']) ? ck_slugify($data['slug']) : ck_slugify($title);
    $code  = !empty($data['code']) ? trim($data['code']) : sprintf('%02d', (int)$id);
    $order = isset($data['order']) && $data['order'] !== '' ? (int)$data['order'] : (count($list) + 1);
    $tag   = !empty($data['tag']) ? trim($data['tag']) : ('// ' . strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $slug), 0, 6)) . '-' . $code);
    $link  = !empty($data['link']) ? trim($data['link']) : ('services/' . $slug . '.php');
    $badge = trim($data['badge'] ?? '');
    $statusText = !empty($data['status_text']) ? trim($data['status_text']) : 'ARMORED';
    $icon  = trim($data['icon'] ?? '🛡️');
    $isHero = filter_var($data['is_hero'] ?? false, FILTER_VALIDATE_BOOLEAN);
    $status = in_array($data['status'] ?? '', ['active', 'inactive'], true) ? $data['status'] : 'active';
    $desc  = trim($data['description'] ?? '');

    $record = [
        'id'          => (string)$id,
        'code'        => $code,
        'title'       => $title,
        'slug'        => $slug,
        'link'        => $link,
        'tag'         => $tag,
        'badge'       => $badge,
        'status_text' => $statusText,
        'icon'        => $icon,
        'is_hero'     => $isHero,
        'order'       => $order,
        'status'      => $status,
        'description' => $desc,
        'updated_at'  => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $record['created_at'] = $list[$foundIndex]['created_at'] ?? date('Y-m-d H:i:s');
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $record['created_at'] = date('Y-m-d H:i:s');
        $list[] = $record;
    }

    return ck_write_json('cyber_practices.json', $list);
}

function ck_delete_cyber_practice($id) {
    $list = ck_get_cyber_practices(true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        $newList[] = $item;
    }
    return ck_write_json('cyber_practices.json', $newList);
}

function ck_toggle_cyber_practice_status($id) {
    $list = ck_get_cyber_practices(true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false && ck_write_json('cyber_practices.json', $list)) {
        return $newStatus;
    }
    return false;
}

/* ==========================================================================
   CYBER SERVICES CRUD & CATEGORIES
   ========================================================================== */

function ck_get_cyber_categories() {
    $defaults = [
        'application-security' => [
            'name'       => 'Application Security',
            'column'     => 1,
            'order'      => 1,
            'badge'      => 'APPSEC & CODE ASSURANCE',
            'icon'       => '🛡️',
            'short_desc' => 'Comprehensive vulnerability assessments, penetration tests, and secure architecture for modern web, mobile, and API platforms.'
        ],
        'network-security' => [
            'name'       => 'Network Security',
            'column'     => 2,
            'order'      => 2,
            'badge'      => 'INFRASTRUCTURE & PERIMETER',
            'icon'       => '🌐',
            'short_desc' => 'Securing corporate network perimeters, wireless topologies, firewall configs, and routing appliances.'
        ],
        'cloud-security' => [
            'name'       => 'Cloud Security',
            'column'     => 3,
            'order'      => 3,
            'badge'      => 'CLOUD & CONTAINER SECURITY',
            'icon'       => '☁️',
            'short_desc' => 'Multi-cloud architecture auditing, CASA compliance, Kubernetes container security, and server hardening across AWS, GCP, and Azure.'
        ],
        'enterprise-security' => [
            'name'       => 'Enterprise Security',
            'column'     => 4,
            'order'      => 4,
            'badge'      => 'ORGANIZATIONAL RESILIENCE',
            'icon'       => '🏢',
            'short_desc' => 'Virtual CISO advisory, black box simulations, Microsoft 365 hardening, ERP audits, and zero-trust security architecture.'
        ]
    ];
    $saved = ck_read_json('cyber_categories.json', []);
    return !empty($saved) ? $saved : $defaults;
}

function ck_save_cyber_categories($categories) {
    return ck_write_json('cyber_categories.json', $categories);
}

function ck_get_cyber_services($includeInactive = true) {
    $services = ck_read_json('cyber_services.json', []);
    if (empty($services)) {
        ck_seed_storage();
        $services = ck_read_json('cyber_services.json', []);
    }
    if (!$includeInactive) {
        $filtered = [];
        foreach ($services as $slug => $s) {
            if (!isset($s['status']) || $s['status'] === 'active') {
                $filtered[$slug] = $s;
            }
        }
        return $filtered;
    }
    return $services;
}

function ck_get_cyber_service($slug) {
    $all = ck_get_cyber_services(true);
    return $all[$slug] ?? null;
}

function ck_save_cyber_service($data, $originalSlug = null) {
    $all = ck_get_cyber_services(true);
    $slug = !empty($data['slug']) ? ck_slugify($data['slug']) : ck_slugify($data['title'] ?? 'cyber-service');

    $existing = ($originalSlug && isset($all[$originalSlug])) ? $all[$originalSlug] : [];

    // Parse key features if submitted as string or array
    $keyFeatures = [];
    if (!empty($data['key_features'])) {
        if (is_array($data['key_features'])) {
            $keyFeatures = $data['key_features'];
        } else {
            $lines = explode("\n", (string)$data['key_features']);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '') continue;
                if (strpos($line, ':') !== false) {
                    [$t, $d] = explode(':', $line, 2);
                    $keyFeatures[] = ['title' => trim($t), 'desc' => trim($d)];
                } else {
                    $keyFeatures[] = ['title' => $line, 'desc' => ''];
                }
            }
        }
    } elseif (!empty($existing['key_features'])) {
        $keyFeatures = $existing['key_features'];
    }

    // Parse deliverables
    $deliverables = [];
    if (!empty($data['deliverables'])) {
        if (is_array($data['deliverables'])) {
            $deliverables = $data['deliverables'];
        } else {
            $delivLines = explode("\n", (string)$data['deliverables']);
            foreach ($delivLines as $dl) {
                $dl = trim($dl);
                if ($dl !== '') $deliverables[] = $dl;
            }
        }
    } elseif (!empty($existing['deliverables'])) {
        $deliverables = $existing['deliverables'];
    }

    $serviceRecord = [
        'title'        => trim($data['title'] ?? ($existing['title'] ?? '')),
        'nav_label'    => trim($data['nav_label'] ?? ($existing['nav_label'] ?? ($data['title'] ?? ''))),
        'footer_name'  => trim($data['footer_name'] ?? ($existing['footer_name'] ?? ($data['nav_label'] ?? ($data['title'] ?? '')))),
        'category'     => trim($data['category'] ?? ($existing['category'] ?? 'application-security')),
        'badge'        => trim($data['badge'] ?? ($existing['badge'] ?? '')),
        'tagline'      => trim($data['tagline'] ?? ($existing['tagline'] ?? '')),
        'short_desc'   => trim($data['short_desc'] ?? ($existing['short_desc'] ?? '')),
        'overview'     => trim($data['overview'] ?? ($existing['overview'] ?? '')),
        'why_needed'   => trim($data['why_needed'] ?? ($existing['why_needed'] ?? '')),
        'icon'         => trim($data['icon'] ?? ($existing['icon'] ?? '🛡️')),
        'image'        => trim($data['image'] ?? ($existing['image'] ?? '')),
        'key_features' => $keyFeatures,
        'deliverables' => $deliverables,
        'methodology'  => $existing['methodology'] ?? [],
        'faqs'         => $existing['faqs'] ?? [],
        'status'       => $data['status'] ?? ($existing['status'] ?? 'active'),
        'updated_at'   => date('Y-m-d H:i:s')
    ];

    if ($originalSlug && $originalSlug !== $slug) {
        unset($all[$originalSlug]);
        ck_remove_service_file($originalSlug);
    }

    $all[$slug] = $serviceRecord;

    $saved = ck_write_json('cyber_services.json', $all);
    if ($saved) {
        ck_sync_service_file($slug);
    }
    return $saved;
}

function ck_delete_cyber_service($slug) {
    $all = ck_get_cyber_services(true);
    if (isset($all[$slug])) {
        unset($all[$slug]);
        $saved = ck_write_json('cyber_services.json', $all);
        if ($saved) {
            ck_remove_service_file($slug);
        }
        return $saved;
    }
    return false;
}

/* ==========================================================================
   TESTIMONIALS CRUD
   ========================================================================== */

function ck_get_testimonials($includeInactive = true) {
    $testimonials = ck_read_json('testimonials.json', []);
    if (empty($testimonials)) {
        ck_seed_storage();
        $testimonials = ck_read_json('testimonials.json', []);
    }
    if (!$includeInactive) {
        $testimonials = array_filter($testimonials, function($t) {
            return !isset($t['status']) || $t['status'] === 'active';
        });
    }
    return array_values($testimonials);
}

function ck_get_testimonial($id) {
    $all = ck_get_testimonials(true);
    foreach ($all as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            return $item;
        }
    }
    return null;
}

function ck_save_testimonial($data, $id = null) {
    $list = ck_get_testimonials(true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : 'testi_' . time());

    $record = [
        'id'         => $id,
        'name'       => trim($data['name'] ?? ''),
        'role'       => trim($data['role'] ?? ''),
        'quote'      => trim($data['quote'] ?? ''),
        'avatar'     => trim($data['avatar'] ?? 'assets/images/avatar_karthik.jpg'),
        'rating'     => isset($data['rating']) ? (int)$data['rating'] : 5,
        'tag'        => trim($data['tag'] ?? 'Digital Investigation'),
        'status'     => $data['status'] ?? 'active',
        'order'      => isset($data['order']) ? (int)$data['order'] : 0,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === $id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $list[] = $record;
    }

    return ck_write_json('testimonials.json', $list);
}

function ck_delete_testimonial($id) {
    $list = ck_get_testimonials(true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        $newList[] = $item;
    }
    return ck_write_json('testimonials.json', $newList);
}

function ck_toggle_testimonial_status($id) {
    $list = ck_get_testimonials(true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false && ck_write_json('testimonials.json', $list)) {
        return $newStatus;
    }
    return false;
}

/* ==========================================================================
   CLIENTS & PARTNER ENGAGEMENTS CRUD
   ========================================================================== */

function ck_get_clients($track = 'all', $includeInactive = true) {
    $clients = ck_read_json('clients.json', []);
    if (empty($clients)) {
        ck_seed_storage();
        $clients = ck_read_json('clients.json', []);
    }

    if ($track !== 'all') {
        $clients = array_filter($clients, function($c) use ($track) {
            $cTrack = $c['track'] ?? 'both';
            return ($cTrack === $track || $cTrack === 'both');
        });
    }

    if (!$includeInactive) {
        $clients = array_filter($clients, function($c) {
            return !isset($c['status']) || $c['status'] === 'active';
        });
    }

    usort($clients, function($a, $b) {
        return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
    });

    return array_values($clients);
}

function ck_get_client($id) {
    $all = ck_get_clients('all', true);
    foreach ($all as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            return $item;
        }
    }
    return null;
}

function ck_save_client($data, $id = null) {
    $list = ck_get_clients('all', true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : 'client_' . time() . '_' . substr(md5(uniqid('', true)), 0, 4));

    $record = [
        'id'         => $id,
        'name'       => trim($data['name'] ?? ''),
        'category'   => trim($data['category'] ?? 'Enterprise Partner'),
        'desc'       => trim($data['desc'] ?? ''),
        'img'        => trim($data['img'] ?? 'assets/images/client_copconnect.jpg'),
        'alt'        => trim($data['alt'] ?? (!empty($data['name']) ? $data['name'] : 'Client Logo')),
        'website'    => trim($data['website'] ?? ''),
        'track'      => in_array($data['track'] ?? '', ['investigation', 'cyber', 'both'], true) ? $data['track'] : 'both',
        'order'      => isset($data['order']) ? (int)$data['order'] : 1,
        'status'     => ($data['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active',
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === $id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $record['created_at'] = date('Y-m-d H:i:s');
        $list[] = $record;
    }

    return ck_write_json('clients.json', $list);
}

function ck_delete_client($id) {
    $list = ck_get_clients('all', true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        $newList[] = $item;
    }
    return ck_write_json('clients.json', $newList);
}

function ck_toggle_client_status($id) {
    $list = ck_get_clients('all', true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false && ck_write_json('clients.json', $list)) {
        return $newStatus;
    }
    return false;
}

/* ==========================================================================
   ACCREDITATIONS, ASSOCIATIONS & MEMBERSHIPS CRUD
   ========================================================================== */

function ck_get_accreditations($track = 'all', $includeInactive = true) {
    $accreds = ck_read_json('accreditations.json', []);
    if (empty($accreds)) {
        ck_seed_storage();
        $accreds = ck_read_json('accreditations.json', []);
    }

    if ($track !== 'all') {
        $accreds = array_filter($accreds, function($a) use ($track) {
            $aTrack = $a['track'] ?? 'both';
            return ($aTrack === $track || $aTrack === 'both');
        });
    }

    if (!$includeInactive) {
        $accreds = array_filter($accreds, function($a) {
            return !isset($a['status']) || $a['status'] === 'active';
        });
    }

    usort($accreds, function($a, $b) {
        return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
    });

    return array_values($accreds);
}

function ck_get_accreditation($id) {
    $all = ck_get_accreditations('all', true);
    foreach ($all as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            return $item;
        }
    }
    return null;
}

function ck_save_accreditation($data, $id = null) {
    $list = ck_get_accreditations('all', true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : 'accred_' . time() . '_' . substr(md5(uniqid('', true)), 0, 4));

    $record = [
        'id'         => $id,
        'name'       => trim($data['name'] ?? ''),
        'short_name' => trim($data['short_name'] ?? ''),
        'img'        => trim($data['img'] ?? 'assets/images/aid.png'),
        'alt'        => trim($data['alt'] ?? (!empty($data['short_name']) ? ($data['short_name'] . ' - ' . ($data['name'] ?? '')) : ($data['name'] ?? 'Accreditation Badge'))),
        'website'    => trim($data['website'] ?? ''),
        'track'      => in_array($data['track'] ?? '', ['investigation', 'cyber', 'both'], true) ? $data['track'] : 'both',
        'order'      => isset($data['order']) ? (int)$data['order'] : 1,
        'status'     => ($data['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active',
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === $id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $record['created_at'] = date('Y-m-d H:i:s');
        $list[] = $record;
    }

    return ck_write_json('accreditations.json', $list);
}

function ck_delete_accreditation($id) {
    $list = ck_get_accreditations('all', true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        $newList[] = $item;
    }
    return ck_write_json('accreditations.json', $newList);
}

function ck_toggle_accreditation_status($id) {
    $list = ck_get_accreditations('all', true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false && ck_write_json('accreditations.json', $list)) {
        return $newStatus;
    }
    return false;
}

/* ==========================================================================
   OUR TEAM CRUD
   ========================================================================== */

function ck_get_team_members($includeInactive = true) {
    $members = ck_read_json('team.json', []);
    if (empty($members)) {
        ck_seed_storage();
        $members = ck_read_json('team.json', []);
    }
    if (!$includeInactive) {
        $members = array_filter($members, function($m) {
            return !isset($m['status']) || $m['status'] === 'active';
        });
    }
    // Sort by order ascending
    usort($members, function($a, $b) {
        return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
    });
    return array_values($members);
}

function ck_get_team_member($id) {
    $all = ck_get_team_members(true);
    foreach ($all as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            return $item;
        }
    }
    return null;
}

function ck_save_team_member($data, $id = null) {
    $list = ck_get_team_members(true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : 'team_' . time());

    // Parse specializations tags
    $specs = [];
    if (!empty($data['specializations'])) {
        if (is_array($data['specializations'])) {
            $specs = $data['specializations'];
        } else {
            $rawSpecs = explode(',', (string)$data['specializations']);
            foreach ($rawSpecs as $s) {
                $s = trim($s);
                if ($s !== '') $specs[] = $s;
            }
        }
    }

    // Parse domain capabilities
    $domains = [];
    if (!empty($data['domains'])) {
        if (is_array($data['domains'])) {
            $domains = $data['domains'];
        }
    }

    $record = [
        'id'              => $id,
        'name'            => trim($data['name'] ?? ''),
        'role'            => trim($data['role'] ?? ''),
        'company'         => trim($data['company'] ?? 'Cyber Kovai'),
        'experience'      => trim($data['experience'] ?? '10+'),
        'badge'           => trim($data['badge'] ?? 'Verified Security Leader'),
        'photo'           => trim($data['photo'] ?? 'assets/images/arun_s.png'),
        'specializations' => $specs,
        'bio'             => trim($data['bio'] ?? ''),
        'domains'         => $domains,
        'order'           => isset($data['order']) ? (int)$data['order'] : count($list) + 1,
        'status'          => $data['status'] ?? 'active',
        'updated_at'      => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === $id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $list[] = $record;
    }

    return ck_write_json('team.json', $list);
}

function ck_delete_team_member($id) {
    $list = ck_get_team_members(true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        $newList[] = $item;
    }
    return ck_write_json('team.json', $newList);
}

/* ==========================================================================
   FREQUENTLY ASKED QUESTIONS (FAQS) CRUD - CYBER & INVESTIGATION
   ========================================================================== */

function ck_get_faqs($track = 'all', $includeInactive = true) {
    $faqs = ck_read_json('faqs.json', []);
    if (empty($faqs)) {
        ck_seed_storage();
        $faqs = ck_read_json('faqs.json', []);
    }

    if ($track !== 'all') {
        $faqs = array_filter($faqs, function($f) use ($track) {
            $fTrack = $f['track'] ?? 'both';
            return ($fTrack === $track || $fTrack === 'both');
        });
    }

    if (!$includeInactive) {
        $faqs = array_filter($faqs, function($f) {
            return !isset($f['status']) || $f['status'] === 'active';
        });
    }

    usort($faqs, function($a, $b) {
        return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
    });

    // Normalize keys so templates can use both $f['question'] / $f['answer'] and $f['q'] / $f['a']
    $normalized = [];
    foreach ($faqs as $f) {
        $q = $f['question'] ?? ($f['q'] ?? '');
        $a = $f['answer'] ?? ($f['a'] ?? '');
        $f['question'] = $q;
        $f['answer']   = $a;
        $f['q']        = $q;
        $f['a']        = $a;
        $normalized[]  = $f;
    }

    return $normalized;
}

function ck_get_faq($id) {
    $list = ck_get_faqs('all', true);
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            return $item;
        }
    }
    return null;
}

function ck_save_faq($data, $id = null) {
    $list = ck_get_faqs('all', true);
    $id = !empty($id) ? (string)$id : (!empty($data['id']) ? (string)$data['id'] : null);

    $track = in_array($data['track'] ?? '', ['investigation', 'cyber', 'both'], true) ? $data['track'] : 'investigation';

    if (!$id) {
        $prefix = $track === 'cyber' ? 'faq-cyb-' : ($track === 'both' ? 'faq-both-' : 'faq-inv-');
        $id = $prefix . time() . '-' . substr(md5(uniqid('', true)), 0, 4);
    }

    $question = trim($data['question'] ?? ($data['q'] ?? ''));
    $answer   = trim($data['answer'] ?? ($data['a'] ?? ''));
    $category = trim($data['category'] ?? 'General');
    $status   = ($data['status'] ?? 'active') === 'inactive' ? 'inactive' : 'active';
    $order    = isset($data['order']) && $data['order'] !== '' ? (int)$data['order'] : (count($list) + 1);

    $record = [
        'id'         => (string)$id,
        'track'      => $track,
        'question'   => $question,
        'answer'     => $answer,
        'category'   => $category,
        'order'      => $order,
        'status'     => $status,
        'updated_at' => date('Y-m-d H:i:s')
    ];

    $foundIndex = -1;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $foundIndex = $i;
            break;
        }
    }

    if ($foundIndex >= 0) {
        $record['created_at'] = $list[$foundIndex]['created_at'] ?? date('Y-m-d H:i:s');
        $list[$foundIndex] = array_merge($list[$foundIndex], $record);
    } else {
        $record['created_at'] = date('Y-m-d H:i:s');
        $list[] = $record;
    }

    $cleanList = [];
    foreach ($list as $item) {
        unset($item['q'], $item['a']);
        $cleanList[] = $item;
    }

    return ck_write_json('faqs.json', $cleanList);
}

function ck_delete_faq($id) {
    $list = ck_get_faqs('all', true);
    $newList = [];
    foreach ($list as $item) {
        if (($item['id'] ?? '') === (string)$id) {
            continue;
        }
        unset($item['q'], $item['a']);
        $newList[] = $item;
    }
    return ck_write_json('faqs.json', $newList);
}

function ck_toggle_faq_status($id) {
    $list = ck_get_faqs('all', true);
    $newStatus = false;
    foreach ($list as $i => $item) {
        if (($item['id'] ?? '') === (string)$id) {
            $curStatus = $item['status'] ?? 'active';
            $newStatus = ($curStatus === 'active') ? 'inactive' : 'active';
            $list[$i]['status'] = $newStatus;
            $list[$i]['updated_at'] = date('Y-m-d H:i:s');
            break;
        }
    }
    if ($newStatus !== false) {
        $cleanList = [];
        foreach ($list as $item) {
            unset($item['q'], $item['a']);
            $cleanList[] = $item;
        }
        if (ck_write_json('faqs.json', $cleanList)) {
            return $newStatus;
        }
    }
    return false;
}

/* ==========================================================================
   ADMIN AUTHENTICATION & MANAGEMENT
   ========================================================================== */

function ck_get_admins() {
    $admins = ck_read_json('admins.json', []);
    if (empty($admins)) {
        ck_seed_storage();
        $admins = ck_read_json('admins.json', []);
    }
    return $admins;
}

function ck_verify_admin($username, $password) {
    $admins = ck_get_admins();
    $username = trim($username);
    $found = null;
    if (isset($admins[$username])) {
        $found = $admins[$username];
    } else {
        foreach ($admins as $u => $a) {
            if (strcasecmp($u, $username) === 0 || (!empty($a['email']) && strcasecmp($a['email'], $username) === 0) || (!empty($a['username']) && strcasecmp($a['username'], $username) === 0)) {
                $found = $a;
                break;
            }
        }
    }
    if ($found && password_verify($password, $found['password_hash'])) {
        return $found;
    }
    return false;
}

function ck_update_admin_profile($currentUsername, $newUsername, $email, $newPassword = null) {
    $admins = ck_get_admins();
    if (!isset($admins[$currentUsername])) {
        return ['success' => false, 'error' => 'Admin user not found.'];
    }

    $admin = $admins[$currentUsername];
    $newUsername = trim($newUsername);
    $email = trim($email);

    if ($newUsername === '') {
        return ['success' => false, 'error' => 'Username cannot be empty.'];
    }

    if ($newUsername !== $currentUsername && isset($admins[$newUsername])) {
        return ['success' => false, 'error' => 'Username already taken.'];
    }

    // Create backup of admins.json before modifying credentials
    $adminsPath = ck_data_path('admins.json');
    if (file_exists($adminsPath) && class_exists('\\CyberKovai\\Security\\TwoFactorStorage')) {
        $backupDir = \CyberKovai\Security\TwoFactorStorage::resolveStorageDirectory() . DIRECTORY_SEPARATOR . 'backups';
        \CyberKovai\Security\TwoFactorStorage::ensureDirectory($backupDir);
        $rawAdmins = @file_get_contents($adminsPath);
        if ($rawAdmins !== false) {
            \CyberKovai\Security\TwoFactorStorage::atomicWriteFile(
                $backupDir . DIRECTORY_SEPARATOR . 'admins_' . gmdate('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.json',
                $rawAdmins
            );
        }
    }

    $admin['username'] = $newUsername;
    $admin['email'] = $email;
    if (!empty($newPassword)) {
        if (strlen($newPassword) < 8) {
            return ['success' => false, 'error' => 'Password must be at least 8 characters long.'];
        }
        $admin['password_hash'] = password_hash($newPassword, PASSWORD_DEFAULT);
    }
    $admin['updated_at'] = date('Y-m-d H:i:s');

    if ($newUsername !== $currentUsername) {
        unset($admins[$currentUsername]);
    }
    $admins[$newUsername] = $admin;

    $saved = ck_write_json('admins.json', $admins);

    if ($saved && $newUsername !== $currentUsername && class_exists('\\CyberKovai\\Security\\TwoFactorStorage')) {
        $twoFaStorage = new \CyberKovai\Security\TwoFactorStorage();
        $existing2fa = $twoFaStorage->getRecord($currentUsername);
        if ($existing2fa !== null) {
            $twoFaStorage->migrateAdminIdentifier(
                $currentUsername,
                $newUsername,
                new \CyberKovai\Security\CryptoService()
            );
        }
    }

    return ['success' => $saved, 'user' => $admin];
}

/* ==========================================================================
   STORAGE AUTO-SEEDER
   Seeds files from existing application data if files are not yet created.
   ========================================================================== */

function ck_seed_storage() {
    static $seeding = false;
    if ($seeding) {
        return;
    }
    $seeding = true;
    try {
    if (!is_dir(CK_DATA_DIR)) {
        @mkdir(CK_DATA_DIR, 0755, true);
    }
    if (!is_dir(CK_UPLOADS_DIR)) {
        @mkdir(CK_UPLOADS_DIR, 0755, true);
    }

    // 1. Settings Seeding
    if (!file_exists(ck_data_path('settings.json'))) {
        $settings = [
            'site_name'       => 'Cyber Kovai',
            'site_tagline'    => 'Verified Facts, Confident Decisions.',
            'site_email'      => 'info@cyberkovai.com',
            'site_phone'      => '+91 63820 19821',
            'site_phone_tel'  => '+916382019821',
            'site_phone_alt'  => '+91 98765 43210',
            'site_location'   => 'Coimbatore, Tamil Nadu, India',
            'site_address'    => 'Cyber Kovai Intelligence & Forensics Center, Coimbatore, Tamil Nadu, India',
            'working_hours'   => '24/7 Incident Response & Emergency Forensics',
            'social_linkedin' => 'https://linkedin.com',
            'social_twitter'  => 'https://twitter.com',
            'created_at'      => date('Y-m-d H:i:s')
        ];
        ck_write_json('settings.json', $settings);
    }

    // 2. Admins Seeding (Initial Superadmin Account)
    if (!file_exists(ck_data_path('admins.json'))) {
        $admins = [
            'Kovaicyber@gmail.com' => [
                'username'      => 'Kovaicyber@gmail.com',
                'name'          => 'Cyber Kovai Administrator',
                'email'         => 'Kovaicyber@gmail.com',
                'password_hash' => password_hash('Admin@CyberKovai2026!', PASSWORD_DEFAULT),
                'role'          => 'superadmin',
                'created_at'    => date('Y-m-d H:i:s')
            ]
        ];
        ck_write_json('admins.json', $admins);
    }

    // 3. Testimonials Seeding
    if (!file_exists(ck_data_path('testimonials.json'))) {
        $testimonials = [
            [
                'id'     => 'testi-1',
                'quote'  => "CyberKovai's digital forensics team recovered critical deleted evidence and provided an airtight forensic report that proved decisive in our corporate litigation. Exceptional discretion and technical precision.",
                'name'   => 'Rajesh M.',
                'role'   => 'Managing Partner, Legal Advisory',
                'avatar' => 'assets/images/avatar_karthik.jpg',
                'rating' => 5,
                'tag'    => 'Digital Forensics',
                'status' => 'active',
                'order'  => 1
            ],
            [
                'id'     => 'testi-2',
                'quote'  => 'Their cyber fraud tracing and blockchain analysis uncovered the illicit movement of funds after our firm suffered a major financial wire fraud. The dossier provided to law enforcement led directly to key recoveries.',
                'name'   => 'Priya S.',
                'role'   => 'Chief Financial Officer, Enterprise Logistics',
                'avatar' => 'assets/images/avatar_priya.jpg',
                'rating' => 5,
                'tag'    => 'Cyber Fraud Tracing',
                'status' => 'active',
                'order'  => 2
            ],
            [
                'id'     => 'testi-3',
                'quote'  => 'We faced an aggressive online harassment and executive impersonation campaign. CyberKovai identified the perpetrators through OSINT within 72 hours and facilitated swift platform takedowns.',
                'name'   => 'Aravind K.',
                'role'   => 'VP Operations & Corporate Affairs',
                'avatar' => 'assets/images/avatar_aravind.jpg',
                'rating' => 5,
                'tag'    => 'OSINT & Brand Defense',
                'status' => 'active',
                'order'  => 3
            ]
        ];
        ck_write_json('testimonials.json', $testimonials);
    }

    // 4. Team Seeding
    if (!file_exists(ck_data_path('team.json'))) {
        $team = [
            [
                'id'              => 'team-1',
                'name'            => 'Arun S',
                'role'            => 'Principal Security Architect',
                'company'         => 'IBM India',
                'experience'      => '12+',
                'badge'           => 'Verified Security Leader',
                'photo'           => 'assets/images/arun_s.png',
                'specializations' => [
                    'Product Security Expert',
                    'Security Architect',
                    'Cyber Strategist',
                    'Cyber Crime Investigator',
                    'National Security Scholar'
                ],
                'bio'             => 'Principal Security Architect at IBM India with 12+ years across cybersecurity leadership, application security, cloud security and cyber forensics.',
                'domains'         => [
                    [
                        'icon'  => '🛡️',
                        'title' => 'Application & Product Security',
                        'desc'  => 'VAPT, Threat Modeling, DevSecOps'
                    ],
                    [
                        'icon'  => '☁️',
                        'title' => 'Cloud Security & Architecture',
                        'desc'  => 'Zero Trust, Hybrid Cloud Resiliency'
                    ],
                    [
                        'icon'  => '🔍',
                        'title' => 'Cyber Crime & Forensics',
                        'desc'  => 'Digital Evidence, Threat Intelligence'
                    ],
                    [
                        'icon'  => '🏛️',
                        'title' => 'National Security & Strategy',
                        'desc'  => 'Defense-Grade Risk Frameworks'
                    ]
                ],
                'status'          => 'active',
                'order'           => 1
            ]
        ];
        ck_write_json('team.json', $team);
    }

    // 5. Investigation Services Seeding
    if (!file_exists(ck_data_path('investigation_services.json'))) {
        $configPath = dirname(__DIR__) . '/config.php';
        $investigationServices = [];
        if (file_exists($configPath)) {
            // Read $investigationServices from config.php safely
            $lines = file_get_contents($configPath);
            if (preg_match('/\$investigationServices\s*=\s*\[(.*?)\];\s*\/\/\s*7/s', $lines, $m)) {
                // If regex matches array syntax, or use fallback list
            }
        }
        // Direct seed of the 9 canonical investigation services
        $investigationServices = [
            [
                'id'          => '9',
                'slug'        => 'corporate-background-verification-bgv',
                'title'       => 'Corporate Background Verification (BGV)',
                'short'       => 'Corporate BGV Verification',
                'footer_name' => 'Corporate BGV Verification',
                'icon'        => '📋',
                'image'       => 'assets/images/corporate_background_verification_bgv.jpg',
                'description' => 'Comprehensive corporate background verification (BGV), pre-employment screening, executive due diligence, criminal & court record checks, academic/employment validation, and vendor risk verification for enterprises.',
                'status'      => 'active'
            ],
            [
                'id'          => '1',
                'slug'        => 'cybercrime-victim-assistance-account-recovery',
                'title'       => 'Cybercrime Victim Assistance & Account Recovery',
                'short'       => 'Victim & Account Recovery',
                'icon'        => '🛡️',
                'image'       => 'assets/images/investigation_01_victim_recovery.jpg',
                'description' => 'Support for individuals affected by account hacking, online fraud, phishing, impersonation, and cyber extortion incidents. We assist with incident assessment, evidence preservation, recovery guidance, and strengthening account security to prevent future attacks.',
                'status'      => 'active'
            ],
            [
                'id'          => '2',
                'slug'        => 'digital-investigations-osint',
                'title'       => 'Digital Investigations & OSINT',
                'short'       => 'Digital Investigations & OSINT',
                'icon'        => '🔍',
                'image'       => 'assets/images/investigation_02_osint.jpg',
                'description' => 'Comprehensive digital investigations using Open-Source Intelligence (OSINT) techniques to uncover online footprints, verify identities, and assess potential risks. Our reports provide actionable insights for personal, legal, and business decision-making.',
                'status'      => 'active'
            ],
            [
                'id'          => '3',
                'slug'        => 'social-media-investigations-impersonation-removal',
                'title'       => 'Social Media Investigations & Impersonation Removal',
                'short'       => 'Social Media Investigations',
                'icon'        => '📱',
                'image'       => 'assets/images/investigation_03_social_media.jpg',
                'description' => 'Identify and investigate fake profiles, impersonation attempts, account takeovers, and unauthorized content usage across major social media platforms. We help document evidence and support platform reporting and removal processes.',
                'status'      => 'active'
            ],
            [
                'id'          => '4',
                'slug'        => 'cyber-fraud-investigation-support',
                'title'       => 'Cyber Fraud Investigation Support',
                'short'       => 'Cyber Fraud Investigation',
                'icon'        => '💳',
                'image'       => 'assets/images/investigation_04_fraud_support.jpg',
                'description' => 'Professional investigation support for financial scams, investment fraud, crypto fraud, romance scams, and online marketplace deception. We analyse digital evidence, trace fraud indicators, and prepare detailed reports suitable for law enforcement review.',
                'status'      => 'active'
            ],
            [
                'id'          => '5',
                'slug'        => 'digital-evidence-preservation-forensics',
                'title'       => 'Digital Evidence Preservation & Forensics',
                'short'       => 'Digital Evidence & Forensics',
                'icon'        => '💾',
                'image'       => 'assets/images/investigation_05_digital_forensics.jpg',
                'description' => 'Secure collection, preservation, and analysis of digital evidence from devices, emails, screenshots, and online accounts. Our forensic documentation helps maintain evidence integrity for investigations, disputes, and legal proceedings.',
                'status'      => 'active'
            ],
            [
                'id'          => '6',
                'slug'        => 'executive-family-digital-protection',
                'title'       => 'Executive & Family Digital Protection',
                'short'       => 'Executive & Family Protection',
                'icon'        => '👨‍👩‍👧‍👦',
                'image'       => 'assets/images/investigation_06_executive_family.jpg',
                'description' => 'Proactive cybersecurity services designed to protect business leaders, public figures, families, and high-profile individuals from digital threats. We assess security risks, improve privacy controls, and strengthen account and device protection.',
                'status'      => 'active'
            ],
            [
                'id'          => '7',
                'slug'        => 'cybersecurity-awareness-lea-training',
                'title'       => 'Cybersecurity Awareness & LEA Training',
                'short'       => 'Cyber Awareness & LEA Training',
                'icon'        => '🎓',
                'image'       => 'assets/images/investigation_07_lea_training.jpg',
                'description' => 'Specialized training programs for law enforcement agencies, educational institutions, NGOs, and corporate teams on cybercrime prevention and investigation techniques. Sessions focus on practical skills, digital evidence handling, fraud awareness, and incident response readiness.',
                'status'      => 'active'
            ],
            [
                'id'          => '8',
                'slug'        => 'child-digital-safety-protection',
                'title'       => 'Child Digital Safety & Protection',
                'short'       => 'Child Digital Safety',
                'icon'        => '👶',
                'image'       => 'assets/images/investigation_08_child_safety.jpg',
                'description' => 'We help safeguard children in the digital world through confidential investigations, online threat assessment, and digital evidence analysis. Our services focus on identifying cyberbullying, online harassment, suspicious digital interactions, and potential child exploitation risks, including the identification and reporting of Child Sexual Abuse Material (CSAM).',
                'status'      => 'active'
            ]
        ];
        ck_write_json('investigation_services.json', $investigationServices);
    }

    // 6. Cyber Categories & Cyber Services Seeding
    if (!file_exists(ck_data_path('cyber_services.json'))) {
        $servicesDataPath = dirname(__DIR__) . '/services-data.php';
        if (file_exists($servicesDataPath)) {
            // Temporarily include without redeclaring
            $allServicesData = [];
            $serviceCategories = [];
            include $servicesDataPath;
            if (!empty($allServicesData)) {
                // Filter out investigation services that were duplicated in allServicesData
                $cyberOnly = [];
                foreach ($allServicesData as $slug => $s) {
                    if (($s['category'] ?? '') !== 'digital-investigations') {
                        $s['status'] = 'active';
                        $cyberOnly[$slug] = $s;
                    }
                }
                ck_write_json('cyber_services.json', $cyberOnly);
            }
            if (!empty($serviceCategories)) {
                $categoriesOnly = [];
                foreach ($serviceCategories as $catSlug => $c) {
                    if ($catSlug !== 'digital-investigations') {
                        $categoriesOnly[$catSlug] = $c;
                    }
                }
                ck_write_json('cyber_categories.json', $categoriesOnly);
            }
        }
    }

    // 7. Clients & Partners Seeding
    if (!file_exists(ck_data_path('clients.json'))) {
        $clients = [
            [
                'id'       => 'client-1',
                'name'     => 'CopConnect',
                'category' => 'Information Sharing and Analysis Center',
                'desc'     => 'Strategic collaboration in cyber threat intelligence sharing, awareness, and digital incident advisory.',
                'img'      => 'assets/images/client_copconnect.jpg',
                'alt'      => 'CopConnect - Information Sharing and Analysis Center',
                'website'  => 'https://copconnect.org',
                'track'    => 'investigation',
                'order'    => 1,
                'status'   => 'active'
            ],
            [
                'id'       => 'client-2',
                'name'     => 'Gokarna Samudra',
                'category' => 'Beach Resort & Hospitality',
                'desc'     => 'Digital infrastructure protection, cyber dispute resolution, and guest data privacy security.',
                'img'      => 'assets/images/client_gokarna_samudra.jpg',
                'alt'      => 'Gokarna Samudra Beach Resort',
                'website'  => '',
                'track'    => 'investigation',
                'order'    => 2,
                'status'   => 'active'
            ],
            [
                'id'       => 'client-3',
                'name'     => 'CopConnect',
                'category' => 'Information Sharing and Analysis Center',
                'desc'     => 'Enterprise cyber threat intelligence sharing, automated incident indicators, and proactive defensive threat coordination.',
                'img'      => 'assets/images/client_copconnect.jpg',
                'alt'      => 'CopConnect - Threat Intelligence',
                'website'  => 'https://copconnect.org',
                'track'    => 'cyber',
                'order'    => 1,
                'status'   => 'active'
            ],
            [
                'id'       => 'client-4',
                'name'     => 'Gokarna Samudra',
                'category' => 'Beach Resort & Hospitality',
                'desc'     => 'Digital infrastructure protection, web/network penetration testing, and guest data privacy security audits.',
                'img'      => 'assets/images/client_gokarna_samudra.jpg',
                'alt'      => 'Gokarna Samudra Beach Resort',
                'website'  => '',
                'track'    => 'cyber',
                'order'    => 2,
                'status'   => 'active'
            ]
        ];
        ck_write_json('clients.json', $clients);
    }

    // 8. Accreditations, Memberships & Certifications Seeding
    if (!file_exists(ck_data_path('accreditations.json'))) {
        $accreds = [
            [
                'id'         => 'accred-1',
                'name'       => 'Association of Investigators and Detectives',
                'short_name' => 'AID',
                'img'        => 'assets/images/aid.png',
                'alt'        => 'AID - Association of Investigators and Detectives',
                'website'    => '',
                'track'      => 'both',
                'order'      => 1,
                'status'     => 'active'
            ],
            [
                'id'         => 'accred-2',
                'name'       => 'Tamilnadu Association of Professional Detectives and Investigators',
                'short_name' => 'TAPDI',
                'img'        => 'assets/images/tapdi.png',
                'alt'        => 'TAPDI - Tamilnadu Association of Professional Detectives and Investigators',
                'website'    => '',
                'track'      => 'both',
                'order'      => 2,
                'status'     => 'active'
            ],
            [
                'id'         => 'accred-3',
                'name'       => 'Association of Professional Detectives & Investigators',
                'short_name' => 'APDI',
                'img'        => 'assets/images/apdi.png',
                'alt'        => 'APDI - Association of Professional Detectives & Investigators',
                'website'    => '',
                'track'      => 'both',
                'order'      => 3,
                'status'     => 'active'
            ],
            [
                'id'         => 'accred-4',
                'name'       => 'Unified Network of Investigative Professionals',
                'short_name' => 'UNIP',
                'img'        => 'assets/images/unip.svg',
                'alt'        => 'UNIP - Unified Network of Investigative Professionals',
                'website'    => '',
                'track'      => 'both',
                'order'      => 4,
                'status'     => 'active'
            ]
        ];
        ck_write_json('accreditations.json', $accreds);
    }

    // 9. Investigation Threat & Incident Tags Seeding
    if (!file_exists(ck_data_path('investigation_threats.json'))) {
        $defaultThreats = [
            ['id' => '1',  'text' => 'Cybercrime & Online Fraud',             'size' => 'xl', 'accent' => 'purple',  'order' => 1,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '2',  'text' => 'Volatile Memory Extraction',            'size' => 'sm', 'accent' => 'cyan',    'order' => 2,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '3',  'text' => 'Crypto & Blockchain Tracing',           'size' => 'lg', 'accent' => 'cyan',    'order' => 3,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '4',  'text' => 'SIM Swapping & OTP Fraud',              'size' => 'md', 'accent' => 'amber',   'order' => 4,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '5',  'text' => 'Digital Evidence Preservation',         'size' => 'lg', 'accent' => 'emerald', 'order' => 5,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '6',  'text' => 'Metadata & Timestamp Forensics',        'size' => 'sm', 'accent' => 'purple',  'order' => 6,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '7',  'text' => 'Ransomware Incident Triage',            'size' => 'xl', 'accent' => 'rose',    'order' => 7,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '8',  'text' => 'WhatsApp & Telegram Forensics',         'size' => 'sm', 'accent' => 'emerald', 'order' => 8,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '9',  'text' => 'Social Media Impersonation',            'size' => 'lg', 'accent' => 'purple',  'order' => 9,  'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '10', 'text' => 'Business Email Compromise (BEC)',       'size' => 'md', 'accent' => 'amber',   'order' => 10, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '11', 'text' => 'Device Bit-Stream Imaging',             'size' => 'sm', 'accent' => 'cyan',    'order' => 11, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '12', 'text' => 'Corporate Data Theft & Espionage',      'size' => 'xl', 'accent' => 'amber',   'order' => 12, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '13', 'text' => 'Fake Profile & Botnet Tracking',        'size' => 'sm', 'accent' => 'purple',  'order' => 13, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '14', 'text' => 'Deepfake & AI Media Abuse',             'size' => 'md', 'accent' => 'cyan',    'order' => 14, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '15', 'text' => 'Matrimonial & Personal Disputes',       'size' => 'md', 'accent' => 'purple',  'order' => 15, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '16', 'text' => 'Investment & Ponzi Scams',              'size' => 'sm', 'accent' => 'amber',   'order' => 16, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '17', 'text' => 'OSINT Threat Intelligence',             'size' => 'xl', 'accent' => 'cyan',    'order' => 17, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '18', 'text' => 'Malicious APK & Spyware Analysis',      'size' => 'sm', 'accent' => 'rose',    'order' => 18, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '19', 'text' => 'Cyberstalking & Harassment',            'size' => 'md', 'accent' => 'rose',    'order' => 19, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '20', 'text' => 'Chain of Custody Certification',        'size' => 'sm', 'accent' => 'emerald', 'order' => 20, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '21', 'text' => 'Extortion & Blackmail Tracing',         'size' => 'lg', 'accent' => 'rose',    'order' => 21, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '22', 'text' => 'UPI & Banking Scams',                   'size' => 'md', 'accent' => 'cyan',    'order' => 22, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '23', 'text' => 'Dark Web Data Leak Tracing',            'size' => 'md', 'accent' => 'purple',  'order' => 23, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '24', 'text' => 'E-Commerce Marketplace Fraud',          'size' => 'sm', 'accent' => 'amber',   'order' => 24, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '25', 'text' => 'Digital Forensics & Artifact Analysis',  'size' => 'xl', 'accent' => 'cyan',    'order' => 25, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '26', 'text' => 'Cryptographic SHA-256 Hashing',         'size' => 'sm', 'accent' => 'emerald', 'order' => 26, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '27', 'text' => 'Account Takeovers & Hacking',           'size' => 'md', 'accent' => 'purple',  'order' => 27, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '28', 'text' => 'Cloud & Email Forensics',               'size' => 'sm', 'accent' => 'purple',  'order' => 28, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '29', 'text' => 'Child Digital Safety Threats',          'size' => 'md', 'accent' => 'emerald', 'order' => 29, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '30', 'text' => 'Phishing & Credential Theft',           'size' => 'md', 'accent' => 'rose',    'order' => 30, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '31', 'text' => 'Defamation & Slander Evidence',         'size' => 'sm', 'accent' => 'purple',  'order' => 31, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '32', 'text' => 'Court-Admissible Evidence Dossiers',    'size' => 'lg', 'accent' => 'emerald', 'order' => 32, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '33', 'text' => 'Sextortion Emergency Takedowns',        'size' => 'sm', 'accent' => 'rose',    'order' => 33, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '34', 'text' => 'Insider Threat Investigation',          'size' => 'md', 'accent' => 'amber',   'order' => 34, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '35', 'text' => 'Deleted File & Artifact Carving',       'size' => 'md', 'accent' => 'cyan',    'order' => 35, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '36', 'text' => 'Cross-Border LEA Reporting',            'size' => 'sm', 'accent' => 'cyan',    'order' => 36, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '37', 'text' => 'Cell Tower & GPS Geolocation Tracing',  'size' => 'sm', 'accent' => 'cyan',    'order' => 37, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
            ['id' => '38', 'text' => 'Executive Anti-Doxxing & Privacy',      'size' => 'sm', 'accent' => 'emerald', 'order' => 38, 'status' => 'active', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
        ];
        ck_write_json('investigation_threats.json', $defaultThreats);
    }

    // 10. FAQs Seeding (Investigation & Cyber Security)
    if (!file_exists(ck_data_path('faqs.json'))) {
        $defaultFaqs = [
            // Investigation Track FAQs
            [
                'id'         => 'faq-inv-1',
                'track'      => 'investigation',
                'question'   => 'What digital investigation and forensic services do you offer?',
                'answer'     => 'We provide Digital Forensics & Artifact Extraction, OSINT & Background Intelligence, Cyber Fraud & Scam Tracing, Social Media Investigations & Impersonation Removal, Cybercrime Victim Assistance, Executive Digital Protection, and Child Digital Safety investigations.',
                'category'   => 'Services & Scoping',
                'order'      => 1,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-inv-2',
                'track'      => 'investigation',
                'question'   => 'Are your forensic reports admissible in court?',
                'answer'     => 'Yes. All digital evidence is collected, preserved, and analyzed following ISO/IEC 27037 standards. We maintain a rigorous chain of custody and verify artifacts with cryptographic SHA-256 hashes, ensuring our comprehensive reports are fully admissible in legal proceedings.',
                'category'   => 'Evidence & Legal',
                'order'      => 2,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-inv-3',
                'track'      => 'investigation',
                'question'   => 'How do you guarantee the confidentiality of my case?',
                'answer'     => '100% confidentiality is guaranteed from your very first consultation. All case files, client identities, and forensic findings are protected under legally binding Non-Disclosure Agreements (NDAs) and stored in encrypted offline forensic vaults.',
                'category'   => 'Confidentiality & Privacy',
                'order'      => 3,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-inv-4',
                'track'      => 'investigation',
                'question'   => 'How long does a digital investigation take?',
                'answer'     => 'Investigation timelines vary depending on case complexity. Urgent inquiries such as active impersonation or account takeovers can produce actionable intelligence within 24 to 72 hours, while complex corporate forensic audits or financial fraud tracing typically range from 5 to 14 business days.',
                'category'   => 'Timelines & Process',
                'order'      => 4,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-inv-5',
                'track'      => 'investigation',
                'question'   => 'Do you assist with cross-border and international cases?',
                'answer'     => 'Yes. CyberKovai handles digital investigations across India and internationally, working regularly on matters spanning the UAE, Singapore, Germany, Canada, the UK, Australia, and the US.',
                'category'   => 'Jurisdiction & Reach',
                'order'      => 5,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

            // Cyber Security Track FAQs
            [
                'id'         => 'faq-cyb-1',
                'track'      => 'cyber',
                'question'   => 'What cybersecurity services does Cyber Kovai provide?',
                'answer'     => 'Cyber Kovai provides comprehensive offensive and defensive cybersecurity solutions, including Vulnerability Assessment and Penetration Testing (VAPT), Web & Mobile Application Security, Network Penetration Testing, Cloud Security Audits (AWS, GCP, Azure), API Security, Virtual CISO (vCISO) Advisory, Secure Code Review, and Zero-Trust Architecture Hardening.',
                'category'   => 'Offensive & Defensive Services',
                'order'      => 1,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-cyb-2',
                'track'      => 'cyber',
                'question'   => 'What standards and frameworks do you follow during testing?',
                'answer'     => 'Our security testing strictly adheres to industry-leading frameworks including OWASP Top 10, OWASP API Security Top 10, NIST SP 800-115, SANS/CWE 25, and PTES (Penetration Testing Execution Standard), ensuring thorough and standardized vulnerability discovery.',
                'category'   => 'Compliance & Frameworks',
                'order'      => 2,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-cyb-3',
                'track'      => 'cyber',
                'question'   => 'How long does a security assessment or penetration test take?',
                'answer'     => 'Assessment timelines depend on scope and infrastructure size. A typical web application or network VAPT takes between 3 to 10 business days. We provide continuous interim alerts for any critical zero-day discoveries followed by a detailed formal report.',
                'category'   => 'Execution & Reporting',
                'order'      => 3,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-cyb-4',
                'track'      => 'cyber',
                'question'   => 'Do you provide re-testing after our engineering team fixes vulnerabilities?',
                'answer'     => 'Yes. We include complimentary verification re-testing within 30 days to confirm that reported vulnerabilities are properly patched, followed by the issuance of a formal Certificate of Security Attestation.',
                'category'   => 'Patch Verification & Certification',
                'order'      => 4,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id'         => 'faq-cyb-5',
                'track'      => 'cyber',
                'question'   => 'How is our proprietary source code and sensitive infrastructure protected?',
                'answer'     => 'All engagements are conducted under legally binding Non-Disclosure Agreements (NDAs). We utilize encrypted communication channels, secure isolated testing pods, and strict data-handling protocols aligned with ISO 27001.',
                'category'   => 'Data Confidentiality & Security',
                'order'      => 5,
                'status'     => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];
        ck_write_json('faqs.json', $defaultFaqs);
    }
    } finally {
        $seeding = false;
    }
}

/* ==========================================================================
   LEGAL POLICIES & TERMS MANAGEMENT (CRUD)
   ========================================================================== */

function ck_get_legal_policies() {
    $policies = ck_read_json('legal_policies.json', []);
    if (empty($policies) || !isset($policies['privacy'])) {
        return [
            'privacy' => [
                'key'          => 'privacy',
                'title'        => 'Privacy Policy',
                'badge'        => 'DATA PRIVACY & INTEGRITY',
                'last_updated' => 'November 2026',
                'lead_summary' => 'Cyber Kovai is committed to safeguarding client confidentiality, digital forensics evidence, and enterprise privacy.',
                'content'      => '<p>Privacy policy content...</p>'
            ],
            'terms' => [
                'key'          => 'terms',
                'title'        => 'Terms & Conditions',
                'badge'        => 'LEGAL & ENGAGEMENT FRAMEWORK',
                'last_updated' => 'November 2026',
                'lead_summary' => 'Terms of engagement, client authorization, and service agreements.',
                'content'      => '<p>Terms and conditions content...</p>'
            ],
            'disclosure' => [
                'key'          => 'disclosure',
                'title'        => 'Security & Vulnerability Disclosure',
                'badge'        => 'RESPONSIBLE DISCLOSURE & SAFE HARBOR',
                'last_updated' => 'November 2026',
                'lead_summary' => 'Guidelines for reporting vulnerabilities responsibly and safe harbor protections.',
                'content'      => '<p>Security disclosure guidelines...</p>'
            ]
        ];
    }
    return $policies;
}

function ck_get_legal_policy($type = 'privacy') {
    $policies = ck_get_legal_policies();
    return $policies[$type] ?? ($policies['privacy'] ?? null);
}

function ck_save_legal_policy($type, $data) {
    $type = in_array($type, ['privacy', 'terms', 'disclosure'], true) ? $type : 'privacy';
    $policies = ck_get_legal_policies();
    $current = $policies[$type] ?? [];

    $policies[$type] = [
        'key'          => $type,
        'title'        => trim($data['title'] ?? ($current['title'] ?? ucfirst($type))),
        'badge'        => trim($data['badge'] ?? ($current['badge'] ?? 'LEGAL')),
        'last_updated' => trim($data['last_updated'] ?? date('F Y')),
        'lead_summary' => trim($data['lead_summary'] ?? ($current['lead_summary'] ?? '')),
        'content'      => trim($data['content'] ?? ($current['content'] ?? '')),
        'updated_at'   => date('Y-m-d H:i:s')
    ];

    return ck_write_json('legal_policies.json', $policies);
}

// Ensure auto-seeding runs if files do not exist
ck_seed_storage();

