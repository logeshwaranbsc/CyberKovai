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
<?php if (!function_exists('ck_is_section_visible') || ck_is_section_visible('contact_hero')): ?>
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
<?php endif; ?>

    <!-- ================= CONTACT SECTION & FORM ================= -->
<?php if (!function_exists('ck_is_section_visible') || ck_is_section_visible('contact_form_section')): ?>
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

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.2rem; margin-bottom: 1.2rem; align-items: start;">
                            <div>
                                <label for="phone" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Phone / WhatsApp / Signal *</label>
                                <input type="tel" id="phone" name="phone" required placeholder="<?= sanitize_out(SITE_PHONE) ?>" style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                            </div>
                            <div>
                                <label for="service" style="display: block; margin-bottom: 0.5rem; font-size: 0.9rem; opacity: 0.9;">Service Required *</label>
                                <select id="service" name="service" required style="width: 100%; padding: 0.9rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                    <?php if ($activeSection === 'cyber'): ?>
                                        <option value="General Cyber Security Consultation">General Cyber Security Consultation</option>
                                        <?php 
                                        $activeCyberServices = function_exists('ck_get_cyber_services') ? ck_get_cyber_services(false) : [];
                                        foreach ($activeCyberServices as $cSvc): 
                                        ?>
                                            <option value="<?= sanitize_out($cSvc['title']) ?>"><?= sanitize_out($cSvc['title']) ?></option>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <option value="General Digital Investigation Consultation">General Digital Investigation Consultation</option>
                                        <?php 
                                        global $investigationServices;
                                        foreach ($investigationServices as $iSvc): 
                                        ?>
                                            <option value="<?= sanitize_out($iSvc['title']) ?>"><?= sanitize_out($iSvc['title']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <option value="Other">Other (Please specify)</option>
                                </select>
                                <div class="service-other-wrap" style="display: none; margin-top: 0.75rem;">
                                    <label for="service_other" style="display: block; margin-bottom: 0.35rem; font-size: 0.82rem; opacity: 0.9; color: var(--purple-light);">Specify Your Requirement *</label>
                                    <input type="text" id="service_other" name="service_other" placeholder="Type your custom service requirement..." style="width: 100%; padding: 0.85rem 1.1rem; border-radius: 10px; font-family: inherit;">
                                </div>
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
<?php endif; ?>

</main>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
