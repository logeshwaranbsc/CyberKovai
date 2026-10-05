<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
$pageTitle = isset($pageTitle) ? $pageTitle . ' | ' . SITE_NAME : SITE_NAME . ' | ' . SITE_TAGLINE;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cyber Kovai - Verified Facts, Confident Decisions. Trusted due diligence and investigation services across India & worldwide.">
    <title><?= sanitize_out($pageTitle) ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    <link rel="shortcut icon" type="image/png" href="assets/images/logo.png">
    <link rel="apple-touch-icon" href="assets/images/logo.png">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/lenis@1.1.18/dist/lenis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/d3@7.9.0/dist/d3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/topojson-client@3.1.0/dist/topojson-client.min.js"></script>
</head>

<body>

    <!-- ================= NAVBAR ================= -->

    <header class="navbar">
        <div class="container nav-container">

            <a href="index.php" class="logo">
                <img src="assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                <span>CYBER <strong>KOVAI</strong></span>
            </a>

            <nav class="nav-menu" id="navMenu">
                <?php
                $currentScript = basename($_SERVER['PHP_SELF']);
                foreach ($navLinks as $url => $label):
                    if ($url === '#contact') continue;
                    $isActive = ($currentScript === $url);
                ?>
                    <a href="<?= sanitize_out($url) ?>" class="<?= $isActive ? 'active' : '' ?>"><?= sanitize_out($label) ?></a>
                <?php endforeach; ?>
            </nav>

            <div class="nav-actions">
                <button class="search-btn" title="Search" aria-label="Search">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>

                <button class="theme-toggle" id="themeToggle" title="Toggle Light/Dark Theme" aria-label="Toggle theme">
                    <svg class="sun-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="5" />
                        <path d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42" />
                    </svg>
                    <svg class="moon-icon" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z" />
                    </svg>
                </button>

                <a href="#contact" class="nav-button">
                    Confidential Consultation
                </a>

                <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
                    ☰
                </button>
            </div>

        </div>
    </header>
