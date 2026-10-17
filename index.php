<?php
/**
 * Cyber Kovai - Main Landing Page (Matching Image 1 Design)
 */
require_once __DIR__ . '/config.php';
include_once __DIR__ . '/includes/header.php';
?>

    <main>

        <!-- ================= HERO ================= -->

        <section class="hero" id="home">

            <div class="hero-bg"></div>

            <div class="container hero-content">

                <div class="hero-left">

                    <div class="hero-tags-wrapper">
                        <span class="hero-tag-pill">BUSINESS INTELLIGENCE</span>
                        <span class="hero-tag-pill">RISK REDUCTION</span>
                        <span class="hero-tag-pill">ADAPTIVE INSIGHTS</span>
                    </div>

                    <h1>
                        Professional Investigation<br>
                        <span class="hero-gradient-text">Solutions</span><br>
                        <span class="hero-by-line">by <span class="cyber-glitch-wrapper" title="CyberKovai Cyber Systems"><span class="cyber-glitch-text" data-text="CyberKovai">CyberKovai</span><span class="cyber-cursor" aria-hidden="true">_</span><span class="cyber-scan-bar" aria-hidden="true"></span></span></span>
                    </h1>

                    <p>
                        CyberKovai delivers confidential and result-oriented investigation services for individuals, families, and businesses. Our experienced investigators provide accurate reports, discreet operations, and trusted support across matrimonial, employment, fraud, and cyber investigations.
                    </p>

                    <div class="hero-buttons">

                        <a href="#contact" class="btn primary-btn">
                            Get a Consultation
                            <span>➔</span>
                        </a>

                        <a href="cyber-intelligence.php" class="btn outline-btn">
                            Explore Cyber Intelligence
                            <span>➔</span>
                        </a>

                    </div>

                    <div class="hero-features-row">
                        <div><span>✓</span> Due Diligence</div>
                        <div><span>✓</span> Actionable</div>
                        <div><span>✓</span> Actionable Insights</div>
                    </div>

                </div>

                <!-- RIGHT SIDE: Preserved Exact Image 2 Hologram Shield Stage -->
                <div class="hero-visual">

                    <canvas id="fx" aria-hidden="true"></canvas>

                    <div class="stage" id="stage">
                        <!-- Background HUD rings -->
                        <svg class="hud" viewBox="0 0 800 800" fill="none" aria-hidden="true">
                            <g class="c">
                                <circle cx="400" cy="400" r="388" stroke="#e9dcff" stroke-opacity=".28" stroke-width="8" stroke-dasharray="1 14" />
                            </g>
                            <g class="a">
                                <circle cx="400" cy="400" r="370" stroke="#c84bff" stroke-opacity=".25" />
                                <circle cx="400" cy="400" r="340" stroke="#e9dcff" stroke-opacity=".4" stroke-dasharray="2 10" />
                                <circle cx="400" cy="400" r="355" pathLength="100" stroke="#c84bff" stroke-width="3" stroke-linecap="round" stroke-dasharray="16 84" />
                                <circle cx="400" cy="400" r="355" pathLength="100" stroke="#7b2ff7" stroke-width="3" stroke-linecap="round" stroke-dasharray="9 91" stroke-dashoffset="-50" />
                            </g>
                            <g class="b">
                                <circle cx="400" cy="400" r="320" stroke="#c84bff" stroke-opacity=".2" />
                                <g class="node">
                                    <circle cx="677" cy="560" r="14" fill="var(--node-fill)" stroke="#c84bff" stroke-width="2" />
                                    <circle cx="677" cy="560" r="4" fill="#c84bff" />
                                </g>
                                <g class="node">
                                    <circle cx="123" cy="560" r="14" fill="var(--node-fill)" stroke="#c84bff" stroke-width="2" />
                                    <circle cx="123" cy="560" r="4" fill="#c84bff" />
                                </g>
                                <g class="node">
                                    <circle cx="400" cy="80" r="14" fill="var(--node-fill)" stroke="#c84bff" stroke-width="2" />
                                    <circle cx="400" cy="80" r="4" fill="#c84bff" />
                                </g>
                            </g>
                        </svg>

                        <!-- Glowing platform -->
                        <div class="platform" aria-hidden="true">
                            <i class="ring pulse"></i><i class="ring pulse p2"></i><i class="ring pulse p3"></i>
                            <i class="ring r1"></i><i class="ring r2"></i><i class="ring r3"></i><i class="ring r4"></i><i class="ring disc"></i>
                        </div>

                        <div class="beam" aria-hidden="true"></div>

                        <!-- Shield -->
                        <div class="shield-pos">
                            <div class="shield">
                                <img src="assets/images/logo.png" alt="Cyber Kovai Shield Logo" class="shield-logo-img">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>


        <!-- ================= ABOUT SECTION ================= -->

        <section class="section about-section" id="about">

            <div class="container about-grid">

                <div class="about-content">

                    <span class="section-tag">
                        ABOUT CYBER KOVAI
                    </span>

                    <h2>
                        Make Confident
                        Decisions with Trusted
                        <span>Business Intelligence</span>
                    </h2>

                    <p>
                        At Cyber Kovai, we provide reliable and discreet investigation and verification services to help individuals, businesses and organizations make informed and confident decisions.
                    </p>
                    <p>
                        20+ years of experience and a team of experts combine traditional investigative methods with modern technology to deliver fast, accurate and actionable analytics.
                    </p>

                    <div class="about-bullets">
                        <div><span>✓</span> Experienced Investigators</div>
                        <div><span>✓</span> Discreet & Confidential Process</div>
                        <div><span>✓</span> Tailored Solutions for Individuals & Businesses</div>
                    </div>

                </div>

                <div class="about-image-card">
                    <img src="assets/images/15_investigation_monitoring_room.png" alt="Trusted Intelligence Visual" class="about-hero-img">
                    <div class="badge-overlay badge-top-right">
                        <span>🛡️</span> Trusted by <strong>2000+ Clients</strong>
                    </div>
                    <div class="badge-overlay badge-bottom-left">
                        <span>📈</span> <strong>99% Accuracy</strong>
                    </div>
                </div>

            </div>

        </section>


        <!-- ================= ACCREDITATION MARQUEE ================= -->

        <section class="accreditation-bar">
            <div class="marquee-wrapper">
                <div class="marquee-track">
                    <?php foreach ($accreds as $badge): ?>
                        <div class="marquee-item">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach ($accreds as $badge): ?>
                        <div class="marquee-item">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>


        <!-- ================= FOCUS SECTION (WHAT IS CORPORATE INTELLIGENCE) ================= -->

        <section class="section focus-section" id="features">

            <div class="container">

                <div class="focus-header text-center">

                    <span class="section-tag">
                        OUR FOCUS
                    </span>

                    <h2>
                        What is <span>Corporate Intelligence?</span>
                    </h2>

                    <p class="focus-intro">
                        Corporate Intelligence involves gathering, analysing and interpreting information about a company, market or industry to support strategic decision-making. It helps organizations identify opportunities, mitigate risk and stay ahead in a competitive environment.
                    </p>

                    <div class="focus-callout">
                        At Cyber Kovai, we deliver verified and unbiased information to help you make confident decisions.
                    </div>

                    <div class="focus-pills-row">
                        <?php foreach ($focusCategories as $cat): ?>
                            <span class="focus-pill"><?= sanitize_out($cat) ?></span>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>

        </section>


        <!-- ================= STATS SECTION ================= -->

        <section class="stats-section">

            <div class="container">

                <div class="stats-counter-grid">
                    <?php foreach ($stats as $stat): ?>
                        <div class="stat-counter-card">
                            <strong><?= sanitize_out($stat['value']) ?></strong>
                            <span><?= sanitize_out($stat['label']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>

        </section>


        <!-- ================= PRACTICES / SERVICES ================= -->

        <section class="section services-section" id="services">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        OUR PRACTICES
                    </span>

                    <h2>
                        Seven Practices. One Standard: <span>Verified Truth.</span>
                    </h2>

                    <p>
                        Comprehensive investigation and business intelligence services for individuals and organizations.
                    </p>

                </div>


                <div class="practices-grid">

                    <?php foreach ($services as $service): ?>
                        <article class="practice-card">

                            <div class="practice-icon-box">
                                <?= sanitize_out($service['icon']) ?>
                            </div>

                            <h3><?= sanitize_out($service['title']) ?></h3>

                            <p><?= sanitize_out($service['description']) ?></p>

                            <a href="#contact" class="practice-link">Learn More <span>➔</span></a>

                        </article>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= PROCESS (STRUCTURED LIFECYCLE) ================= -->

        <section class="section process-section" id="process">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        OUR PROCESS
                    </span>

                    <h2>
                        A Structured <span>Intelligence Lifecycle</span>
                    </h2>

                    <p>
                        A systematic approach to deliver solutions and actionable insights.
                    </p>

                </div>


                <div class="lifecycle-grid">

                    <?php foreach ($processSteps as $step): ?>
                        <div class="lifecycle-card">

                            <span class="lifecycle-num"><?= sanitize_out($step['num']) ?></span>

                            <h3><?= sanitize_out($step['title']) ?></h3>

                            <p><?= sanitize_out($step['desc']) ?></p>

                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= INDUSTRIES ================= -->

        <section class="section industries-section" id="industries">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        INDUSTRIES
                    </span>

                    <h2>
                        Intelligence Tailored to Your <span>Sector's Risks</span>
                    </h2>

                    <p>
                        Customized investigation and business intelligence solutions for a wide range of industries.
                    </p>

                </div>


                <div class="industries-grid">

                    <?php foreach ($industries as $ind): ?>
                        <div class="industry-card">
                            <span class="ind-icon"><?= sanitize_out($ind['icon']) ?></span>
                            <span class="ind-name"><?= sanitize_out($ind['name']) ?></span>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= CLIENT SCALES ================= -->

        <section class="section clients-section">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        OUR CLIENTS
                    </span>

                    <h2>
                        From Startups to <span>Multinationals</span>
                    </h2>

                    <p>
                        Organizations across industries trust Cyber Kovai for accurate and reliable insights.
                    </p>

                </div>


                <div class="client-scales-grid">

                    <?php foreach ($clientTypes as $client): ?>
                        <div class="client-scale-card">
                            <div class="client-icon"><?= sanitize_out($client['icon']) ?></div>
                            <h3><?= sanitize_out($client['title']) ?></h3>
                            <p><?= sanitize_out($client['desc']) ?></p>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= REACH / COVERAGE ================= -->

        <section class="section coverage-section" id="coverage">

            <div class="container">

                <div class="coverage-grid">

                    <!-- Left Side: Interactive 3D Globe -->
                    <div class="coverage-globe-col">
                        <div id="globe-wrap" class="globe-box">
                            <canvas id="c"></canvas>
                            <div id="hint">
                                Drag to rotate &bull; auto-rotates when idle
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Worldwide Service Content -->
                    <div class="coverage-content-col">

                        <span class="section-tag">
                            OUR REACH
                        </span>

                        <h2>
                            From Coimbatore <span>to the World</span>
                        </h2>

                        <p class="coverage-subtitle">
                            Delivering trusted investigation and intelligence services to clients across India and internationally.
                        </p>

                        <div class="coverage-features">

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Global Network & Cross-Border Intelligence</h4>
                                    <p>Seamless operational capabilities across Asia-Pacific, Middle East, Europe, North America, and beyond.</p>
                                </div>
                            </div>

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>On-The-Ground Local Operatives</h4>
                                    <p>Direct access to vetted field investigators and legal intelligence partners in 50+ key international jurisdictions.</p>
                                </div>
                            </div>

                            <div class="coverage-feature">
                                <div class="coverage-feature-text">
                                    <h4>Strict International Legal Compliance</h4>
                                    <p>All inquiries are executed strictly within regional regulatory frameworks and data privacy mandates.</p>
                                </div>
                            </div>

                        </div>

                        <div class="coverage-locations-header">
                            <span>Key Operational Hubs & Coverage:</span>
                        </div>

                        <div class="locations-pill-bar">
                            <?php foreach ($locations as $loc): ?>
                                <span class="location-pill"><?= sanitize_out($loc) ?></span>
                            <?php endforeach; ?>
                        </div>

                    </div>

                </div>

            </div>

        </section>


        <!-- ================= ACCREDITATIONS & CREDENTIALS ================= -->

        <section class="section credentials-section">

            <div class="container text-center">

                <span class="section-tag">
                    OUR CREDENTIALS
                </span>

                <h2>
                    Memberships, Associations & <span>Certifications</span>
                </h2>

                <p style="max-width: 680px; margin: 0 auto 2.5rem; opacity: 0.85;">
                    We are associated with reputable organizations and certified bodies to ensure the highest standards of professionalism and ethics.
                </p>

            </div>

            <!-- Credentials Marquee Row 1 (Scrolling Left) -->
            <div class="marquee-wrapper credentials-marquee">
                <div class="marquee-track">
                    <?php foreach ($accreds as $badge): ?>
                        <div class="marquee-item">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach ($accreds as $badge): ?>
                        <div class="marquee-item">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Credentials Marquee Row 2 (Scrolling Right) -->
            <div class="marquee-wrapper credentials-marquee">
                <div class="marquee-track marquee-track-reverse">
                    <?php foreach (array_reverse($accreds) as $badge): ?>
                        <div class="marquee-item">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php foreach (array_reverse($accreds) as $badge): ?>
                        <div class="marquee-item">
                            <div class="badge-card">
                                <img src="<?= sanitize_out($badge['img']) ?>" alt="<?= sanitize_out($badge['alt']) ?>" class="badge-img">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </section>


        <!-- ================= BUSINESS RISK SIMULATOR (TOOL) ================= -->

        <section class="section tools-section" id="company">

            <div class="container">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        TOOLS
                    </span>

                    <h2>
                        Business Risk <span>Simulator</span>
                    </h2>

                    <p>
                        Assess potential risk and make informed decisions with our interactive tools.
                    </p>

                </div>


                <div class="simulator-grid">

                    <?php foreach ($riskTools as $tool): ?>
                        <div class="simulator-card">
                            <div class="sim-icon"><?= sanitize_out($tool['icon']) ?></div>
                            <h3><?= sanitize_out($tool['title']) ?></h3>
                            <p><?= sanitize_out($tool['desc']) ?></p>
                        </div>
                    <?php endforeach; ?>

                </div>

            </div>

        </section>


        <!-- ================= FAQ SECTION ================= -->

        <section class="section faq-section" id="faq">

            <div class="container" style="max-width: 860px;">

                <div class="section-heading text-center">

                    <span class="section-tag">
                        FAQ
                    </span>

                    <h2>
                        Frequently Asked <span>Questions</span>
                    </h2>

                </div>


                <div class="faq-accordion-list">

                    <?php foreach ($faqs as $faq): ?>
                        <div class="faq-item">

                            <button class="faq-question">
                                <?= sanitize_out($faq['question']) ?>
                                <span class="arrow-icon">▼</span>
                            </button>

                            <div class="faq-answer">
                                <p><?= sanitize_out($faq['answer']) ?></p>
                            </div>

                        </div>
                    <?php endforeach; ?>

                </div>

                <div class="text-center" style="margin-top: 2rem;">
                    <a href="#contact" class="btn outline-btn">View All FAQs ➔</a>
                </div>

            </div>

        </section>


        <!-- ================= CTA BANNER & CONTACT FORM ================= -->

        <section class="contact-section" id="contact">

            <div class="container">

                <div class="cta-banner-box">

                    <span class="section-tag">
                        GET STARTED
                    </span>

                    <h2>
                        Ready to Reduce <span>Business Risk?</span>
                    </h2>

                    <p>
                        Partner with Cyber Kovai for trusted, confidential and professional investigation and business intelligence services.
                    </p>

                    <div class="contact-buttons">

                        <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn primary-btn">
                            Get a Consultation ➔
                        </a>

                        <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" class="btn outline-btn">
                            Learn More
                        </a>

                    </div>

                    <!-- Interactive PHP Contact Form -->
                    <div class="contact-form-wrapper" style="margin-top: 3rem; width: 100%; text-align: left;">
                        <form id="contactForm" action="process-contact.php" method="POST">
                            <div id="formResponse" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;"></div>
                            
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                                <div>
                                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Your Name *</label>
                                    <input type="text" id="name" name="name" required placeholder="John Doe" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                                <div>
                                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Email Address *</label>
                                    <input type="email" id="email" name="email" required placeholder="john@example.com" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                                <div>
                                    <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone Number *</label>
                                    <input type="tel" id="phone" name="phone" required placeholder="+91 98765 43210" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
                                <div>
                                    <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Service Required</label>
                                    <select id="service" name="service" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                        <option value="">Select a Practice</option>
                                        <?php foreach ($services as $service): ?>
                                            <option value="<?= sanitize_out($service['title']) ?>"><?= sanitize_out($service['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div style="margin-bottom: 1.5rem;">
                                <label for="message" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Details / Message *</label>
                                <textarea id="message" name="message" rows="4" required placeholder="Describe your requirement in brief..." style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; resize: vertical;"></textarea>
                            </div>

                            <button type="submit" class="btn primary-btn" style="cursor: pointer; border: none; width: 100%; justify-content: center; font-size: 1.05rem;">
                                Submit Confidential Request ➔
                            </button>
                        </form>
                    </div>

                </div>

            </div>

        </section>

    </main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
