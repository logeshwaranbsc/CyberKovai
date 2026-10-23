<?php
/**
 * Local Development Router for PHP Built-in Web Server
 * Usage: php -S localhost:8000 router.php
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

// Serve static assets directly if they exist
if ($uri !== '/' && file_exists($file) && !is_dir($file)) {
    return false;
}

// Clean Section Route Mappings
switch (rtrim($uri, '/')) {
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
if (file_exists(__DIR__ . $uri . '.php')) {
    require __DIR__ . $uri . '.php';
    exit;
}

// Fallback to index.php
require __DIR__ . '/index.php';
