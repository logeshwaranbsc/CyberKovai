<?php
/**
 * Cyber Kovai - Incidents & Threats We Investigate (Word Cloud Tags CRUD)
 * Allows managing tag text, display size hierarchy (xl, lg, md, sm),
 * cyberpunk neon accent colors, display order, and status.
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action        = $_GET['action'] ?? 'list';
$editId        = $_GET['id'] ?? null;
$currentStatus = $_GET['status'] ?? 'all';
$currentAccent = $_GET['accent'] ?? 'all';
$currentSize   = $_GET['size'] ?? 'all';
$searchQuery   = trim($_GET['q'] ?? '');

$siteSettings = ck_get_settings();

// Handle Form Submissions (Create, Update, Delete, Toggle Status, Update Heading)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: investigation-threats.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    // 1. Delete Threat Tag
    if ($postAction === 'delete') {
        $deleteId = $_POST['id'] ?? '';
        if (!empty($deleteId)) {
            $threat = ck_get_investigation_threat($deleteId);
            $tName  = $threat['text'] ?? "Tag #{$deleteId}";
            $deleted = ck_delete_investigation_threat($deleteId);
            if ($deleted) {
                ck_set_flash('success', "Threat tag '{$tName}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete threat tag '{$tName}'.");
            }
        }
        header('Location: investigation-threats.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    // 2. Toggle Status (Active / Hidden)
    if ($postAction === 'toggle_status') {
        $toggleId = $_POST['id'] ?? '';
        if (!empty($toggleId)) {
            $newStatus = ck_toggle_investigation_threat_status($toggleId);
            if ($newStatus !== false) {
                $threat = ck_get_investigation_threat($toggleId);
                $tName  = $threat['text'] ?? "Tag #{$toggleId}";
                if ($newStatus === 'active') {
                    ck_set_flash('success', "Threat tag '{$tName}' is now ACTIVE and visible on the website.");
                } else {
                    ck_set_flash('success', "Threat tag '{$tName}' is now HIDDEN from the website.");
                }
            } else {
                ck_set_flash('error', 'Could not toggle threat tag status.');
            }
        }
        header('Location: investigation-threats.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    // 3. Save (Create or Update) Threat Tag
    if ($postAction === 'save') {
        $id     = !empty($_POST['id']) ? trim($_POST['id']) : null;
        $text   = trim($_POST['text'] ?? '');
        $size   = trim($_POST['size'] ?? 'md');
        $accent = trim($_POST['accent'] ?? 'purple');
        $status = $_POST['status'] ?? 'active';

        if ($text === '') {
            ck_set_flash('error', 'Threat / Incident tag text cannot be empty.');
            header('Location: investigation-threats.php?action=' . ($id ? "edit&id={$id}" : 'add'));
            exit;
        }

        $allExisting = ck_get_investigation_threats(true);
        $order = isset($_POST['order']) && $_POST['order'] !== '' ? (int)$_POST['order'] : (count($allExisting) + 1);

        $threatData = [
            'id'     => $id,
            'text'   => $text,
            'size'   => $size,
            'accent' => $accent,
            'order'  => $order,
            'status' => $status
        ];

        $saved = ck_save_investigation_threat($threatData, $id);
        if ($saved) {
            ck_set_flash('success', "Threat tag '{$text}' was successfully saved!");
            header('Location: investigation-threats.php');
            exit;
        } else {
            ck_set_flash('error', 'Failed to save threat tag to storage.');
        }
    }

    // 4. Save Section Heading & Subtitle
    if ($postAction === 'save_heading') {
        $sectionTitle = trim($_POST['section_title'] ?? '');
        $sectionSubtitle = trim($_POST['section_subtitle'] ?? '');

        $settings = ck_get_settings();
        $settings['investigation_threats_title'] = $sectionTitle ?: 'Incidents & Threats We <span class="ci-grad-text">Investigate</span>';
        $settings['investigation_threats_subtitle'] = $sectionSubtitle ?: 'Specialized investigative capabilities across diverse cybercrime, financial fraud, and digital dispute categories.';

        if (ck_save_settings($settings)) {
            ck_set_flash('success', 'Section heading and description successfully updated!');
        } else {
            ck_set_flash('error', 'Failed to save section heading.');
        }
        header('Location: investigation-threats.php');
        exit;
    }
}

// Fetch current item if editing
$editingItem = null;
if ($action === 'edit' && $editId) {
    $editingItem = ck_get_investigation_threat($editId);
    if (!$editingItem) {
        ck_set_flash('error', "Threat tag #{$editId} was not found.");
        header('Location: investigation-threats.php');
        exit;
    }
}

$allThreatsList = ck_get_investigation_threats(true);
$activeCount    = 0;
$hiddenCount    = 0;
foreach ($allThreatsList as $t) {
    if (($t['status'] ?? 'active') === 'active') {
        $activeCount++;
    } else {
        $hiddenCount++;
    }
}

// Filter dataset
$displayList = $allThreatsList;

if ($currentStatus === 'active') {
    $displayList = array_filter($displayList, function($t) {
        return ($t['status'] ?? 'active') === 'active';
    });
} elseif ($currentStatus === 'inactive') {
    $displayList = array_filter($displayList, function($t) {
        return ($t['status'] ?? 'active') === 'inactive';
    });
}

if ($currentAccent !== 'all') {
    $displayList = array_filter($displayList, function($t) use ($currentAccent) {
        return ($t['accent'] ?? 'purple') === $currentAccent;
    });
}

if ($currentSize !== 'all') {
    $displayList = array_filter($displayList, function($t) use ($currentSize) {
        return ($t['size'] ?? 'md') === $currentSize;
    });
}

if ($searchQuery !== '') {
    $needle = mb_strtolower($searchQuery);
    $displayList = array_filter($displayList, function($t) use ($needle) {
        return mb_strpos(mb_strtolower($t['text'] ?? ''), $needle) !== false;
    });
}

// Palette Definitions
$accentsMeta = [
    'purple'  => ['label' => 'Cyber Violet',   'color' => '#c084fc', 'border' => 'rgba(192, 132, 252, 0.45)'],
    'cyan'    => ['label' => 'Neon Cyan',      'color' => '#22d3ee', 'border' => 'rgba(34, 211, 238, 0.45)'],
    'emerald' => ['label' => 'Emerald Shield', 'color' => '#34d399', 'border' => 'rgba(52, 211, 153, 0.45)'],
    'amber'   => ['label' => 'Amber Alert',    'color' => '#fbbf24', 'border' => 'rgba(251, 191, 36, 0.45)'],
    'rose'    => ['label' => 'Rose Flare',     'color' => '#fb7185', 'border' => 'rgba(251, 113, 133, 0.45)'],
];

$sizesMeta = [
    'xl' => ['label' => 'Extra Large (XL)', 'desc' => 'High visibility / primary pillar'],
    'lg' => ['label' => 'Large (LG)',       'desc' => 'Major threat category'],
    'md' => ['label' => 'Medium (MD)',      'desc' => 'Standard incident tag'],
    'sm' => ['label' => 'Small (SM)',       'desc' => 'Specific forensic technique'],
];

$adminPageTitle = 'Investigation Threats & Incidents Cloud';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Incidents &amp; Threats We Investigate</h1>
        <p class="page-header-desc">Manage 3D keyword globe tags, display hierarchy, and cyber neon accents displayed on the Digital Investigation page.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <?php if ($action === 'list'): ?>
            <a href="investigation-threats.php?action=add" class="btn btn-primary">
                <span>+</span> Add Threat Tag
            </a>
            <a href="../cyber-intelligence.php#ci-risks" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Digital Investigation page">
                Preview on Website ➔
            </a>
            <a href="services-investigation.php" class="btn btn-secondary btn-sm" title="Manage 8 Investigation Practices">
                🔍 Practices List
            </a>
        <?php else: ?>
            <a href="investigation-threats.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" class="btn btn-secondary">
                &larr; Back to Threats List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Threat Tag: ' . htmlspecialchars($editingItem['text']) : 'Add New Threat / Incident Tag' ?></h3>
        <span class="category-tag" style="background: rgba(139, 32, 255, 0.15); color: var(--accent-purple-light);">
            <?= ($action === 'edit') ? 'Tag ID: #' . htmlspecialchars($editingItem['id']) : 'New Word Cloud Chip' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="investigation-threats.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id']) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <!-- Tag Text -->
                <div class="form-group col-full">
                    <label for="threat_text" class="form-label">Threat / Incident Label <span class="required">*</span></label>
                    <input type="text" id="threat_text" name="text" class="form-control" required placeholder="e.g. Crypto & Blockchain Tracing, Ransomware Incident Triage" value="<?= htmlspecialchars($editingItem['text'] ?? '') ?>">
                    <span class="form-help">Text displayed inside the pill chip. Keep concise and impactful.</span>
                </div>

                <!-- Tag Size Hierarchy -->
                <div class="form-group">
                    <label for="threat_size" class="form-label">Size Hierarchy <span class="required">*</span></label>
                    <select id="threat_size" name="size" class="form-control" style="font-weight: 600;">
                        <?php foreach ($sizesMeta as $sKey => $sData): ?>
                            <option value="<?= $sKey ?>" <?= (($editingItem['size'] ?? 'md') === $sKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sData['label']) ?> — <?= htmlspecialchars($sData['desc']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form-help">Controls typography prominence and padding in the word cloud.</span>
                </div>

                <!-- Tag Accent Palette -->
                <div class="form-group">
                    <label for="threat_accent" class="form-label">Cyber Accent Color <span class="required">*</span></label>
                    <select id="threat_accent" name="accent" class="form-control" style="font-weight: 600;">
                        <?php foreach ($accentsMeta as $aKey => $aData): ?>
                            <option value="<?= $aKey ?>" <?= (($editingItem['accent'] ?? 'purple') === $aKey) ? 'selected' : '' ?>>
                                ● <?= htmlspecialchars($aData['label']) ?> (<?= $aKey ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span class="form-help">Glowing indicator dot color, border glow, and hover reflection.</span>
                </div>

                <!-- Order Sequence -->
                <div class="form-group">
                    <label for="threat_order" class="form-label">Display Order Sequence</label>
                    <input type="number" id="threat_order" name="order" class="form-control" min="1" value="<?= htmlspecialchars($editingItem['order'] ?? (count($allThreatsList) + 1)) ?>">
                    <span class="form-help">Placement sequence in the word-cloud flow (1 = first chip).</span>
                </div>

                <!-- Publication Status -->
                <div class="form-group">
                    <label for="threat_status" class="form-label">Publication Status</label>
                    <select id="threat_status" name="status" class="form-control" style="font-weight: 600;">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Hidden (Hide from Website)</option>
                    </select>
                    <span class="form-help">Toggle between active public visibility and draft mode.</span>
                </div>

                <!-- LIVE REAL-TIME PREVIEW BOX -->
                <div class="form-group col-full">
                    <label class="form-label">Live Pill Preview (Real-time)</label>
                    <div style="background: radial-gradient(circle at center, #150f2e 0%, #060513 100%); padding: 2.25rem 1.5rem; border-radius: 14px; border: 1px dashed var(--border-color); display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 140px; box-shadow: inset 0 2px 14px rgba(0,0,0,0.6);">
                        <div id="livePillPreview" class="ci-risk-tag tag-<?= htmlspecialchars($editingItem['size'] ?? 'md') ?> accent-<?= htmlspecialchars($editingItem['accent'] ?? 'purple') ?>" style="cursor: pointer;" title="Hover to test animation!">
                            <span class="ci-risk-dot"></span>
                            <span id="livePillText"><?= htmlspecialchars($editingItem['text'] ?? 'Threat Tag Preview') ?></span>
                        </div>
                        <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 1.25rem; letter-spacing: 0.02em;">
                            Interactive preview: Move your mouse over the pill above to test the hover glow and scaling effects.
                        </p>
                    </div>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="investigation-threats.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Threat Tag
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const textInput   = document.getElementById('threat_text');
    const sizeSelect  = document.getElementById('threat_size');
    const accentSelect = document.getElementById('threat_accent');
    const pillPreview = document.getElementById('livePillPreview');
    const pillText    = document.getElementById('livePillText');

    function updateLivePreview() {
        if (!pillPreview || !pillText) return;
        
        const rawText = textInput.value.trim();
        pillText.textContent = rawText !== '' ? rawText : 'Threat Tag Preview';

        const sizeVal = sizeSelect.value || 'md';
        const accentVal = accentSelect.value || 'purple';

        // Reset classes
        pillPreview.className = 'ci-risk-tag tag-' + sizeVal + ' accent-' + accentVal;
    }

    if (textInput) textInput.addEventListener('input', updateLivePreview);
    if (sizeSelect) sizeSelect.addEventListener('change', updateLivePreview);
    if (accentSelect) accentSelect.addEventListener('change', updateLivePreview);
});
</script>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->

<!-- Current Section Heading Callout Card -->
<div class="section-heading-card">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
            <div class="section-heading-badge">
                <span class="section-heading-badge-dot"></span>
                <span>Front-End Section Heading &amp; Subtitle</span>
            </div>
            <h2 class="section-heading-title">
                <?= $siteSettings['investigation_threats_title'] ?? 'Incidents &amp; Threats We <span class="ci-grad-text">Investigate</span>' ?>
            </h2>
            <p class="section-heading-subtitle">
                <?= htmlspecialchars($siteSettings['investigation_threats_subtitle'] ?? 'Specialized investigative capabilities across diverse cybercrime, financial fraud, and digital dispute categories.') ?>
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="openModal('editHeadingModal')" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.6rem 1.15rem; font-weight: 600; border-color: rgba(158, 62, 255, 0.45); background: rgba(158, 62, 255, 0.14);">
                <span>✏️</span>
                <span>Edit Section Heading</span>
            </button>
        </div>
    </div>
</div>

<!-- Filters Bar -->
<div style="display: flex; gap: 1rem; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">
    <!-- Status Filter Buttons -->
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="investigation-threats.php?status=all<?= $currentAccent !== 'all' ? "&accent={$currentAccent}" : '' ?><?= $currentSize !== 'all' ? "&size={$currentSize}" : '' ?>" class="btn btn-sm <?= ($currentStatus === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
            All Tags (<?= count($allThreatsList) ?>)
        </a>
        <a href="investigation-threats.php?status=active<?= $currentAccent !== 'all' ? "&accent={$currentAccent}" : '' ?><?= $currentSize !== 'all' ? "&size={$currentSize}" : '' ?>" class="btn btn-sm <?= ($currentStatus === 'active') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'active') ? 'background: #00e676; border-color: #00e676; color: #000;' : '' ?>">
            ● Active (<?= $activeCount ?>)
        </a>
        <a href="investigation-threats.php?status=inactive<?= $currentAccent !== 'all' ? "&accent={$currentAccent}" : '' ?><?= $currentSize !== 'all' ? "&size={$currentSize}" : '' ?>" class="btn btn-sm <?= ($currentStatus === 'inactive') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'inactive') ? 'background: #ffab00; border-color: #ffab00; color: #000;' : '' ?>">
            ○ Hidden (<?= $hiddenCount ?>)
        </a>
    </div>

    <!-- Quick Search & Dropdown Filters Form -->
    <form method="GET" action="investigation-threats.php" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; margin: 0;">
        <input type="hidden" name="status" value="<?= htmlspecialchars($currentStatus) ?>">

        <select name="accent" class="form-control" style="width: auto; padding: 0.4rem 0.75rem; font-size: 0.82rem;" onchange="this.form.submit()">
            <option value="all">All Accents</option>
            <?php foreach ($accentsMeta as $aKey => $aData): ?>
                <option value="<?= $aKey ?>" <?= ($currentAccent === $aKey) ? 'selected' : '' ?>>
                    ● <?= htmlspecialchars($aData['label']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="size" class="form-control" style="width: auto; padding: 0.4rem 0.75rem; font-size: 0.82rem;" onchange="this.form.submit()">
            <option value="all">All Sizes</option>
            <?php foreach ($sizesMeta as $sKey => $sData): ?>
                <option value="<?= $sKey ?>" <?= ($currentSize === $sKey) ? 'selected' : '' ?>>
                    <?= strtoupper($sKey) ?> (<?= htmlspecialchars(explode(' (', $sData['label'])[0]) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="q" class="form-control" placeholder="Search threats..." value="<?= htmlspecialchars($searchQuery) ?>" style="width: 180px; padding: 0.4rem 0.75rem; font-size: 0.82rem;">
        
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        <?php if ($currentAccent !== 'all' || $currentSize !== 'all' || $searchQuery !== ''): ?>
            <a href="investigation-threats.php?status=<?= htmlspecialchars($currentStatus) ?>" class="btn btn-secondary btn-sm" title="Clear filters">✕</a>
        <?php endif; ?>
    </form>
</div>

<!-- Main Table Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            Threat &amp; Incident Word Cloud Tags (<?= count($displayList) ?>)
        </h3>
        <a href="investigation-threats.php?action=add" class="btn btn-primary btn-sm">
            + Add Threat Tag
        </a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th style="min-width: 240px;">Live Pill Preview</th>
                    <th>Threat / Incident Name</th>
                    <th>Size Hierarchy</th>
                    <th>Cyber Accent</th>
                    <th style="width: 70px;">Order</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($displayList)): ?>
                    <?php foreach ($displayList as $t): ?>
                        <?php 
                            $tId     = $t['id'] ?? '';
                            $tText   = $t['text'] ?? '';
                            $tSize   = $t['size'] ?? 'md';
                            $tAccent = $t['accent'] ?? 'purple';
                            $tOrder  = $t['order'] ?? 1;
                            $tStatus = $t['status'] ?? 'active';
                            $accentInfo = $accentsMeta[$tAccent] ?? ['label' => $tAccent, 'color' => '#c084fc'];
                        ?>
                        <tr>
                            <td>
                                <span style="font-size: 0.78rem; font-weight: 700; color: var(--text-muted);">
                                    #<?= htmlspecialchars($tId) ?>
                                </span>
                            </td>
                            <td>
                                <div class="ci-risk-tag tag-<?= htmlspecialchars($tSize) ?> accent-<?= htmlspecialchars($tAccent) ?>">
                                    <span class="ci-risk-dot"></span>
                                    <span><?= htmlspecialchars($tText) ?></span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #fff; font-size: 0.92rem;">
                                    <?= htmlspecialchars($tText) ?>
                                </span>
                            </td>
                            <td>
                                <span class="category-tag" style="font-size: 0.75rem; text-transform: uppercase;">
                                    <?= htmlspecialchars($tSize) ?>
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.45rem;">
                                    <span style="width: 10px; height: 10px; border-radius: 50%; background: <?= $accentInfo['color'] ?>; box-shadow: 0 0 6px <?= $accentInfo['color'] ?>; display: inline-block;"></span>
                                    <span style="font-size: 0.82rem; color: var(--text-secondary);">
                                        <?= htmlspecialchars($accentInfo['label']) ?>
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem;">
                                    <?= (int)$tOrder ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" action="investigation-threats.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" style="display:inline; margin:0;">
                                    <?= ck_csrf_field() ?>
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($tId) ?>">
                                    <?php if ($tStatus === 'active'): ?>
                                        <button type="submit" class="status-pill active" style="cursor: pointer; border: 1px solid rgba(0, 230, 118, 0.3);" title="Click to hide from website">
                                            ● ACTIVE
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="status-pill inactive" style="cursor: pointer; background: rgba(255,171,0,0.15); color: #ffab00; border-color: rgba(255,171,0,0.3);" title="Click to make visible on website">
                                            ○ HIDDEN
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-btns-group" style="justify-content: flex-end;">
                                    <form method="POST" action="investigation-threats.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" style="display:inline; margin:0;">
                                        <?= ck_csrf_field() ?>
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($tId) ?>">
                                        <?php if ($tStatus === 'active'): ?>
                                            <button type="submit" class="btn-action hide" title="Hide tag from website">
                                                Hide
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn-action show" title="Make tag visible on website">
                                                Show
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="investigation-threats.php?action=edit&id=<?= urlencode($tId) ?>" class="btn-action edit" title="Edit tag">Edit</a>
                                    <button type="button" class="btn-action delete" title="Delete tag" onclick="confirmDelete('investigation-threats.php', '<?= htmlspecialchars(addslashes($tText)) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'id\' value=\'<?= htmlspecialchars($tId) ?>\'>';">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2.75rem; color: var(--text-muted);">
                            No threats or incident tags matched the chosen filters. Click "Add Threat Tag" above to create one.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- ================= EDIT SECTION HEADING MODAL ================= -->
<div class="admin-modal-backdrop" id="editHeadingModal">
    <div class="admin-modal" style="max-width: 620px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Incidents &amp; Threats Section Heading</h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('editHeadingModal')">&times;</button>
        </div>
        <form method="POST" action="investigation-threats.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save_heading">
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="modal_section_title" class="form-label">Section Heading Title <span class="required">*</span></label>
                    <input type="text" id="modal_section_title" name="section_title" class="form-control" required value="<?= htmlspecialchars($siteSettings['investigation_threats_title'] ?? 'Incidents & Threats We <span class="ci-grad-text">Investigate</span>') ?>">
                    <span class="form-help">HTML allowed (e.g. <code>&lt;span class="ci-grad-text"&gt;Investigate&lt;/span&gt;</code> for violet gradient accent).</span>
                </div>
                <div class="form-group">
                    <label for="modal_section_subtitle" class="form-label">Section Subtitle / Description <span class="required">*</span></label>
                    <textarea id="modal_section_subtitle" name="section_subtitle" rows="3" class="form-control" required><?= htmlspecialchars($siteSettings['investigation_threats_subtitle'] ?? 'Specialized investigative capabilities across diverse cybercrime, financial fraud, and digital dispute categories.') ?></textarea>
                    <span class="form-help">Supporting paragraph rendered right below the section title on the website.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editHeadingModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Section Heading</button>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

