<?php
/**
 * Cyber Kovai - Legal & Compliance Policy Management
 * Allows editing Privacy Policy, Terms & Conditions, and Security Disclosure policies.
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$tab = $_GET['tab'] ?? 'privacy';
if (!in_array($tab, ['privacy', 'terms', 'disclosure'], true)) {
    $tab = 'privacy';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header("Location: legal-pages.php?tab={$tab}");
        exit;
    }

    $postTab = $_POST['policy_key'] ?? $tab;
    $policyData = [
        'title'        => trim($_POST['title'] ?? ''),
        'badge'        => trim($_POST['badge'] ?? ''),
        'last_updated' => trim($_POST['last_updated'] ?? date('F Y')),
        'lead_summary' => trim($_POST['lead_summary'] ?? ''),
        'content'      => trim($_POST['content'] ?? '')
    ];

    if (empty($policyData['title'])) {
        ck_set_flash('error', 'Policy title cannot be empty.');
        header("Location: legal-pages.php?tab={$postTab}");
        exit;
    }

    $saved = ck_save_legal_policy($postTab, $policyData);
    if ($saved) {
        $name = htmlspecialchars($policyData['title']);
        ck_set_flash('success', "Legal document '{$name}' was successfully updated and is live on the website!");
    } else {
        ck_set_flash('error', 'Failed to save legal policy to file storage.');
    }
    header("Location: legal-pages.php?tab={$postTab}");
    exit;
}

$policies = ck_get_legal_policies();
$currentPolicy = $policies[$tab] ?? [
    'title'        => 'Legal Policy',
    'badge'        => 'LEGAL',
    'last_updated' => date('F Y'),
    'lead_summary' => '',
    'content'      => ''
];

$tabMeta = [
    'privacy'    => ['icon' => '🔒', 'name' => 'Privacy Policy',       'url' => '../privacy-policy.php'],
    'terms'      => ['icon' => '⚖️', 'name' => 'Terms & Conditions',   'url' => '../terms-conditions.php'],
    'disclosure' => ['icon' => '🛡️', 'name' => 'Security Disclosure', 'url' => '../security-disclosure.php']
];

$adminPageTitle = 'Legal & Policy Management';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Legal Documents &amp; Policy Management</h1>
        <p class="page-header-desc">
            Edit client-facing privacy policies, terms of service, and vulnerability disclosure standards displayed in website footers and compliance dockets.
        </p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="<?= htmlspecialchars($tabMeta[$tab]['url']) ?>" target="_blank" class="btn btn-secondary btn-sm" title="Preview live legal page in new tab">
            Preview Live Policy ➔
        </a>
    </div>
</div>

<!-- ================= POLICY TAB SELECTOR ================= -->
<div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; flex-wrap: wrap; border-bottom: 1px solid rgba(158, 62, 255, 0.2); padding-bottom: 0.85rem;">
    <?php foreach ($tabMeta as $tKey => $meta): ?>
        <a href="legal-pages.php?tab=<?= $tKey ?>"
           class="btn btn-sm <?= ($tab === $tKey) ? 'btn-primary' : 'btn-secondary' ?>"
           style="display: inline-flex; align-items: center; gap: 0.45rem; padding: 0.55rem 1.15rem; font-weight: 700;">
            <span><?= $meta['icon'] ?></span>
            <span><?= htmlspecialchars($meta['name']) ?></span>
            <?php if (!empty($policies[$tKey]['updated_at'])): ?>
                <span style="font-size: 0.65rem; opacity: 0.75; font-weight: 500;">(Saved)</span>
            <?php endif; ?>
        </a>
    <?php endforeach; ?>
</div>

<!-- ================= POLICY EDIT FORM CARD ================= -->
<div class="admin-card">
    <div class="admin-card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h3 class="admin-card-title" style="display: flex; align-items: center; gap: 0.5rem;">
                <span><?= $tabMeta[$tab]['icon'] ?></span>
                <span>Editing: <?= htmlspecialchars($currentPolicy['title'] ?? $tabMeta[$tab]['name']) ?></span>
            </h3>
            <span style="font-size: 0.8rem; color: var(--text-muted);">
                Target URL: <code><?= htmlspecialchars($tabMeta[$tab]['url']) ?></code>
            </span>
        </div>
        <div>
            <span class="status-pill active" style="font-size: 0.72rem;">
                Last Revised: <?= htmlspecialchars($currentPolicy['last_updated'] ?? date('F Y')) ?>
            </span>
        </div>
    </div>

    <div class="admin-card-body">
        <form method="POST" action="legal-pages.php?tab=<?= htmlspecialchars($tab) ?>" id="policyForm">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="policy_key" value="<?= htmlspecialchars($tab) ?>">

            <div class="form-grid">
                <!-- Title -->
                <div class="form-group">
                    <label for="policy_title" class="form-label">Document Title <span class="required">*</span></label>
                    <input type="text" id="policy_title" name="title" class="form-control" required value="<?= htmlspecialchars($currentPolicy['title'] ?? '') ?>">
                    <span class="form-help">Headline displayed as the main title of this legal policy.</span>
                </div>

                <!-- Badge -->
                <div class="form-group">
                    <label for="policy_badge" class="form-label">Section Tag Pill</label>
                    <input type="text" id="policy_badge" name="badge" class="form-control" placeholder="e.g. DATA PRIVACY & COMPLIANCE" value="<?= htmlspecialchars($currentPolicy['badge'] ?? '') ?>">
                    <span class="form-help">Small illuminated tag pill rendered above the policy headline.</span>
                </div>

                <!-- Last Revised Date -->
                <div class="form-group">
                    <label for="policy_last_updated" class="form-label">Revision Notice / Date <span class="required">*</span></label>
                    <input type="text" id="policy_last_updated" name="last_updated" class="form-control" required placeholder="e.g. November 2026 or November 6, 2026" value="<?= htmlspecialchars($currentPolicy['last_updated'] ?? date('F Y')) ?>">
                    <span class="form-help">Effective revision date visible to clients and auditing bodies.</span>
                </div>

                <!-- Summary -->
                <div class="form-group col-full">
                    <label for="policy_lead_summary" class="form-label">Lead Overview Summary <span class="required">*</span></label>
                    <textarea id="policy_lead_summary" name="lead_summary" rows="2" class="form-control" required placeholder="Executive summary paragraph introducing this legal document..."><?= htmlspecialchars($currentPolicy['lead_summary'] ?? '') ?></textarea>
                    <span class="form-help">Introductory paragraph rendered in the page header.</span>
                </div>

                <!-- Content Area with Formatting Bar -->
                <div class="form-group col-full">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.5rem; flex-wrap: wrap; gap: 0.5rem;">
                        <label for="policy_content" class="form-label" style="margin: 0;">
                            Full Legal Document Content (HTML Supported) <span class="required">*</span>
                        </label>
                        <div style="display: flex; gap: 0.35rem; flex-wrap: wrap;">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="insertSnippet('heading')" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" title="Insert Heading 3">+ Section Heading</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="insertSnippet('paragraph')" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" title="Insert Paragraph">+ Paragraph</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="insertSnippet('list')" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" title="Insert Bullet List">+ Bullet List</button>
                            <button type="button" class="btn btn-secondary btn-sm" onclick="insertSnippet('callout')" style="font-size: 0.75rem; padding: 0.25rem 0.65rem;" title="Insert Highlight Callout">+ Callout Box</button>
                        </div>
                    </div>
                    <textarea id="policy_content" name="content" rows="18" class="form-control" required style="font-family: Consolas, 'Courier New', monospace; font-size: 0.88rem; line-height: 1.6;"><?= htmlspecialchars($currentPolicy['content'] ?? '') ?></textarea>
                    <span class="form-help">
                        Clean HTML formatting is supported: <code>&lt;h3&gt;Section Title&lt;/h3&gt;</code>, <code>&lt;p&gt;Text&lt;/p&gt;</code>, <code>&lt;ul&gt;&lt;li&gt;Item&lt;/li&gt;&lt;/ul&gt;</code>, <code>&lt;strong&gt;Bold&lt;/strong&gt;</code>, <code>&lt;a href="..."&gt;Link&lt;/a&gt;</code>.
                    </span>
                </div>
            </div>

            <div style="margin-top: 1.75rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="font-size: 0.82rem; color: var(--text-muted);">
                    Changes take effect immediately on public URLs.
                </div>
                <div style="display: flex; gap: 0.75rem;">
                    <a href="index.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="padding: 0.65rem 1.6rem;">
                        <span>💾</span> Save <?= htmlspecialchars($tabMeta[$tab]['name']) ?>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function insertSnippet(type) {
    const textarea = document.getElementById('policy_content');
    if (!textarea) return;

    let snippet = '';
    if (type === 'heading') {
        snippet = "\n\n<h3>New Section Heading</h3>\n<p>Add descriptive paragraph here explaining this clause or policy commitment.</p>\n";
    } else if (type === 'paragraph') {
        snippet = "\n<p>Your paragraph text goes here.</p>\n";
    } else if (type === 'list') {
        snippet = "\n<ul>\n    <li>First specification item or guideline</li>\n    <li>Second specification item or guideline</li>\n    <li>Third specification item or guideline</li>\n</ul>\n";
    } else if (type === 'callout') {
        snippet = "\n<div style=\"padding: 1rem 1.25rem; background: rgba(158,62,255,0.08); border-left: 3px solid #00f0ff; border-radius: 6px; margin: 1.25rem 0;\">\n    <strong>Important Note:</strong> Highlighted notice or safe-harbor guideline for clients and researchers.\n</div>\n";
    }

    const startPos = textarea.selectionStart;
    const endPos = textarea.selectionEnd;
    textarea.value = textarea.value.substring(0, startPos) + snippet + textarea.value.substring(endPos, textarea.value.length);
    textarea.focus();
    textarea.selectionStart = startPos + snippet.length;
    textarea.selectionEnd = startPos + snippet.length;
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

