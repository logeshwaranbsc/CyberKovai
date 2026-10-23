<?php
/**
 * Cyber Kovai - Our Team & Leadership Page
 */
require_once __DIR__ . '/config.php';
$pageTitle = 'Our Team & Leadership | Cyber Kovai';
$bodyClass = 'team-page-view';
include_once __DIR__ . '/includes/header.php';
?>

<main class="about-page">

    <!-- ================= PAGE HERO / BREADCRUMB ================= -->
    <section class="about-hero-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?= $activeHomeUrl ?>">Home</a> <span class="sep">/</span> <a href="<?= $aboutUrl ?>">About</a> <span class="sep">/</span> <span class="current">Our Team</span>
            </div>
            <h1 class="page-title">
                Leadership &amp; <span class="gradient-text">Security Architects</span>
            </h1>
            <p class="section-subtitle" style="max-width: 720px; margin: 1rem auto 0; opacity: 0.85;">
                Led by elite cybersecurity practitioners, principal enterprise architects, and seasoned cyber crime investigators.
            </p>
        </div>
    </section>

    <!-- ================= TEAM SHOWCASE SECTION ================= -->
    <section class="section team-section" id="team">
        <div class="container">
            <div class="team-showcase-wrapper">
                <div class="team-leader-card">
                    <div class="leader-visual-wrap">
                        <div class="leader-img-frame">
                            <img src="<?= $basePrefix ?>assets/images/arun_s.png" alt="Arun S - Principal Security Architect" class="leader-photo">
                            <div class="leader-exp-badge">
                                <strong>12+</strong>
                                <span>YEARS EXP</span>
                            </div>
                        </div>
                    </div>

                    <div class="leader-info-wrap">
                        <div class="leader-header-bar">
                            <div>
                                <h3 class="leader-name">Arun S</h3>
                                <div class="leader-primary-role">
                                    <span class="ibm-tag">IBM India</span>
                                    <span class="role-text">Principal Security Architect</span>
                                </div>
                            </div>
                            <div class="leader-badge-pill">
                                <span class="pulse-indicator"></span> Verified Security Leader
                            </div>
                        </div>

                        <!-- Specializations Pills -->
                        <div class="leader-tags-cloud">
                            <span class="tag-pill">Product Security Expert</span>
                            <span class="tag-pill">Security Architect</span>
                            <span class="tag-pill">Cyber Strategist</span>
                            <span class="tag-pill">Cyber Crime Investigator</span>
                            <span class="tag-pill">National Security Scholar</span>
                        </div>

                        <!-- Executive Bio -->
                        <div class="leader-bio-quote">
                            <p>
                                Principal Security Architect at IBM India with 12+ years across cybersecurity leadership, application security, cloud security and cyber forensics.
                            </p>
                        </div>

                        <!-- Domain Capabilities -->
                        <div class="leader-domains-grid">
                            <div class="domain-badge-item">
                                <div class="domain-icon">🛡️</div>
                                <div>
                                    <strong>Application &amp; Product Security</strong>
                                    <span>VAPT, Threat Modeling, DevSecOps</span>
                                </div>
                            </div>
                            <div class="domain-badge-item">
                                <div class="domain-icon">☁️</div>
                                <div>
                                    <strong>Cloud Security &amp; Architecture</strong>
                                    <span>Zero Trust, Hybrid Cloud Resiliency</span>
                                </div>
                            </div>
                            <div class="domain-badge-item">
                                <div class="domain-icon">🔍</div>
                                <div>
                                    <strong>Cyber Crime &amp; Forensics</strong>
                                    <span>Digital Evidence, Threat Intelligence</span>
                                </div>
                            </div>
                            <div class="domain-badge-item">
                                <div class="domain-icon">🏛️</div>
                                <div>
                                    <strong>National Security &amp; Strategy</strong>
                                    <span>Defense-Grade Risk Frameworks</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= CALL TO ACTION ================= -->
    <section class="section about-cta-section">
        <div class="container">
            <div class="about-cta-banner">
                <div class="cta-inner-content">
                    <h2>Consult With Our <span class="gradient-text">Lead Architects</span></h2>
                    <p>Discuss your enterprise security posture, risk strategy, or investigative requirements in confidence.</p>
                    <a href="<?= $contactUrl ?>" class="btn cta-purple-btn">
                        Schedule a Consultation <span class="arrow">➔</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
