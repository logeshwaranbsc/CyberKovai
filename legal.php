<?php
/**
 * Cyber Kovai - Legal & Compliance Policy Display Framework
 * Displays Privacy Policy, Terms & Conditions, and Security Disclosure dynamically from storage.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/storage.php';

$requestedPolicy = $legalPolicyKey ?? ($_GET['policy'] ?? 'privacy');
if (!in_array($requestedPolicy, ['privacy', 'terms', 'disclosure'], true)) {
    $requestedPolicy = 'privacy';
}

$policy = ck_get_legal_policy($requestedPolicy);
if (!$policy) {
    header('Location: ' . ck_base_url());
    exit;
}

$policyTitle = $policy['title'] ?? 'Legal Policy';
$pageTitle   = $policyTitle;
$pageDescription = !empty($policy['lead_summary']) ? strip_tags($policy['lead_summary']) : ($policyTitle . ' of Cyber Kovai.');

$allPolicies = ck_get_legal_policies();

$policyMeta = [
    'privacy'    => ['file' => 'privacy-policy.php',       'icon' => '🔒', 'name' => 'Privacy Policy'],
    'terms'      => ['file' => 'terms-conditions.php',     'icon' => '⚖️', 'name' => 'Terms & Conditions'],
    'disclosure' => ['file' => 'security-disclosure.php', 'icon' => '🛡️', 'name' => 'Security Disclosure']
];

include_once __DIR__ . '/includes/header.php';
?>

<main class="legal-policy-page">

    <!-- ================= PAGE HERO / BREADCRUMB ================= -->
    <section class="about-hero-header legal-hero-header" style="position: relative; padding: 7rem 0 3.5rem; background: radial-gradient(circle at 50% 0%, rgba(139, 32, 255, 0.15) 0%, transparent 65%), #050511;">
        <div class="container">
            <div class="breadcrumb" style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: var(--text-secondary); margin-bottom: 1.25rem;">
                <a href="<?= function_exists('ck_base_url') ? ck_base_url('digital-forensics.php') : 'digital-forensics.php' ?>" style="color: var(--text-secondary); text-decoration: none;">Home</a>
                <span class="sep" style="opacity: 0.4;">/</span>
                <span style="opacity: 0.7;">Legal &amp; Compliance</span>
                <span class="sep" style="opacity: 0.4;">/</span>
                <span class="current" style="color: var(--accent-cyan); font-weight: 600;"><?= htmlspecialchars($policyTitle) ?></span>
            </div>

            <div style="display: inline-block; margin-bottom: 0.75rem;">
                <span class="section-tag" style="background: rgba(0, 240, 255, 0.08); border-color: rgba(0, 240, 255, 0.3); color: #00f0ff;">
                    <?= htmlspecialchars($policy['badge'] ?? 'COMPLIANCE & LEGAL') ?>
                </span>
            </div>

            <h1 class="page-title" style="font-size: clamp(2.2rem, 4.5vw, 3.5rem); font-weight: 800; line-height: 1.15; margin: 0 0 1rem; color: #fff;">
                <?= htmlspecialchars($policyTitle) ?>
            </h1>

            <p class="coverage-subtitle" style="max-width: 820px; font-size: 1.05rem; line-height: 1.6; color: var(--text-secondary); margin: 0 0 1.5rem;">
                <?= htmlspecialchars($policy['lead_summary'] ?? '') ?>
            </p>

            <div style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 0.4rem 0.95rem; background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 50px; font-size: 0.8rem; color: var(--text-secondary);">
                <span style="width: 7px; height: 7px; border-radius: 50%; background: #34d399; box-shadow: 0 0 8px #34d399;"></span>
                <span>Effective Revision: <strong><?= htmlspecialchars($policy['last_updated'] ?? date('F Y')) ?></strong></span>
            </div>
        </div>
    </section>

    <!-- ================= POLICY CONTENT SECTION ================= -->
    <section class="section" style="padding: 3.5rem 0 5rem;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 280px 1fr; gap: 2.5rem; align-items: start;">

                <!-- Sticky Sidebar Policy Switcher -->
                <aside style="position: sticky; top: 100px;">
                    <div style="background: rgba(14, 12, 32, 0.85); border: 1px solid rgba(139, 32, 255, 0.22); border-radius: 16px; padding: 1.4rem; backdrop-filter: blur(14px); box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);">
                        <div style="font-size: 0.75rem; font-weight: 800; letter-spacing: 0.1em; text-transform: uppercase; color: var(--accent-purple-light); margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid rgba(139, 32, 255, 0.15);">
                            Legal Documents
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 0.45rem;">
                            <?php foreach ($policyMeta as $mKey => $m): 
                                $isActive = ($requestedPolicy === $mKey);
                                $mUrl = function_exists('ck_base_url') ? ck_base_url($m['file']) : $m['file'];
                            ?>
                                <a href="<?= htmlspecialchars($mUrl) ?>"
                                   style="display: flex; align-items: center; gap: 0.65rem; padding: 0.7rem 0.95rem; border-radius: 10px; font-size: 0.88rem; font-weight: <?= $isActive ? '700' : '500' ?>; color: <?= $isActive ? '#fff' : 'var(--text-secondary)' ?>; background: <?= $isActive ? 'linear-gradient(135deg, rgba(139, 32, 255, 0.35), rgba(75, 14, 170, 0.35))' : 'transparent' ?>; border: 1px solid <?= $isActive ? 'rgba(168, 85, 247, 0.45)' : 'transparent' ?>; text-decoration: none; transition: all 0.25s ease;">
                                    <span style="font-size: 1rem;"><?= $m['icon'] ?></span>
                                    <span><?= htmlspecialchars($m['name']) ?></span>
                                </a>
                            <?php endforeach; ?>
                        </div>

                        <!-- Legal Inquiries Help Card -->
                        <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid rgba(139, 32, 255, 0.15);">
                            <div style="font-size: 0.78rem; font-weight: 700; color: #fff; margin-bottom: 0.35rem;">
                                Compliance &amp; Legal Support
                            </div>
                            <p style="font-size: 0.78rem; color: var(--text-muted); line-height: 1.5; margin-bottom: 0.85rem;">
                                Inquiries regarding NDAs, legal holds, or verification dockets:
                            </p>
                            <a href="mailto:<?= sanitize_out(SITE_EMAIL) ?>" style="display: inline-block; font-size: 0.8rem; font-weight: 700; color: var(--accent-cyan); text-decoration: none;">
                                <?= sanitize_out(SITE_EMAIL) ?> ➔
                            </a>
                        </div>
                    </div>
                </aside>

                <!-- Main Legal Policy Document Body -->
                <article class="legal-document-card" style="background: rgba(14, 12, 32, 0.85); border: 1px solid rgba(139, 32, 255, 0.22); border-radius: 20px; padding: 2.75rem 2.5rem; backdrop-filter: blur(20px); box-shadow: 0 16px 45px rgba(0, 0, 0, 0.5);">
                    
                    <div class="legal-content-body" style="font-size: 0.96rem; line-height: 1.75; color: rgba(255, 255, 255, 0.85);">
                        <?= $policy['content'] ?>
                    </div>

                    <div style="margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid rgba(139, 32, 255, 0.2); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.82rem; color: var(--text-muted);">
                            <span style="color: #00e676; font-size: 1rem;">✓</span>
                            <span>Official Legal Policy &bull; <?= sanitize_out(SITE_NAME) ?> Legal &amp; Compliance Department</span>
                        </div>
                        <a href="javascript:window.print()" class="btn btn-secondary btn-sm" style="font-size: 0.78rem; padding: 0.4rem 0.95rem; border-radius: 6px;">
                            🖨️ Print / Save Document
                        </a>
                    </div>
                </article>

            </div>
        </div>
    </section>

</main>

<style>
/* Legal Content Body Typography */
.legal-content-body h3 {
    font-family: "Space Grotesk", sans-serif;
    font-size: 1.35rem;
    font-weight: 700;
    color: #ffffff;
    margin: 2.2rem 0 0.85rem;
    padding-bottom: 0.45rem;
    border-bottom: 1px solid rgba(139, 32, 255, 0.15);
    line-height: 1.3;
}

