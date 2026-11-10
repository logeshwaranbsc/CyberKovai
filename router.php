<?php
/**
 * Local Development Router for PHP Built-in Web Server
 * Usage: php -S localhost:8000 router.php
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$normalizedUri = '/' . ltrim(str_replace('\\', '/', rawurldecode((string)$uri)), '/');

// Block path traversal, null bytes, and direct HTTP access to sensitive directories/files
if (
    strpos($normalizedUri, '..') !== false ||
    strpos($normalizedUri, "\0") !== false ||
    preg_match('#^/(\.env|\.git|vendor/|tests/|storage/|includes/|admin/includes/|composer\.(json|lock)|phpunit\.xml)#i', $normalizedUri) ||
    (preg_match('#^/data/#i', $normalizedUri) && !preg_match('#^/data/uploads/[a-zA-Z0-9._-]+\.(jpg|jpeg|png|webp|svg|gif)$#i', $normalizedUri))
) {
    http_response_code(403);
    header('Content-Type: text/plain; charset=utf-8');
    echo '403 Forbidden';
    exit;
}

$file = __DIR__ . $normalizedUri;

// Serve static assets directly if they exist (never serve non-public extensions via static bypass)
if ($normalizedUri !== '/' && file_exists($file) && !is_dir($file)) {
    if (strtolower(pathinfo($file, PATHINFO_EXTENSION)) === 'php') {
        // Let PHP built-in server execute .php scripts normally
        return false;
    }
    return false;
}

// Clean Section Route Mappings
switch (rtrim($normalizedUri, '/')) {
    case '/cyber-intelligence':
    case '/cyber-intelligence.php':
    case '/cyber-intelligence/services':
    case '/investigation':
    case '/investigation.php':
    case '/digital-forensics/services':
        $_GET['section'] = 'forensics';
        require __DIR__ . '/cyber-intelligence.php';
        exit;
    case '/digital-forensics':
    case '/digital-forensics.php':
    case '/digitalforensics':
    case '/digitalforensics.php':
        $_GET['section'] = 'cyber';
        require __DIR__ . '/digital-forensics.php';
        exit;
    case '/about':
        require __DIR__ . '/about.php';
        exit;
    case '/team':
    case '/our-team':
        require __DIR__ . '/team.php';
        exit;
    case '/contact':
        require __DIR__ . '/contact.php';
        exit;
}

// Check if adding .php matches an existing script
if (file_exists(__DIR__ . $normalizedUri . '.php')) {
    require __DIR__ . $normalizedUri . '.php';
    exit;
}

// Fallback to index.php
require __DIR__ . '/index.php';
