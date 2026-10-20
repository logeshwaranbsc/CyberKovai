<?php
/**
 * Cyber Kovai — Investigation Intelligence Services
 * High-tech layout, 8 specialized services and confidential consultation.
 */
require_once __DIR__ . '/config.php';

$pageTitle       = 'Investigation Services';
$pageDescription = 'Professional digital investigations, OSINT, cyber fraud analysis, digital evidence preservation, and executive protection by CyberKovai, Coimbatore.';

include_once __DIR__ . '/includes/header.php';
?>

<main class="inv-page">

    <!-- ================= HERO SECTION (MATCHING IMAGE 3) ================= -->
    <section class="inv-hero" id="home">
        <div class="inv-hero-hud" aria-hidden="true">
            <div class="inv-grid-lines"></div>
            <div class="inv-radial-glow"></div>
        </div>

        <div class="container inv-hero-container">
            <h1 class="inv-page-title">
                Our <span class="gradient-text">services</span>
            </h1>
            <nav class="inv-breadcrumb" aria-label="Breadcrumb">
                <a href="<?= $activeHomeUrl ?>">Home</a>
                <span class="inv-sep">/</span>
                <span class="inv-current">Services</span>
            </nav>
        </div>
    </section>


    <!-- ================= INDUSTRY TICKER (MATCHING IMAGE 3) ================= -->
    <section class="inv-ticker-bar" aria-label="Industry Focus">
        <div class="inv-ticker-track">
            <div class="inv-ticker-content">
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Healthcare</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Finance And Banking</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Legal And Law Firms</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Government And Public Sector</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Corporate Enterprises</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Education &amp; Academic Institutions</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">High-Net-Worth Families</span>
            </div>
            <!-- Duplicated for seamless marquee loop -->
            <div class="inv-ticker-content" aria-hidden="true">
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Healthcare</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Finance And Banking</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Legal And Law Firms</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Government And Public Sector</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Corporate Enterprises</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">Education &amp; Academic Institutions</span>
                <span class="inv-ticker-star">✦</span>
                <span class="inv-ticker-item">High-Net-Worth Families</span>
            </div>
        </div>
    </section>


    <!-- ================= 8 INVESTIGATION SERVICES GRID (MATCHING IMAGE 3) ================= -->
    <section class="section inv-services-section" id="services">
        <div class="container">

            <div class="inv-services-grid">

                <?php foreach ($investigationServices as $index => $svc): ?>
                    <article class="inv-service-card" id="inv-<?= sanitize_out($svc['slug']) ?>">

                        <!-- Visual Container -->
                        <a href="services/<?= sanitize_out($svc['slug']) ?>.php?section=forensics" class="inv-card-visual" aria-label="<?= sanitize_out($svc['title']) ?>">
                            <span class="inv-badge-num"><?= sanitize_out($svc['id']) ?></span>
                            <img src="<?= sanitize_out($svc['image']) ?>" alt="<?= sanitize_out($svc['title']) ?>" class="inv-card-img" loading="lazy">
                            <div class="inv-card-overlay"></div>
                        </a>

                        <!-- Card Body -->
                        <div class="inv-card-body">
                            <h2 class="inv-card-title"><?= sanitize_out($svc['title']) ?></h2>
                            <p class="inv-card-text"><?= sanitize_out($svc['description']) ?></p>
                            
                            <a href="services/<?= sanitize_out($svc['slug']) ?>.php?section=forensics" class="inv-card-link">
                                Explore Practice Details <span>➔</span>
                            </a>
                        </div>

                    </article>
                <?php endforeach; ?>

                <!-- 9th Slot: 3D Decorative Torus Wireframe (Exact Match to Image 3) -->
                <div class="inv-wireframe-slot" aria-hidden="true">
                    <div class="inv-wireframe-torus">
                        <svg viewBox="0 0 320 320" class="torus-svg" fill="none">
                            <defs>
                                <linearGradient id="torusGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" stop-color="#4e8cff" stop-opacity="0.9" />
                                    <stop offset="50%" stop-color="#9a3df4" stop-opacity="0.8" />
                                    <stop offset="100%" stop-color="#c84bff" stop-opacity="0.4" />
                                </linearGradient>
                            </defs>
                            <!-- Wireframe Torus Curves -->
                            <g stroke="url(#torusGrad)" stroke-width="1.4" opacity="0.85">
                                <?php for ($i = 0; $i < 24; $i++): 
                                    $angle = $i * 15;
                                ?>
                                    <ellipse cx="160" cy="160" rx="120" ry="50" transform="rotate(<?= $angle ?>, 160, 160)" />
                                <?php endfor; ?>
                            </g>
                        </svg>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- ================= CONFIDENTIAL CONSULTATION FORM ================= -->
    <section class="section inv-contact-section" id="contact">
        <div class="container">

            <div class="inv-contact-wrapper">
                <div class="inv-contact-header text-center">
                    <span class="inv-tag-pill">CONFIDENTIAL &amp; DISCREET</span>
                    <h2>Initiate an <span class="gradient-text">Investigation</span></h2>
                    <p>Speak directly with our certified digital forensic investigators and intelligence specialists. 100% strict client confidentiality guaranteed under NDA.</p>
                </div>

                <form class="inv-contact-form" action="process-contact.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="invName">Your Name / Pseudonym</label>
                            <input type="text" id="invName" name="name" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="invEmail">Secure Email Address</label>
                            <input type="email" id="invEmail" name="email" placeholder="client@secure.com" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="invPhone">Phone / Signal / WhatsApp</label>
                            <input type="tel" id="invPhone" name="phone" placeholder="+91 98765 43210" required>
                        </div>
                        <div class="form-group">
                            <label for="invService">Primary Service of Interest</label>
                            <select id="invService" name="service">
                                <?php foreach ($investigationServices as $svc): ?>
                                    <option value="<?= sanitize_out($svc['title']) ?>"><?= sanitize_out($svc['title']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="invMessage">Brief Overview of Case Requirements (Confidential)</label>
                        <textarea id="invMessage" name="message" rows="4" placeholder="Describe the matter briefly. All submissions are encrypted and kept strictly confidential under NDA." required></textarea>
                    </div>

                    <div class="text-center" style="margin-top: 24px;">
                        <button type="submit" class="btn primary-btn btn-lg">
                            Submit Confidential Request <span>➔</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </section>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
