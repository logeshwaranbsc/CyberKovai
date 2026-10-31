<?php
/**
 * Cyber Kovai — Shared Contact Page
 * Works for both Cyber Intelligence and Digital Investigation & Forensics.
 */
require_once __DIR__ . '/config.php';

$pageTitle       = 'Contact Us | Confidential Consultation';
$pageDescription = 'Get in touch with Cyber Kovai for confidential cybersecurity advisory, threat intelligence, and digital forensic investigations.';

include_once __DIR__ . '/includes/header.php';
?>

<main class="contact-page">

    <!-- ================= BREADCRUMB / HERO ================= -->
    <section class="about-hero-header">
        <div class="container">
            <div class="breadcrumb">
                <a href="<?= $activeHomeUrl ?>">Home</a>
                <span class="sep">/</span>
                <span class="current">Contact</span>
            </div>
            <h1 class="page-title">
                Get in Touch for a <span class="gradient-text">Confidential Consultation</span>
            </h1>
            <p style="color: var(--text-secondary); max-width: 640px; margin: 12px 0 0; font-size: 1.05rem;">
                Speak directly with our senior cybersecurity specialists and certified digital forensic investigators. 100% strict client confidentiality guaranteed under non-disclosure protocols.
            </p>
        </div>
    </section>

    <!-- ================= CONTACT SECTION & FORM ================= -->
    <section class="contact-section" style="padding-top: 40px;">
        <div class="container">

            <div class="cta-banner-box">

                <span class="section-tag">
                    SECURE INQUIRY
                </span>

                <h2>
                    Ready to Protect Your <span>Digital Assets?</span>
                </h2>

                <p>
                    Whether you need proactive cyber threat defense or discreet digital forensic investigation, our specialists are ready to assist with fast, reliable, and actionable insights.
                </p>

                <div class="contact-buttons">
                    <a href="tel:<?= sanitize_out(SITE_PHONE_TEL) ?>" class="btn primary-btn">
                        Call Now: <?= sanitize_out(SITE_PHONE) ?> ➔
                    </a>
                    <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" class="btn outline-btn">
                        Email: <?= sanitize_out(SITE_EMAIL) ?>
                    </a>
                </div>

                <!-- Interactive PHP Contact Form -->
                <div class="contact-form-wrapper" style="margin-top: 3rem; width: 100%; text-align: left;">
                    <form id="contactForm" action="process-contact.php" method="POST">
                        <div id="formResponse" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 500;"></div>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                            <div>
                                <label for="name" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Your Name / Pseudonym *</label>
                                <input type="text" id="name" name="name" required placeholder="John Doe" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                            </div>
                            <div>
                                <label for="email" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Secure Email Address *</label>
                                <input type="email" id="email" name="email" required placeholder="john@example.com" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem;">
                            <div>
                                <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone / WhatsApp / Signal *</label>
                                <input type="tel" id="phone" name="phone" required placeholder="+91 63820 19821" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                            </div>
                            <div>
                                <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Service Required *</label>
                                <select id="service" name="service" required style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                    <?php if ($activeSection === 'cyber'): ?>
                                        <option value="Cyber Threat Intelligence">Cyber Threat Intelligence</option>
                                        <option value="Vulnerability Assessment & Pen Testing">Vulnerability Assessment &amp; Pen Testing (VAPT)</option>
                                        <option value="Cloud Security Posture Assessment">Cloud Security Posture Assessment</option>
                                        <option value="Network & Firewall Security">Network &amp; Firewall Security</option>
                                        <option value="Data Protection & Risk Advisory">Data Protection &amp; Risk Advisory</option>
                                        <option value="General Cyber Security Consultation">General Cyber Security Consultation</option>
                                    <?php else: ?>
                                        <option value="Cybercrime Victim Assistance">Cybercrime Victim Assistance &amp; Account Recovery</option>
                                        <option value="Digital Investigations & OSINT">Digital Investigations &amp; OSINT</option>
                                        <option value="Social Media Investigations">Social Media Investigations &amp; Impersonation Removal</option>
                                        <option value="Cyber Fraud Support">Cyber Fraud Investigation Support</option>
                                        <option value="Digital Evidence Forensics">Digital Evidence Preservation &amp; Forensics</option>
                                        <option value="Executive & Family Protection">Executive &amp; Family Digital Protection</option>
                                        <option value="LEA & Corporate Training">Cybersecurity Awareness &amp; LEA Training</option>
                                        <option value="Child Digital Safety">Child Digital Safety &amp; Protection</option>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div style="margin-bottom: 1.5rem;">
                            <label for="message" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Confidential Details / Message *</label>
                            <textarea id="message" name="message" rows="4" required placeholder="Describe your requirement in brief. All submissions are encrypted and kept strictly confidential under NDA." style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit; resize: vertical;"></textarea>
                        </div>

                        <?php if (defined('ENABLE_RECAPTCHA') && ENABLE_RECAPTCHA): ?>
                        <!-- Google reCAPTCHA -->
                        <div class="recaptcha-wrapper" style="margin-bottom: 1.5rem;">
                            <div class="g-recaptcha" data-sitekey="<?= sanitize_out(RECAPTCHA_SITE_KEY) ?>" data-theme="dark"></div>
                        </div>
                        <?php endif; ?>

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
