<?php
/**
 * Cyber Kovai - Our Team & Leadership Page
 */
require_once __DIR__ . '/config.php';

// If Our Team section is hidden in Admin Settings, redirect to About Us page
$ckShowTeam = function_exists('ck_get_settings') 
    ? filter_var(ck_get_settings()['show_team'] ?? true, FILTER_VALIDATE_BOOLEAN)
    : (defined('SITE_SHOW_TEAM') ? SITE_SHOW_TEAM : true);

if (!$ckShowTeam) {
    $targetSection = $_GET['section'] ?? ($_COOKIE['ck_section'] ?? 'cyber');
    header('Location: about.php?section=' . urlencode($targetSection));
    exit;
}

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
            <?php 
            $teamMembers = function_exists('ck_get_team_members') ? ck_get_team_members(false) : [];
            ?>
            <div class="team-showcase-wrapper" style="display: flex; flex-direction: column; gap: 3rem;">
                <?php if (!empty($teamMembers)): ?>
                    <?php foreach ($teamMembers as $member): 
                        $photoUrl = $member['photo'] ?? 'assets/images/arun_s.png';
                        if (!preg_match('~^(https?://|/)~', $photoUrl)) {
                            $photoUrl = $basePrefix . $photoUrl;
                        }
                    ?>
                    <div class="team-leader-card">
                        <div class="leader-visual-wrap">
                            <div class="leader-img-frame">
                                <img src="<?= sanitize_out($photoUrl) ?>" alt="<?= sanitize_out($member['name']) ?> - <?= sanitize_out($member['role']) ?>" class="leader-photo">
                                <?php if (!empty($member['experience'])): ?>
                                <div class="leader-exp-badge">
                                    <strong><?= sanitize_out($member['experience']) ?></strong>
                                    <span>YEARS EXP</span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="leader-info-wrap">
                            <div class="leader-header-bar">
                                <div>
                                    <h3 class="leader-name"><?= sanitize_out($member['name']) ?></h3>
                                    <div class="leader-primary-role">
                                        <?php if (!empty($member['company'])): ?>
                                            <span class="ibm-tag"><?= sanitize_out($member['company']) ?></span>
                                        <?php endif; ?>
                                        <span class="role-text"><?= sanitize_out($member['role']) ?></span>
                                    </div>
                                </div>
                                <?php if (!empty($member['badge'])): ?>
                                <div class="leader-badge-pill">
                                    <span class="pulse-indicator"></span> <?= sanitize_out($member['badge']) ?>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Specializations Pills -->
                            <?php if (!empty($member['specializations']) && is_array($member['specializations'])): ?>
                            <div class="leader-tags-cloud">
                                <?php foreach ($member['specializations'] as $spec): ?>
                                    <span class="tag-pill"><?= sanitize_out($spec) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                            <!-- Executive Bio -->
                            <?php if (!empty($member['bio'])): ?>
                            <div class="leader-bio-quote">
                                <p><?= nl2br(sanitize_out($member['bio'])) ?></p>
                            </div>
                            <?php endif; ?>

                            <!-- Domain Capabilities -->
                            <?php if (!empty($member['domains']) && is_array($member['domains'])): ?>
                            <div class="leader-domains-grid">
                                <?php foreach ($member['domains'] as $dom): ?>
                                <div class="domain-badge-item">
                                    <div class="domain-icon"><?= sanitize_out($dom['icon'] ?? '🛡️') ?></div>
                                    <div>
                                        <strong><?= sanitize_out($dom['title'] ?? '') ?></strong>
                                        <span><?= sanitize_out($dom['desc'] ?? '') ?></span>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>

                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; opacity: 0.7;">No team profiles published at this time.</p>
                <?php endif; ?>
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
