<?php
/**
 * Cyber Kovai - Core Cyber Practices Management (Bento Grid CRUD)
 * Allows managing the Bento Grid items on the main Cyber Security / Forensics page:
 * title, slug, dossier tag, hero spotlight status, badges, order, and live status.
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action        = $_GET['action'] ?? 'list';
$editId        = $_GET['id'] ?? null;
$currentStatus = $_GET['status'] ?? 'all';
$currentHero   = $_GET['hero'] ?? 'all';
$searchQuery   = trim($_GET['q'] ?? '');

$cyberPracticesSettings = ck_get_cyber_practices_settings();
$registeredCyberServices = function_exists('ck_get_cyber_services') ? ck_get_cyber_services(true) : [];

// Handle Form Submissions (Create, Update, Delete, Toggle Status, Update Heading)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: cyber-practices.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    // 1. Delete Practice
    if ($postAction === 'delete') {
        $deleteId = $_POST['id'] ?? '';
        if (!empty($deleteId)) {
            $practice = ck_get_cyber_practice($deleteId);
            $pTitle = $practice['title'] ?? "Practice #{$deleteId}";
            $deleted = ck_delete_cyber_practice($deleteId);
            if ($deleted) {
                ck_set_flash('success', "Core practice '{$pTitle}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete core practice '{$pTitle}'.");
            }
        }
        header('Location: cyber-practices.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    // 2. Toggle Status (Active / Hidden)
    if ($postAction === 'toggle_status') {
        $toggleId = $_POST['id'] ?? '';
        if (!empty($toggleId)) {
            $newStatus = ck_toggle_cyber_practice_status($toggleId);
            if ($newStatus !== false) {
                $practice = ck_get_cyber_practice($toggleId);
                $pTitle = $practice['title'] ?? "Practice #{$toggleId}";
                if ($newStatus === 'active') {
                    ck_set_flash('success', "Practice '{$pTitle}' is now ACTIVE and visible in the Bento Grid.");
                } else {
                    ck_set_flash('success', "Practice '{$pTitle}' is now HIDDEN from the Bento Grid.");
                }
            } else {
                ck_set_flash('error', 'Could not toggle practice status.');
            }
        }
        header('Location: cyber-practices.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    // 3. Save (Create or Update) Practice
    if ($postAction === 'save') {
        $id     = !empty($_POST['id']) ? trim($_POST['id']) : null;
        $title  = trim($_POST['title'] ?? '');
        $code   = trim($_POST['code'] ?? '');
        $slug   = trim($_POST['slug'] ?? '');
        $link   = trim($_POST['link'] ?? '');
        $tag    = trim($_POST['tag'] ?? '');
        $badge  = trim($_POST['badge'] ?? '');
        $statusText = trim($_POST['status_text'] ?? 'ARMORED');
        $icon   = trim($_POST['icon'] ?? '🛡️');
        $isHero = !empty($_POST['is_hero']);
        $status = in_array($_POST['status'] ?? '', ['active', 'inactive'], true) ? $_POST['status'] : 'active';
        $desc   = trim($_POST['description'] ?? '');

        if ($title === '') {
            ck_set_flash('error', 'Practice title cannot be empty.');
            header('Location: cyber-practices.php?action=' . ($id ? "edit&id={$id}" : 'add'));
            exit;
        }

        $allExisting = ck_get_cyber_practices(true);
        $order = (isset($_POST['order']) && $_POST['order'] !== '') ? (int)$_POST['order'] : (count($allExisting) + 1);

        $practiceData = [
            'id'          => $id,
            'title'       => $title,
            'code'        => $code,
            'slug'        => $slug,
            'link'        => $link,
            'tag'         => $tag,
            'badge'       => $badge,
            'status_text' => $statusText ?: 'ARMORED',
            'icon'        => $icon ?: '🛡️',
            'is_hero'     => $isHero,
            'order'       => $order,
            'status'      => $status,
            'description' => $desc
        ];

        $saved = ck_save_cyber_practice($practiceData, $id);
        if ($saved) {
            ck_set_flash('success', "Core practice '{$title}' was successfully saved!");
            header('Location: cyber-practices.php');
            exit;
        } else {
            ck_set_flash('error', 'Failed to save practice to storage.');
        }
    }

    // 4. Save Section Heading & Subtitle
    if ($postAction === 'save_heading') {
        $sectionTag      = trim($_POST['section_tag'] ?? 'OUR PRACTICES');
        $sectionTitle    = trim($_POST['section_title'] ?? '');
        $sectionSubtitle = trim($_POST['section_subtitle'] ?? '');

        $settingsToSave = [
            'tag'      => $sectionTag ?: 'OUR PRACTICES',
            'title'    => $sectionTitle ?: 'Core Cyber Practices. One Standard: <span>Uncompromising Defense.</span>',
            'subtitle' => $sectionSubtitle ?: 'Comprehensive offensive and defensive cybersecurity practices engineered for modern digital enterprises.'
        ];

        if (ck_save_cyber_practices_settings($settingsToSave)) {
            ck_set_flash('success', 'Bento Grid section heading &amp; description successfully updated!');
        } else {
            ck_set_flash('error', 'Failed to save section settings.');
        }
        header('Location: cyber-practices.php');
        exit;
    }
}

// Fetch current item if editing
$editingItem = null;
if ($action === 'edit' && $editId) {
    $editingItem = ck_get_cyber_practice($editId);
    if (!$editingItem) {
        ck_set_flash('error', "Core practice #{$editId} was not found.");
        header('Location: cyber-practices.php');
        exit;
    }
}

$allPracticesList = ck_get_cyber_practices(true);
$activeCount      = 0;
$hiddenCount      = 0;
$heroCount        = 0;

foreach ($allPracticesList as $p) {
    if (($p['status'] ?? 'active') === 'active') {
        $activeCount++;
    } else {
        $hiddenCount++;
    }
    if (!empty($p['is_hero'])) {
        $heroCount++;
    }
}

// Filter dataset
$displayList = $allPracticesList;

if ($currentStatus === 'active') {
    $displayList = array_filter($displayList, function($p) {
        return ($p['status'] ?? 'active') === 'active';
    });
} elseif ($currentStatus === 'inactive') {
    $displayList = array_filter($displayList, function($p) {
        return ($p['status'] ?? 'active') === 'inactive';
    });
}

if ($currentHero === 'hero') {
    $displayList = array_filter($displayList, function($p) {
        return !empty($p['is_hero']);
    });
} elseif ($currentHero === 'standard') {
    $displayList = array_filter($displayList, function($p) {
        return empty($p['is_hero']);
    });
}

if ($searchQuery !== '') {
    $needle = mb_strtolower($searchQuery);
    $displayList = array_filter($displayList, function($p) use ($needle) {
        return mb_strpos(mb_strtolower($p['title'] ?? ''), $needle) !== false
            || mb_strpos(mb_strtolower($p['tag'] ?? ''), $needle) !== false
            || mb_strpos(mb_strtolower($p['slug'] ?? ''), $needle) !== false
            || mb_strpos(mb_strtolower($p['description'] ?? ''), $needle) !== false;
    });
}

$adminPageTitle = 'Core Cyber Practices (Bento Grid)';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Core Cyber Practices (Bento Grid)</h1>
        <p class="page-header-desc">Manage the interactive Bento Grid capabilities, hero highlights, links, badges, and section headings shown on the website.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <?php if ($action === 'list'): ?>
            <a href="cyber-practices.php?action=add" class="btn btn-primary">
                <span>+</span> Add Core Practice
            </a>
            <a href="../digital-forensics.php#services" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Digital Forensics / Cyber Security page">
                Preview on Website ➔
            </a>
            <a href="services-cyber.php" class="btn btn-secondary btn-sm" title="Manage Cyber Services details">
                🛡️ Cyber Services
            </a>
        <?php else: ?>
            <a href="cyber-practices.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" class="btn btn-secondary">
                &larr; Back to Practices List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Core Practice: ' . htmlspecialchars($editingItem['title']) : 'Add New Core Cyber Practice' ?></h3>
        <span class="category-tag" style="background: rgba(139, 32, 255, 0.15); color: var(--accent-purple-light);">
            <?= ($action === 'edit') ? 'ID: #' . htmlspecialchars($editingItem['id']) : 'New Bento Card' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="cyber-practices.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id']) ?>">
            <?php endif; ?>

            <!-- Helper Quick-Fill from Registered Services -->
            <div style="margin-bottom: 1.5rem; padding: 1rem 1.25rem; background: rgba(158,62,255,0.08); border: 1px solid rgba(158,62,255,0.25); border-radius: 8px;">
                <label for="service_picker" style="display: block; font-size: 0.82rem; font-weight: 700; color: var(--accent-purple-light); margin-bottom: 0.35rem; text-transform: uppercase; letter-spacing: 0.05em;">
                    ⚡ Quick-Fill from Cyber Services (Optional)
                </label>
                <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
                    <select id="service_picker" class="form-control" style="flex: 1; min-width: 260px;" onchange="populateFromService(this)">
                        <option value="">-- Choose a registered cyber service to autofill --</option>
                        <?php foreach ($registeredCyberServices as $sSlug => $svc): ?>
                            <option value="<?= htmlspecialchars($sSlug) ?>"
                                data-title="<?= htmlspecialchars($svc['title'] ?? '') ?>"
                                data-desc="<?= htmlspecialchars($svc['short_desc'] ?? '') ?>"
                                data-link="services/<?= htmlspecialchars($sSlug) ?>.php">
                                <?= htmlspecialchars($svc['title'] ?? $sSlug) ?> (<?= htmlspecialchars($sSlug) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <span style="font-size: 0.8rem; color: var(--text-muted);">Select a service to automatically fill Title, Slug, Link, and Description.</span>
                </div>
            </div>

            <div class="form-grid">
                <!-- Practice Title -->
                <div class="form-group col-full">
                    <label for="practice_title" class="form-label">Practice Title <span class="required">*</span></label>
                    <input type="text" id="practice_title" name="title" class="form-control" required placeholder="e.g. Vulnerability Assessment & Pen Testing (VAPT)" value="<?= htmlspecialchars($editingItem['title'] ?? '') ?>">
                    <span class="form-help">Headline displayed as the card's main title.</span>
                </div>

                <!-- Slug -->
                <div class="form-group">
                    <label for="practice_slug" class="form-label">Service Slug <span class="required">*</span></label>
                    <input type="text" id="practice_slug" name="slug" class="form-control" placeholder="e.g. vulnerability-assessment-penetration-testing" value="<?= htmlspecialchars($editingItem['slug'] ?? '') ?>">
                    <span class="form-help">Matches the corresponding service file in <code>services/[slug].php</code>.</span>
                </div>

                <!-- Target Link -->
                <div class="form-group">
                    <label for="practice_link" class="form-label">Navigation Destination Link</label>
                    <input type="text" id="practice_link" name="link" class="form-control" placeholder="services/vulnerability-assessment-penetration-testing.php" value="<?= htmlspecialchars($editingItem['link'] ?? '') ?>">
                    <span class="form-help">Leave blank to automatically resolve via slug. Direct URLs (https://...) are also supported.</span>
                </div>

                <!-- Tag / Dossier Code -->
                <div class="form-group">
                    <label for="practice_tag" class="form-label">Dossier Tag / Code</label>
                    <input type="text" id="practice_tag" name="tag" class="form-control" placeholder="e.g. // APPSEC-01" value="<?= htmlspecialchars($editingItem['tag'] ?? '') ?>">
                    <span class="form-help">Terminal/monospaced code displayed in the top right of the card.</span>
                </div>

                <!-- Numeric Code -->
                <div class="form-group">
                    <label for="practice_code" class="form-label">Sequence Code</label>
                    <input type="text" id="practice_code" name="code" class="form-control" placeholder="e.g. 01, 02, 08" value="<?= htmlspecialchars($editingItem['code'] ?? '') ?>">
                    <span class="form-help">2-digit numerical index code (e.g. 01).</span>
                </div>

                <!-- Badge Pill -->
                <div class="form-group">
                    <label for="practice_badge" class="form-label">Hero Badge Text (Optional)</label>
                    <input type="text" id="practice_badge" name="badge" class="form-control" placeholder="e.g. PRIMARY PRACTICE, AI DEFENSE PRACTICE" value="<?= htmlspecialchars($editingItem['badge'] ?? '') ?>">
                    <span class="form-help">Colored badge pill shown beside the dossier code.</span>
                </div>

                <!-- Status Indicator Text -->
                <div class="form-group">
                    <label for="practice_status_text" class="form-label">Footer Status Text</label>
                    <input type="text" id="practice_status_text" name="status_text" class="form-control" placeholder="ARMORED" value="<?= htmlspecialchars($editingItem['status_text'] ?? 'ARMORED') ?>">
                    <span class="form-help">Status text shown beside the green pulsing dot (default: ARMORED).</span>
                </div>

                <!-- Display Order -->
                <div class="form-group">
                    <label for="practice_order" class="form-label">Display Order</label>
                    <input type="number" id="practice_order" name="order" class="form-control" min="1" step="1" value="<?= htmlspecialchars((string)($editingItem['order'] ?? (count($allPracticesList) + 1))) ?>">
                    <span class="form-help">Items are arranged in ascending order (1, 2, 3...).</span>
                </div>

                <!-- Publication Status -->
                <div class="form-group">
                    <label for="practice_status" class="form-label">Publication Status</label>
                    <select id="practice_status" name="status" class="form-control">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>● Active (Visible in Bento Grid)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>○ Hidden / Draft</option>
                    </select>
                </div>

                <!-- Bento Hero Highlight Checkbox -->
                <div class="form-group col-full">
                    <label style="display: flex; align-items: center; gap: 0.65rem; cursor: pointer; padding: 0.75rem 1rem; background: rgba(158,62,255,0.06); border: 1px solid rgba(158,62,255,0.2); border-radius: 6px;">
                        <input type="checkbox" name="is_hero" value="1" <?= !empty($editingItem['is_hero']) ? 'checked' : '' ?> style="width: 18px; height: 18px; accent-color: var(--accent-purple);">
                        <div>
                            <strong style="color: #fff; font-size: 0.9rem;">Hero Spotlight Card (Wide Bento Span)</strong>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Gives this card an elevated glowing gradient border and wide layout span inside the Bento grid.</div>
                        </div>
                    </label>
                </div>

                <!-- Description -->
                <div class="form-group col-full">
                    <label for="practice_description" class="form-label">Practice Description <span class="required">*</span></label>
                    <textarea id="practice_description" name="description" rows="3" class="form-control" required placeholder="Simulate real-world attacks across web applications, APIs, mobile apps, and systems to uncover exploitable flaws before adversaries do."><?= htmlspecialchars($editingItem['description'] ?? '') ?></textarea>
                    <span class="form-help">Summary paragraph displayed in the body of the Bento card.</span>
                </div>
            </div>

            <div style="margin-top: 1.75rem; display: flex; gap: 0.75rem;">
                <button type="submit" class="btn btn-primary">
                    <?= ($action === 'edit') ? 'Update Core Practice' : 'Save Core Practice' ?>
                </button>
                <a href="cyber-practices.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function populateFromService(select) {
    const opt = select.options[select.selectedIndex];
    if (!opt || !opt.value) return;
    
    const title = opt.getAttribute('data-title') || '';
    const desc  = opt.getAttribute('data-desc') || '';
    const link  = opt.getAttribute('data-link') || '';
    const slug  = opt.value;
    
    const titleInput = document.getElementById('practice_title');
    const slugInput  = document.getElementById('practice_slug');
    const linkInput  = document.getElementById('practice_link');
    const descInput  = document.getElementById('practice_description');
    const tagInput   = document.getElementById('practice_tag');

    if (titleInput && (!titleInput.value || confirm('Overwrite current Title with selected service?'))) {
        titleInput.value = title;
    }
    if (slugInput) {
        slugInput.value = slug;
    }
    if (linkInput) {
        linkInput.value = link;
    }
    if (descInput && (!descInput.value || confirm('Overwrite current Description with selected service?'))) {
        descInput.value = desc;
    }
    if (tagInput && !tagInput.value) {
        const cleanSlug = slug.replace(/[^a-zA-Z]/g, '').substring(0, 6).toUpperCase();
        tagInput.value = '// ' + cleanSlug + '-01';
    }
}
</script>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->

<!-- Current Section Heading Callout Card -->
<div class="section-heading-card" style="margin-bottom: 1.5rem; background: linear-gradient(135deg, rgba(158, 62, 255, 0.12) 0%, rgba(20, 16, 40, 0.95) 100%); border: 1px solid rgba(158, 62, 255, 0.35); border-radius: 12px; padding: 1.5rem 1.75rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
        <div style="flex: 1; min-width: 280px;">
            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                <span style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #00e676; box-shadow: 0 0 8px #00e676;"></span>
                <span style="font-size: 0.75rem; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--accent-cyan);">
                    Front-End Bento Grid Section Tag: <?= htmlspecialchars($cyberPracticesSettings['tag'] ?? 'OUR PRACTICES') ?>
                </span>
            </div>
            <h2 style="font-size: 1.35rem; font-weight: 800; color: #fff; margin-bottom: 0.4rem; line-height: 1.3;">
                <?= $cyberPracticesSettings['title'] ?? 'Core Cyber Practices. One Standard: <span>Uncompromising Defense.</span>' ?>
            </h2>
            <p style="font-size: 0.88rem; color: var(--text-secondary); margin: 0; line-height: 1.5;">
                <?= htmlspecialchars($cyberPracticesSettings['subtitle'] ?? 'Comprehensive offensive and defensive cybersecurity practices engineered for modern digital enterprises.') ?>
            </p>
        </div>
        <div style="flex-shrink: 0;">
            <button type="button" class="btn btn-secondary btn-sm" onclick="openModal('editPracticesHeadingModal')" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.65rem 1.25rem; font-weight: 600; border-color: rgba(158, 62, 255, 0.5); background: rgba(158, 62, 255, 0.18);">
                <span>✏️</span>
                <span>Edit Section Heading</span>
            </button>
        </div>
    </div>
</div>

<!-- Stats Counter Grid -->
<div class="stats-grid" style="margin-bottom: 1.5rem;">
    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Total Practices</span>
            <div class="stat-icon-wrap">⚡</div>
        </div>
        <div class="stat-value"><?= count($allPracticesList) ?></div>
        <div class="stat-subtext">Configured Bento Grid items</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Active on Site</span>
            <div class="stat-icon-wrap">🛡️</div>
        </div>
        <div class="stat-value" style="color: #00e676;"><?= $activeCount ?></div>
        <div class="stat-subtext">Live visible cards</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Hero Spotlight Cards</span>
            <div class="stat-icon-wrap">⭐</div>
        </div>
        <div class="stat-value" style="color: var(--accent-purple-light);"><?= $heroCount ?></div>
        <div class="stat-subtext">Spans 2-columns with glowing border</div>
    </div>

    <div class="stat-card">
        <div class="stat-card-header">
            <span class="stat-label">Hidden / Draft</span>
            <div class="stat-icon-wrap">👁️</div>
        </div>
        <div class="stat-value" style="color: #ffab00;"><?= $hiddenCount ?></div>
        <div class="stat-subtext">Excluded from public site</div>
    </div>
</div>

<!-- Filters Bar -->
<div style="display: flex; gap: 1rem; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">
    <!-- Status Filter Buttons -->
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="cyber-practices.php?status=all<?= $currentHero !== 'all' ? "&hero={$currentHero}" : '' ?>" class="btn btn-sm <?= ($currentStatus === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
            All Practices (<?= count($allPracticesList) ?>)
        </a>
        <a href="cyber-practices.php?status=active<?= $currentHero !== 'all' ? "&hero={$currentHero}" : '' ?>" class="btn btn-sm <?= ($currentStatus === 'active') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'active') ? 'background: #00e676; border-color: #00e676; color: #000;' : '' ?>">
            ● Active (<?= $activeCount ?>)
        </a>
        <a href="cyber-practices.php?status=inactive<?= $currentHero !== 'all' ? "&hero={$currentHero}" : '' ?>" class="btn btn-sm <?= ($currentStatus === 'inactive') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'inactive') ? 'background: #ffab00; border-color: #ffab00; color: #000;' : '' ?>">
            ○ Hidden (<?= $hiddenCount ?>)
        </a>
    </div>

    <!-- Quick Search & Dropdown Filters Form -->
    <form method="GET" action="cyber-practices.php" style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; margin: 0;">
        <input type="hidden" name="status" value="<?= htmlspecialchars($currentStatus) ?>">

        <select name="hero" class="form-control" style="width: auto; padding: 0.4rem 0.75rem; font-size: 0.82rem;" onchange="this.form.submit()">
            <option value="all">All Card Layouts</option>
            <option value="hero" <?= ($currentHero === 'hero') ? 'selected' : '' ?>>⭐ Hero Highlights Only</option>
            <option value="standard" <?= ($currentHero === 'standard') ? 'selected' : '' ?>>Standard Bento Cards</option>
        </select>

        <input type="text" name="q" class="form-control" placeholder="Search practices..." value="<?= htmlspecialchars($searchQuery) ?>" style="width: 190px; padding: 0.4rem 0.75rem; font-size: 0.82rem;">
        
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        <?php if ($currentHero !== 'all' || $searchQuery !== ''): ?>
            <a href="cyber-practices.php?status=<?= htmlspecialchars($currentStatus) ?>" class="btn btn-secondary btn-sm" title="Clear filters">✕</a>
        <?php endif; ?>
    </form>
</div>

<!-- Main Table Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            Configured Core Cyber Practices (<?= count($displayList) ?>)
        </h3>
        <a href="cyber-practices.php?action=add" class="btn btn-primary btn-sm">
            + Add Core Practice
        </a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;">Order</th>
                    <th style="width: 140px;">Dossier Tag</th>
                    <th>Practice Title &amp; Description</th>
                    <th style="width: 160px;">Link / Destination</th>
                    <th style="width: 130px;">Layout / Badge</th>
                    <th style="width: 100px;">Status</th>
                    <th style="text-align: right; width: 180px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($displayList)): ?>
                    <?php foreach ($displayList as $p): 
                        $pId    = $p['id'] ?? '';
                        $pTitle = $p['title'] ?? '';
                        $pTag   = $p['tag'] ?? '';
                        $pSlug  = $p['slug'] ?? '';
                        $pLink  = $p['link'] ?? '';
                        $pBadge = $p['badge'] ?? '';
                        $pStatus = $p['status'] ?? 'active';
                        $pIsHero = !empty($p['is_hero']);
                        $pOrder = $p['order'] ?? 0;
                        $pStatusText = $p['status_text'] ?? 'ARMORED';
                    ?>
                        <tr>
                            <td>
                                <span style="display: inline-block; padding: 0.2rem 0.55rem; background: rgba(255,255,255,0.06); border-radius: 4px; font-weight: 700; font-size: 0.82rem; color: var(--accent-purple-light);">
                                    <?= (int)$pOrder ?>
                                </span>
                            </td>
                            <td>
                                <code style="font-size: 0.78rem; color: var(--accent-cyan); font-weight: 700;">
                                    <?= htmlspecialchars($pTag) ?>
                                </code>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                                    <div style="font-weight: 700; color: #fff; font-size: 0.95rem;">
                                        <?= htmlspecialchars($pTitle) ?>
                                    </div>
                                    <div style="font-size: 0.8rem; color: var(--text-muted); max-width: 440px; line-height: 1.4;">
                                        <?= htmlspecialchars(mb_substr($p['description'] ?? '', 0, 110)) ?><?= mb_strlen($p['description'] ?? '') > 110 ? '...' : '' ?>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="font-size: 0.8rem;">
                                    <?php if (!empty($pLink)): ?>
                                        <a href="../<?= htmlspecialchars($pLink) ?>" target="_blank" style="color: var(--accent-cyan); text-decoration: none; word-break: break-all;" title="Open destination">
                                            <?= htmlspecialchars(basename($pLink)) ?> ↗
                                        </a>
                                    <?php elseif (!empty($pSlug)): ?>
                                        <span style="color: var(--text-secondary);"><?= htmlspecialchars($pSlug) ?></span>
                                    <?php else: ?>
                                        <span style="color: var(--text-muted);">#</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 0.3rem; align-items: flex-start;">
                                    <?php if ($pIsHero): ?>
                                        <span class="status-pill active" style="font-size: 0.68rem; padding: 0.15rem 0.5rem; background: rgba(158, 62, 255, 0.2); color: #d8b4fe; border: 1px solid rgba(158, 62, 255, 0.4);">
                                            ⭐ Hero Wide
                                        </span>
                                    <?php else: ?>
                                        <span style="font-size: 0.75rem; color: var(--text-muted);">Standard</span>
                                    <?php endif; ?>

                                    <?php if (!empty($pBadge)): ?>
                                        <span style="font-size: 0.66rem; font-weight: 700; text-transform: uppercase; background: rgba(0, 229, 255, 0.12); color: var(--accent-cyan); padding: 0.12rem 0.45rem; border-radius: 4px; border: 1px solid rgba(0, 229, 255, 0.25);">
                                            <?= htmlspecialchars($pBadge) ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <form method="POST" action="cyber-practices.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" style="display:inline; margin:0;">
                                    <?= ck_csrf_field() ?>
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($pId) ?>">
                                    <?php if ($pStatus === 'active'): ?>
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
                                    <form method="POST" action="cyber-practices.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" style="display:inline; margin:0;">
                                        <?= ck_csrf_field() ?>
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($pId) ?>">
                                        <?php if ($pStatus === 'active'): ?>
                                            <button type="submit" class="btn-action hide" title="Hide practice from website">
                                                Hide
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" class="btn-action show" title="Make practice visible on website">
                                                Show
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="cyber-practices.php?action=edit&id=<?= urlencode($pId) ?>" class="btn-action edit" title="Edit practice">Edit</a>
                                    <button type="button" class="btn-action delete" title="Delete practice" onclick="triggerDeletePractice('<?= htmlspecialchars($pId) ?>', '<?= htmlspecialchars(addslashes($pTitle)) ?>')">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2.75rem; color: var(--text-muted);">
                            No core cyber practices matched the chosen filters. Click "Add Core Practice" above to create one.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- ================= EDIT SECTION HEADING MODAL ================= -->
<div class="admin-modal-backdrop" id="editPracticesHeadingModal">
    <div class="admin-modal" style="max-width: 620px;">
        <div class="modal-header">
            <h3 class="modal-title">Edit Core Practices Bento Grid Section Heading</h3>
            <button type="button" class="modal-close-btn" onclick="closeModal('editPracticesHeadingModal')">&times;</button>
        </div>
        <form method="POST" action="cyber-practices.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save_heading">
            <div class="modal-body">
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="modal_section_tag" class="form-label">Section Tag Pill <span class="required">*</span></label>
                    <input type="text" id="modal_section_tag" name="section_tag" class="form-control" required value="<?= htmlspecialchars($cyberPracticesSettings['tag'] ?? 'OUR PRACTICES') ?>">
                    <span class="form-help">Small tag pill rendered above the headline (e.g. <code>OUR PRACTICES</code>).</span>
                </div>
                <div class="form-group" style="margin-bottom: 1.25rem;">
                    <label for="modal_section_title" class="form-label">Section Heading Title <span class="required">*</span></label>
                    <input type="text" id="modal_section_title" name="section_title" class="form-control" required value="<?= htmlspecialchars($cyberPracticesSettings['title'] ?? 'Core Cyber Practices. One Standard: <span>Uncompromising Defense.</span>') ?>">
                    <span class="form-help">HTML allowed (e.g. <code>&lt;span&gt;Uncompromising Defense.&lt;/span&gt;</code> for gradient color accent).</span>
                </div>
                <div class="form-group">
                    <label for="modal_section_subtitle" class="form-label">Section Subtitle / Description <span class="required">*</span></label>
                    <textarea id="modal_section_subtitle" name="section_subtitle" rows="3" class="form-control" required><?= htmlspecialchars($cyberPracticesSettings['subtitle'] ?? 'Comprehensive offensive and defensive cybersecurity practices engineered for modern digital enterprises.') ?></textarea>
                    <span class="form-help">Supporting paragraph rendered right below the section title on the website.</span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('editPracticesHeadingModal')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save Section Heading</button>
            </div>
        </form>
    </div>
</div>

<script>
function triggerDeletePractice(id, title) {
    if (typeof confirmDelete === 'function') {
        confirmDelete('cyber-practices.php', title, '<?= ck_csrf_token() ?>');
        const form = document.getElementById('deleteConfirmForm');
        if (form) {
            // Remove any previously appended practice id input
            const existingId = form.querySelector('input[name="id"]');
            if (existingId) existingId.remove();
            
            const hiddenId = document.createElement('input');
            hiddenId.type = 'hidden';
            hiddenId.name = 'id';
            hiddenId.value = id;
            form.appendChild(hiddenId);
        }
    } else {
        if (confirm('Are you sure you want to delete "' + title + '"?')) {
            const tempForm = document.createElement('form');
            tempForm.method = 'POST';
            tempForm.action = 'cyber-practices.php';
            tempForm.innerHTML = '<?= ck_csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="' + id + '">';
            document.body.appendChild(tempForm);
            tempForm.submit();
        }
    }
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

