<?php
/**
 * Cyber Kovai - About Us Page
 * Matching exact image layout & styling
 */
require_once __DIR__ . '/config.php';
$pageTitle = 'About Us | Intelligence That Goes Beyond Data';
include_once __DIR__ . '/includes/header.php';
?>

<main class="about-page">

    <!-- ================= PAGE HERO / BREADCRUMB ================= -->
    <section class="about-hero-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?= $activeHomeUrl ?>">Home</a> <span class="sep">/</span> <span class="current">About</span>
            </div>
            <h1 class="page-title">
                Intelligence That Goes <span class="gradient-text">Beyond Data</span>
            </h1>
        </div>
    </section>


    <!-- ================= SECTION 1: WHO WE ARE ================= -->
    <section class="section who-we-are-section">
        <div class="container">
            
            <div class="who-we-are-grid">
                
                <div class="who-we-are-content">
                    <div class="section-badge-tag">
                        <span class="dash">—</span> WHO WE ARE <span class="dash">—</span>
                    </div>
                    <h2>Why Organizations<br>Choose CyberKovai</h2>
                    <h3 class="purple-highlight-subtitle">Trusted Investigation & Intelligence</h3>

                    <p>
                        CyberKovai is a professional investigation and intelligence agency delivering confidential, reliable and evidence-based investigation services for individuals, families, businesses and organizations.
                    </p>
                    <p>
                        Our experienced investigators combine traditional investigation methods with modern technology, digital intelligence and analytical techniques to uncover facts, verify information and provide actionable insights.
                    </p>
                    <p>
                        From personal investigations to corporate intelligence, we approach every assignment with confidentiality, professionalism and attention to detail.
                    </p>
                </div>

                <div class="who-we-are-visual">
                    <div class="visual-card-wrapper">
                        <img src="assets/images/about_investigator_woman.jpg" alt="Why Organizations Choose CyberKovai" class="investigator-visual-img">
                        <div class="glass-badge badge-top-right">
                            <strong>10+</strong> <span>YEARS OF EXPERIENCE</span>
                        </div>
                        <div class="glass-badge badge-bottom-left">
                            <strong>500+</strong> <span>INVESTIGATIONS COMPLETED</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- 4 COUNTER CARDS ROW -->
            <div class="stats-cards-bar">
                <div class="stat-bar-card">
                    <div class="stat-icon">💼</div>
                    <div class="stat-details">
                        <span class="stat-number">10+</span>
                        <span class="stat-text">YEARS OF EXPERIENCE</span>
                    </div>
                </div>
                <div class="stat-bar-card">
                    <div class="stat-icon">👤</div>
                    <div class="stat-details">
                        <span class="stat-number">99%</span>
                        <span class="stat-text">SUCCESSFUL CASE RESOLUTION</span>
                    </div>
                </div>
                <div class="stat-bar-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-details">
                        <span class="stat-number">500+</span>
                        <span class="stat-text">INVESTIGATIONS COMPLETED</span>
                    </div>
                </div>
                <div class="stat-bar-card">
                    <div class="stat-icon">⭐</div>
                    <div class="stat-details">
                        <span class="stat-number">15+</span>
                        <span class="stat-text">INVESTIGATION SPECIALISTS</span>
                    </div>
                </div>
            </div>

        </div>
    </section>


    <!-- ================= SECTION 2: PRINCIPLES THAT DEFINE OUR INVESTIGATIONS ================= -->
    <section class="section principles-section" id="principles">
        <div class="principles-ambient-glow" aria-hidden="true"></div>
        <div class="container">
            
            <div class="principles-header">
                <div class="principles-tag">
                    <span>OUR APPROACH</span>
                    <span class="principles-tag-line" aria-hidden="true"></span>
                </div>
                <h2>Principles That Define Our <span class="gradient-text">Investigations</span></h2>
                <p>Every investigation combines technical expertise, ethical practices, and evidence-led intelligence to deliver reliable, confidential, and actionable outcomes.</p>
            </div>

            <div class="principles-grid">
                
                <!-- 01: Confidentiality -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <h3>Confidentiality</h3>
                    <p>Protecting personal information and investigation details at every stage.</p>
                </div>

                <!-- 02: Accuracy & Evidence -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <h3>Accuracy &amp; Evidence</h3>
                    <p>Verifying digital evidence and delivering reliable findings.</p>
                </div>

                <!-- 03: Legal & Ethical Practice -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 3v18M3 7l9-4 9 4M3 7l4 10a5 5 0 0 0 10 0L21 7M3 7h18"></path>
                        </svg>
                    </div>
                    <h3>Legal &amp; Ethical Practice</h3>
                    <p>Following lawful procedures and respecting privacy and individual rights.</p>
                </div>

                <!-- 04: Actionable Intelligence -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                    </div>
                    <h3>Actionable Intelligence</h3>
                    <p>Turning digital findings into clear, informed next steps.</p>
                </div>

                <!-- 05: Intelligence-Led Methods -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9.5 2A2.5 2.5 0 0 1 12 4.5v15a2.5 2.5 0 0 1-4.96.44 2.5 2.5 0 0 1-2.96-3.08 3 3 0 0 1-.34-5.58 2.5 2.5 0 0 1 1.32-4.24 2.5 2.5 0 0 1 4.44-2.04zM14.5 2A2.5 2.5 0 0 0 12 4.5v15a2.5 2.5 0 0 0 4.96.44 2.5 2.5 0 0 0 2.96-3.08 3 3 0 0 0 .34-5.58 2.5 2.5 0 0 0-1.32-4.24 2.5 2.5 0 0 0-4.44-2.04z"/>
                        </svg>
                    </div>
                    <h3>Intelligence-Led Methods</h3>
                    <p>Combining traditional investigative methods with modern digital techniques.</p>
                </div>

                <!-- 06: Experienced Investigators -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <h3>Experienced Investigators</h3>
                    <p>Applying practical experience across corporate, cyber, and background investigations.</p>
                </div>

                <!-- 07: Technology-Enabled Analysis -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                    </div>
                    <h3>Technology-Enabled Analysis</h3>
                    <p>Using modern forensic tools to examine devices, data, and digital activity.</p>
                </div>

                <!-- 08: Clear, Professional Reporting -->
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <h3>Clear, Professional Reporting</h3>
                    <p>Presenting documented findings in a structured, understandable report.</p>
                </div>

            </div>

        </div>
    </section>

<!-- ================= SECTION 4: CALL TO ACTION ================= -->
    <section class="section about-cta-section">
        <div class="container">
            <div class="about-cta-banner">
                <div class="cta-inner-content">
                    <h2>Work With a Team That Sees <span class="gradient-text">What Others Miss</span></h2>
                    <p>Start with a confidential consultation. Tell us about your requirement and our investigation team will recommend the right approach for your case.</p>
                    <a href="<?= $contactUrl ?>" class="btn cta-purple-btn">
                        Talk to an Expert <span class="arrow">➔</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
