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

                <h4>QUICK LINKS</h4>

                <a href="index.php">Home</a>
                <a href="cyber-intelligence.php">Cyber Intelligence</a>
                <a href="investigation.php">Investigation</a>
                <a href="about.php">About Us</a>
                <a href="#contact">Contact</a>

            </div>


            <div class="footer-column">

                <h4>CYBER INTELLIGENCE</h4>

                <a href="cyber-intelligence.php#ci-services">Cyber Risk Assessment</a>
                <a href="cyber-intelligence.php#ci-services">Digital Forensics</a>
                <a href="cyber-intelligence.php#ci-services">Social Media Investigation</a>
                <a href="cyber-intelligence.php#ci-services">Data &amp; Information Security</a>
                <a href="cyber-intelligence.php#ci-services">Cyber Security Advisory</a>
                <a href="cyber-intelligence.php#ci-services">Brand &amp; Executive Protection</a>

            </div>


            <div class="footer-column">

                <h4>INVESTIGATION</h4>

                <a href="investigation.php#services">Pre Matrimonial Screening</a>
                <a href="investigation.php#services">Post Matrimonial Disputes</a>
                <a href="investigation.php#services">Character Verification</a>
                <a href="investigation.php#services">Corporate Investigation</a>
                <a href="investigation.php#services">Background Verification</a>
                <a href="investigation.php#services">Surveillance Services</a>

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
