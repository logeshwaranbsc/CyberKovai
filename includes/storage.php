<?php
/**
 * Cyber Kovai - File Storage Engine & Data Access Layer
 * Handles JSON file storage, auto-seeding, file locks, atomic writes, uploads, and data sync.
 */

if (!defined('CK_DATA_DIR')) {
    define('CK_DATA_DIR', dirname(__DIR__) . '/data');
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
 * Write JSON file safely with exclusive file lock.
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
        'working_hours', 'social_linkedin', 'social_twitter', 'show_team'
    ];
    foreach ($allowedKeys as $k) {
        if (isset($data[$k])) {
            if ($k === 'show_team') {
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
    return ck_write_json('settings.json', $current);
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
        'icon'        => trim($data['icon'] ?? '🛡️'),
        'image'       => trim($data['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg'),
        'description' => trim($data['description'] ?? ''),
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
    return ['success' => $saved, 'user' => $admin];
}

/* ==========================================================================
   STORAGE AUTO-SEEDER
   Seeds files from existing application data if files are not yet created.
   ========================================================================== */

function ck_seed_storage() {
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
        // Direct seed of the 8 canonical investigation services
        $investigationServices = [
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
}

// Ensure auto-seeding runs if files do not exist
ck_seed_storage();