.legal-content-body h3:first-child {
    margin-top: 0;
}

.legal-content-body p {
    margin: 0 0 1.15rem;
    color: rgba(255, 255, 255, 0.82);
}

.legal-content-body ul,
.legal-content-body ol {
    margin: 0 0 1.35rem;
    padding-left: 1.4rem;
}

.legal-content-body li {
    margin-bottom: 0.55rem;
    color: rgba(255, 255, 255, 0.82);
    line-height: 1.65;
}

.legal-content-body strong {
    color: #ffffff;
    font-weight: 700;
}

.legal-content-body a {
    color: #00f0ff;
    text-decoration: underline;
    text-underline-offset: 3px;
}

.legal-content-body a:hover {
    color: #c084fc;
}

.legal-content-body code {
    background: rgba(139, 32, 255, 0.15);
    border: 1px solid rgba(139, 32, 255, 0.3);
    color: #00f0ff;
    padding: 2px 7px;
    border-radius: 4px;
    font-size: 0.88em;
}

@media (max-width: 900px) {
    .legal-policy-page .container > div {
        grid-template-columns: 1fr !important;
    }
    .legal-policy-page aside {
        position: static !important;
    }
    .legal-document-card {
        padding: 1.75rem 1.4rem !important;
    }
}
</style>

<?php include_once __DIR__ . '/includes/footer.php'; ?>
