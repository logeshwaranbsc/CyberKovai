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
                <a href="index.php">Home</a> <span class="sep">/</span> <span class="current">About</span>
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


    <!-- ================= SECTION 2: OUR PRINCIPLES ================= -->
    <section class="section principles-section">
        <div class="container">
            
            <div class="section-header text-center">
                <div class="section-badge-tag">
                    <span class="dash">—</span> OUR PRINCIPLES <span class="dash">—</span>
                </div>
                <h2>Five Principles Behind Every <span class="gradient-text">Investigation</span></h2>
            </div>

            <div class="principles-grid">
                
                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                        </svg>
                    </div>
                    <h3>Confidentiality</h3>
                    <p>Your identity, personal information and investigation details remain strictly confidential from the initial consultation to the final report.</p>
                </div>

                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <circle cx="12" cy="12" r="6"></circle>
                            <circle cx="12" cy="12" r="2"></circle>
                        </svg>
                    </div>
                    <h3>Accuracy</h3>
                    <p>Every investigation is conducted with attention to detail, ensuring information and evidence are carefully verified before conclusions are provided.</p>
                </div>

                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 3v18M3 7l9-4 9 4M3 7l4 10a5 5 0 0 0 10 0L21 7M3 7h18"></path>
                        </svg>
                    </div>
                    <h3>Legal Compliance</h3>
                    <p>Our investigations are conducted within applicable legal and ethical boundaries while respecting privacy and individual rights.</p>
                </div>

                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                    </div>
                    <h3>Actionable Intelligence</h3>
                    <p>We don't just collect information. We analyze evidence and provide clear findings that help clients make informed decisions.</p>
                </div>

                <div class="principle-card">
                    <div class="principle-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon>
                        </svg>
                    </div>
                    <h3>Ethical Investigations</h3>
                    <p>Every assignment is handled with professionalism, discretion and respect for the people involved.</p>
                </div>

            </div>

        </div>
    </section>


    <!-- ================= SECTION 3: WHY CYBERKOVAI ================= -->
    <section class="section what-sets-us-apart-section">
        <div class="container">
            
            <div class="section-header text-center">
                <div class="section-badge-tag">
                    <span class="dash">—</span> WHY CYBERKOVAI <span class="dash">—</span>
                </div>
                <h2>What Sets Us <span class="gradient-text">Apart</span></h2>
            </div>

            <div class="apart-grid">
                
                <div class="apart-card">
                    <div class="apart-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </div>
                    <div class="apart-card-text">
                        <h3>Intelligence-Led Investigations</h3>
                        <p>We combine traditional investigative methods with modern intelligence gathering and digital investigation techniques to uncover verified facts.</p>
                    </div>
                </div>

                <div class="apart-card">
                    <div class="apart-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="2" y1="12" x2="22" y2="12"></line>
                            <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                        </svg>
                    </div>
                    <div class="apart-card-text">
                        <h3>Confidential Investigation</h3>
                        <p>Every case is handled with strict confidentiality, protecting your identity, information and investigation details throughout the process.</p>
                    </div>
                </div>

                <div class="apart-card">
                    <div class="apart-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                    <div class="apart-card-text">
                        <h3>Experienced Investigators</h3>
                        <p>Our investigation team brings practical experience across personal, corporate, matrimonial, cyber and background investigations.</p>
                    </div>
                </div>

                <div class="apart-card">
                    <div class="apart-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                            <line x1="8" y1="21" x2="16" y2="21"></line>
                            <line x1="12" y1="17" x2="12" y2="21"></line>
                        </svg>
                    </div>
                    <div class="apart-card-text">
                        <h3>Technology-Enabled Intelligence</h3>
                        <p>We use modern digital tools, analytical techniques and investigation technologies to improve research, evidence collection and case analysis.</p>
                    </div>
                </div>

                <div class="apart-card">
                    <div class="apart-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <div class="apart-card-text">
                        <h3>Evidence-Based Reporting</h3>
                        <p>Investigation findings are carefully documented and presented in a clear and structured format for better understanding and decision-making.</p>
                    </div>
                </div>

                <div class="apart-card">
                    <div class="apart-icon-box">
                        <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                    </div>
                    <div class="apart-card-text">
                        <h3>Professional & Discreet Service</h3>
                        <p>From the first consultation to the final report, we maintain professionalism, discretion and complete respect for client confidentiality.</p>
                    </div>
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
                    <a href="#contact" class="btn cta-purple-btn">
                        Talk to an Investigation Expert <span class="arrow">➔</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
