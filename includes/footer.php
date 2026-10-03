<?php
if (!defined('SITE_NAME')) {
    require_once __DIR__ . '/../config.php';
}
?>
    <!-- ================= FOOTER ================= -->

    <footer class="footer">

        <div class="container footer-grid">

            <div class="footer-brand">

                <a href="index.php" class="logo">
                    <img src="assets/images/logo.png" alt="<?= sanitize_out(SITE_NAME) ?>">
                    <span>CYBER <strong>KOVAI</strong></span>
                </a>

                <p>
                    CyberKovai is a professional investigation and intelligence agency delivering confidential, reliable and evidence-based investigation services for individuals, families and organizations.
                </p>

                <div class="social-links">
                    <a href="#" aria-label="Facebook">f</a>
                    <a href="#" aria-label="Twitter">x</a>
                    <a href="#" aria-label="Instagram">◎</a>
                    <a href="#" aria-label="LinkedIn">in</a>
                </div>

            </div>


            <div class="footer-column">

                <h4>COMPANY</h4>

                <a href="about.php">About Us</a>
                <a href="#team">Our Team</a>
                <a href="#industries">Industries We Serve</a>
                <a href="#awards">Awards & Recognition</a>
                <a href="#news">News & Events</a>
                <a href="#gallery">Photo Gallery</a>
                <a href="#careers">Careers</a>
                <a href="#faq">Frequently Asked Questions</a>
                <a href="#blog">Intelligence Blog</a>
                <a href="#training">Training & Certification</a>
                <a href="#contact">Contact Us</a>

            </div>


            <div class="footer-column">

                <h4>SERVICES</h4>

                <a href="#services">Pre Matrimonial Screening</a>
                <a href="#services">Post Matrimonial Disputes</a>
                <a href="#services">Character Verification</a>
                <a href="#services">Corporate Investigation</a>
                <a href="#services">Cyber Investigation</a>
                <a href="#services">Surveillance Services</a>
                <a href="#services">Background Verification</a>
                <a href="#services">Private Detective Services</a>
                <a href="#services">Digital Investigation</a>
                <a href="#services">Risk Advisory</a>
                <a href="#services">Competitive Intelligence</a>

            </div>


            <div class="footer-column">

                <h4>REACH US</h4>

                <p class="reach-item">📍 Coimbatore, Tamil Nadu, India</p>
                <p class="reach-item">📞 +91 93620 96921</p>
                <p class="reach-item">✉️ info@cyberkovai.com</p>

            </div>

        </div>

        <div class="container service-areas-bar">
            <h4>SERVICE AREAS</h4>
            <p><strong>India:</strong> Coimbatore, Chennai, Bengaluru, Hyderabad, Mumbai, Delhi, Pune, Madurai and major cities across India.</p>
            <p><strong>International:</strong> Investigation and intelligence support available across selected international locations.</p>
        </div>


        <div class="footer-bottom">

            <p>
                © <?= date('Y') ?> <?= sanitize_out(SITE_NAME) ?>. All Rights Reserved.
            </p>

            <div>
                <a href="#">Privacy Policy</a>
                <span>|</span>
                <a href="#">Terms & Conditions</a>
            </div>

        </div>

    </footer>


    <script src="script.js"></script>

</body>

</html>
