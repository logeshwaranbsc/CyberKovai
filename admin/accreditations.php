<?php
/**
 * Cyber Kovai - Memberships, Associations & Accreditations (CRUD)
 * Allows managing credentials, association memberships, and certifications
 * with logo image upload, live badge preview, and track routing (Investigation, Cyber, Both).
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action       = $_GET['action'] ?? 'list';
$editId       = $_GET['id'] ?? null;
$currentTrack = $_GET['track'] ?? 'all';

// Handle Form Submissions (Create, Update, Delete, Toggle Status)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: accreditations.php' . ($currentTrack !== 'all' ? "?track={$currentTrack}" : ''));
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    // Delete Accreditation
    if ($postAction === 'delete') {
        $deleteId = $_POST['id'] ?? '';
        if (!empty($deleteId)) {
            $accred = ck_get_accreditation($deleteId);
            $aName  = $accred['short_name'] ?? ($accred['name'] ?? 'Accreditation');
            $deleted = ck_delete_accreditation($deleteId);
            if ($deleted) {
                ck_set_flash('success', "Accreditation '{$aName}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete accreditation '{$aName}'.");
            }
        }
        header('Location: accreditations.php' . ($currentTrack !== 'all' ? "?track={$currentTrack}" : ''));
        exit;
    }

    // Toggle Active / Hidden Status
    if ($postAction === 'toggle_status') {
        $toggleId = $_POST['id'] ?? '';
        if (!empty($toggleId)) {
            $newStatus = ck_toggle_accreditation_status($toggleId);
            if ($newStatus !== false) {
                $accred = ck_get_accreditation($toggleId);
                $aName  = $accred['short_name'] ?? ($accred['name'] ?? 'Accreditation');
                if ($newStatus === 'active') {
                    ck_set_flash('success', "Accreditation '{$aName}' is now ACTIVE and visible on the website.");
                } else {
                    ck_set_flash('success', "Accreditation '{$aName}' is now HIDDEN from the website.");
                }
            } else {
                ck_set_flash('error', "Could not toggle accreditation status.");
            }
        }
        header('Location: accreditations.php' . ($currentTrack !== 'all' ? "?track={$currentTrack}" : ''));
        exit;
    }

    // Save (Create or Update) Accreditation
    if ($postAction === 'save') {
        $id        = !empty($_POST['id']) ? trim($_POST['id']) : null;
        $name      = trim($_POST['name'] ?? '');
        $shortName = trim($_POST['short_name'] ?? '');
        $track     = $_POST['track'] ?? 'both';

        if ($name === '' && $shortName === '') {
            ck_set_flash('error', 'Please provide an Organization / Association name or short acronym.');
            header('Location: accreditations.php?action=' . ($id ? "edit&id={$id}" : 'add') . "&track={$track}");
            exit;
        }

        // Handle logo file upload if provided
        $logoPath = trim($_POST['img'] ?? 'assets/images/aid.png');
        if (!empty($_FILES['logo_file']) && $_FILES['logo_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = ck_handle_upload($_FILES['logo_file'], 'accred');
            if ($uploadResult['success']) {
                $logoPath = $uploadResult['path'];
            } else {
                ck_set_flash('warning', 'Logo upload notice: ' . $uploadResult['error'] . '. Retained existing logo.');
            }
        }

        $accredData = [
            'id'         => $id,
            'name'       => $name,
            'short_name' => $shortName,
            'img'        => $logoPath,
            'alt'        => trim($_POST['alt'] ?? (!empty($shortName) ? ($shortName . ' - ' . $name) : $name)),
            'website'    => trim($_POST['website'] ?? ''),
            'track'      => in_array($track, ['investigation', 'cyber', 'both'], true) ? $track : 'both',
            'order'      => isset($_POST['order']) ? (int)$_POST['order'] : 1,
            'status'     => $_POST['status'] ?? 'active'
        ];

        $saved = ck_save_accreditation($accredData, $id);
        if ($saved) {
            $displayName = !empty($shortName) ? $shortName : $name;
            $trackLabel  = ($track === 'investigation') ? 'Investigation' : (($track === 'cyber') ? 'Cyber Security' : 'Both Tracks');
            ck_set_flash('success', "Accreditation '{$displayName}' successfully saved for {$trackLabel}!");
            header('Location: accreditations.php?track=' . ($track === 'both' ? 'all' : $track));
            exit;
        } else {
            ck_set_flash('error', 'Failed to save accreditation to storage.');
        }
    }
}

// Fetch current item if editing
$editingItem = null;
if ($action === 'edit' && $editId) {
    $editingItem = ck_get_accreditation($editId);
    if (!$editingItem) {
        ck_set_flash('error', 'Accreditation record not found.');
        header('Location: accreditations.php');
        exit;
    }
}

// Fetch lists and counts
$allAccreds         = ck_get_accreditations('all', true);
$investigationCount = 0;
$cyberCount         = 0;
foreach ($allAccreds as $a) {
    $t = $a['track'] ?? 'both';
    if ($t === 'investigation' || $t === 'both') {
        $investigationCount++;
    }
    if ($t === 'cyber' || $t === 'both') {
        $cyberCount++;
    }
}

// Filter for list view
$displayAccreds = ($currentTrack === 'all') ? $allAccreds : ck_get_accreditations($currentTrack, true);

$adminPageTitle = 'Accreditations & Credentials';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Memberships, Associations &amp; Accreditations</h1>
        <p class="page-header-desc">Manage verified professional credentials, investigative council memberships, and certification logos displayed on the website.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <?php if ($action === 'list'): ?>
            <a href="accreditations.php?action=add<?= ($currentTrack !== 'all') ? "&track={$currentTrack}" : '' ?>" class="btn btn-primary">
                <span>+</span> Add New Accreditation
            </a>
            <a href="../cyber-intelligence.php#credentials" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Digital Investigation page">
                Preview Investigation ➔
            </a>
            <a href="../digital-forensics.php#credentials" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Cyber Security page">
                Preview Cyber ➔
            </a>
        <?php else: ?>
            <a href="accreditations.php<?= ($currentTrack !== 'all') ? "?track={$currentTrack}" : '' ?>" class="btn btn-secondary">
                &larr; Back to Accreditations List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Accreditation: ' . htmlspecialchars($editingItem['short_name'] ?: $editingItem['name']) : 'Add New Accreditation / Membership' ?></h3>
        <span class="category-tag" style="background: rgba(139, 32, 255, 0.15); color: var(--accent-purple-light);">
            <?= ($action === 'edit') ? 'Badge ID: ' . htmlspecialchars($editingItem['id']) : 'New Credential' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="accreditations.php" enctype="multipart/form-data">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id']) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Full Association / Organization Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Association of Investigators and Detectives" value="<?= htmlspecialchars($editingItem['name'] ?? '') ?>">
                    <span class="form-help">Official statutory body or professional association name.</span>
                </div>

                <div class="form-group">
                    <label for="short_name" class="form-label">Short Acronym / Code <span class="required">*</span></label>
                    <input type="text" id="short_name" name="short_name" class="form-control" required placeholder="e.g. AID, TAPDI, APDI, UNIP" value="<?= htmlspecialchars($editingItem['short_name'] ?? '') ?>">
                    <span class="form-help">Short label used for tags and badge references.</span>
                </div>

                <div class="form-group">
                    <label for="track" class="form-label">Display Track / Scope <span class="required">*</span></label>
                    <?php 
                    $selectedTrack = $editingItem['track'] ?? ($currentTrack !== 'all' ? $currentTrack : 'both');
                    ?>
                    <select id="track" name="track" class="form-control" style="font-weight: 600;" required>
                        <option value="both" <?= ($selectedTrack === 'both') ? 'selected' : '' ?>>
                            🌐 Both Tracks (Displays on both Investigation &amp; Cyber pages)
                        </option>
                        <option value="investigation" <?= ($selectedTrack === 'investigation') ? 'selected' : '' ?>>
                            🔍 Digital Investigation &amp; Forensics (cyber-intelligence.php)
                        </option>
                        <option value="cyber" <?= ($selectedTrack === 'cyber') ? 'selected' : '' ?>>
                            🛡️ Cyber Security &amp; Defense (digital-forensics.php)
                        </option>
                    </select>
                    <span class="form-help">Choose which page(s) on the website will showcase this credential.</span>
                </div>

                <div class="form-group">
                    <label for="order" class="form-label">Display Order Sequence</label>
                    <input type="number" id="order" name="order" class="form-control" min="1" value="<?= htmlspecialchars($editingItem['order'] ?? (count($allAccreds) + 1)) ?>">
                    <span class="form-help">Display sequence position (1 = first badge on the left).</span>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Publication Status</label>
                    <select id="status" name="status" class="form-control" style="font-weight: 600;">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Hidden (Hide from Website)</option>
                    </select>
                    <span class="form-help">Instantly show or hide this badge from the live site.</span>
                </div>

                <div class="form-group">
                    <label for="website" class="form-label">Association Website URL (Optional)</label>
                    <input type="url" id="website" name="website" class="form-control" placeholder="https://association.org" value="<?= htmlspecialchars($editingItem['website'] ?? '') ?>">
                    <span class="form-help">Optional link opening the official organization website when clicked.</span>
                </div>

                <div class="form-group col-full">
                    <label for="img" class="form-label">Accreditation Badge / Logo Image <span class="required">*</span></label>
                    <div class="input-with-preview" style="align-items: flex-start;">
                        <?php 
                        $currentLogo = $editingItem['img'] ?? 'assets/images/aid.png';
                        ?>
                        <div style="background: #ffffff; padding: 12px 22px; border-radius: 18px; border: 1px solid rgba(139, 32, 255, 0.3); width: 190px; height: 74px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 24px rgba(0,0,0,0.35);">
                            <img src="../<?= htmlspecialchars($currentLogo) ?>" alt="" id="badgePreview" style="max-height: 48px; max-width: 155px; object-fit: contain;">
                        </div>
                        <div style="flex: 1;">
                            <input type="file" id="logo_file" name="logo_file" class="form-control" accept="image/*" data-preview="#badgePreview" style="margin-bottom: 0.6rem;">
                            <input type="text" id="img" name="img" class="form-control" placeholder="assets/images/aid.png" value="<?= htmlspecialchars($currentLogo) ?>">
                            <span class="form-help">Upload PNG, SVG, WebP, or JPG logo. The badge card provides a crisp white background with rounded corners matching the live website.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-full">
                    <label for="alt" class="form-label">Image Alt Text (Accessibility &amp; SEO)</label>
                    <input type="text" id="alt" name="alt" class="form-control" placeholder="e.g. AID - Association of Investigators and Detectives" value="<?= htmlspecialchars($editingItem['alt'] ?? '') ?>">
                    <span class="form-help">Descriptive text for accessibility compliance and SEO crawlers.</span>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="accreditations.php<?= ($currentTrack !== 'all') ? "?track={$currentTrack}" : '' ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Accreditation
                </button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->

<!-- Track Filter Navigation Pills -->
<div style="display: flex; gap: 0.6rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <a href="accreditations.php?track=all" class="btn btn-sm <?= ($currentTrack === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
        All Credentials (<?= count($allAccreds) ?>)
    </a>
    <a href="accreditations.php?track=investigation" class="btn btn-sm <?= ($currentTrack === 'investigation') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentTrack === 'investigation') ? 'background: #8b20ff; border-color: #8b20ff;' : '' ?>">
        🔍 Investigation Track (<?= $investigationCount ?>)
    </a>
    <a href="accreditations.php?track=cyber" class="btn btn-sm <?= ($currentTrack === 'cyber') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentTrack === 'cyber') ? 'background: #00b4d8; border-color: #00b4d8;' : '' ?>">
        🛡️ Cyber Track (<?= $cyberCount ?>)
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <?php if ($currentTrack === 'investigation'): ?>
                🔍 Digital Investigation Credentials (<?= count($displayAccreds) ?>)
            <?php elseif ($currentTrack === 'cyber'): ?>
                🛡️ Cyber Security Credentials (<?= count($displayAccreds) ?>)
            <?php else: ?>
                All Memberships, Associations &amp; Accreditations (<?= count($displayAccreds) ?>)
            <?php endif; ?>
        </h3>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="accreditations.php?action=add<?= ($currentTrack !== 'all') ? "&track={$currentTrack}" : '' ?>" class="btn btn-primary btn-sm">
                + Add Accreditation
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 140px;">Badge Preview</th>
                    <th>Acronym &amp; Name</th>
                    <th>Display Track</th>
                    <th>Website</th>
                    <th style="width: 60px;">Order</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($displayAccreds)): ?>
                    <?php foreach ($displayAccreds as $a): ?>
                    <tr>
                        <td>
                            <div style="background: #ffffff; padding: 6px 12px; border-radius: 12px; border: 1px solid var(--border-color); width: 120px; height: 50px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.25);">
                                <img src="../<?= htmlspecialchars($a['img'] ?? 'assets/images/aid.png') ?>" alt="" style="max-height: 38px; max-width: 100px; object-fit: contain;">
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 2px;">
                                <span class="category-tag" style="background: rgba(139, 32, 255, 0.22); color: #c44bff; font-weight: 700;">
                                    <?= htmlspecialchars($a['short_name'] ?? 'BADGE') ?>
                                </span>
                            </div>
                            <span class="cell-title" style="font-size: 0.88rem;"><?= htmlspecialchars($a['name'] ?? '') ?></span>
                        </td>
                        <td>
                            <?php 
                            $trackVal = $a['track'] ?? 'both';
                            if ($trackVal === 'investigation'): ?>
                                <span class="category-tag" style="background: rgba(139, 32, 255, 0.18); color: #c44bff; border: 1px solid rgba(139, 32, 255, 0.35);">
                                    🔍 Investigation
                                </span>
                            <?php elseif ($trackVal === 'cyber'): ?>
                                <span class="category-tag" style="background: rgba(0, 180, 216, 0.18); color: #00e5ff; border: 1px solid rgba(0, 180, 216, 0.35);">
                                    🛡️ Cyber Security
                                </span>
                            <?php else: ?>
                                <span class="category-tag" style="background: rgba(0, 230, 118, 0.18); color: #00e676; border: 1px solid rgba(0, 230, 118, 0.35);">
                                    🌐 Both Tracks
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($a['website'])): ?>
                                <a href="<?= htmlspecialchars($a['website']) ?>" target="_blank" rel="noopener" style="font-size: 0.78rem; color: var(--accent-purple-light); text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                    <span>🔗</span> <?= htmlspecialchars(parse_url($a['website'], PHP_URL_HOST) ?: $a['website']) ?> ↗
                                </a>
                            <?php else: ?>
                                <span style="font-size: 0.75rem; color: var(--text-muted);">&mdash;</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem;">
                                #<?= htmlspecialchars($a['order'] ?? 1) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="accreditations.php<?= ($currentTrack !== 'all') ? "?track={$currentTrack}" : '' ?>" style="display:inline; margin:0;">
                                <?= ck_csrf_field() ?>
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($a['id']) ?>">
                                <?php if (($a['status'] ?? 'active') === 'active'): ?>
                                    <button type="submit" class="status-pill active" style="cursor: pointer; border: 1px solid rgba(0, 230, 118, 0.3);" title="Click to hide from website">
                                        ● ACTIVE
                                    </button>
                                <?php else: ?>
                                    <button type="submit" class="status-pill inactive" style="cursor: pointer; background: rgba(255,171,0,0.15); color: #ffab00; border-color: rgba(255,171,0,0.3);" title="Click to show on website">
                                        ○ HIDDEN
                                    </button>
                                <?php endif; ?>
                            </form>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-btns-group" style="justify-content: flex-end;">
                                <form method="POST" action="accreditations.php<?= ($currentTrack !== 'all') ? "?track={$currentTrack}" : '' ?>" style="display:inline; margin:0;">
                                    <?= ck_csrf_field() ?>
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($a['id']) ?>">
                                    <?php if (($a['status'] ?? 'active') === 'active'): ?>
                                        <button type="submit" class="btn-action hide" title="Hide this badge from website">
                                            Hide
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn-action show" title="Make this badge visible on website">
                                            Show
                                        </button>
                                    <?php endif; ?>
                                </form>
                                <a href="accreditations.php?action=edit&id=<?= urlencode($a['id']) ?>&track=<?= urlencode($currentTrack) ?>" class="btn-action edit">Edit</a>
                                <button type="button" class="btn-action delete" onclick="confirmDelete('accreditations.php', '<?= htmlspecialchars(addslashes($a['short_name'] ?: $a['name'])) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'id\' value=\'<?= htmlspecialchars($a['id']) ?>\'>';">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                            No accreditations found for this track. Click "Add New Accreditation" above to create your first badge.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

