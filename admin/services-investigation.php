<?php
/**
 * Cyber Kovai - Digital Investigation Services & Practices (CRUD)
 * Allows managing practices, images/logos, descriptions, order, and status
 * displayed in "Comprehensive Digital Investigation Solutions" on cyber-intelligence.php.
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action        = $_GET['action'] ?? 'list';
$editSlug      = $_GET['slug'] ?? null;
$currentStatus = $_GET['status'] ?? 'all';

// Handle Form Submissions (Create, Update, Delete, Toggle Status)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: services-investigation.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    // Delete Service
    if ($postAction === 'delete') {
        $deleteSlug = $_POST['slug'] ?? '';
        if (!empty($deleteSlug)) {
            $service = ck_get_investigation_service($deleteSlug);
            $sTitle  = $service['title'] ?? $deleteSlug;
            $deleted = ck_delete_investigation_service($deleteSlug);
            if ($deleted) {
                ck_set_flash('success', "Investigation practice '{$sTitle}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete investigation practice '{$sTitle}'.");
            }
        }
        header('Location: services-investigation.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    // Toggle Active / Hidden Status
    if ($postAction === 'toggle_status') {
        $toggleSlug = $_POST['slug'] ?? '';
        if (!empty($toggleSlug)) {
            $newStatus = ck_toggle_investigation_service_status($toggleSlug);
            if ($newStatus !== false) {
                $service = ck_get_investigation_service($toggleSlug);
                $sTitle  = $service['title'] ?? $toggleSlug;
                if ($newStatus === 'active') {
                    ck_set_flash('success', "Practice '{$sTitle}' is now ACTIVE and visible on the website.");
                } else {
                    ck_set_flash('success', "Practice '{$sTitle}' is now HIDDEN from the website.");
                }
            } else {
                ck_set_flash('error', "Could not toggle status for service.");
            }
        }
        header('Location: services-investigation.php' . ($currentStatus !== 'all' ? "?status={$currentStatus}" : ''));
        exit;
    }

    // Save (Create or Update) Service
    if ($postAction === 'save') {
        $originalSlug = !empty($_POST['original_slug']) ? trim($_POST['original_slug']) : null;
        $title        = trim($_POST['title'] ?? '');
        $slug         = !empty($_POST['slug']) ? ck_slugify($_POST['slug']) : ck_slugify($title);

        if ($title === '') {
            ck_set_flash('error', 'Practice / Service title cannot be empty.');
            header('Location: services-investigation.php?action=' . ($originalSlug ? "edit&slug={$originalSlug}" : 'add'));
            exit;
        }

        // Handle image upload if provided
        $imagePath = trim($_POST['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg');
        if (!empty($_FILES['image_file']) && $_FILES['image_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = ck_handle_upload($_FILES['image_file'], 'inv');
            if ($uploadResult['success']) {
                $imagePath = $uploadResult['path'];
            } else {
                ck_set_flash('warning', 'Image upload issue: ' . $uploadResult['error'] . '. Retained existing image.');
            }
        }

        $allExisting = ck_get_investigation_services(true);
        $order = isset($_POST['order']) && $_POST['order'] !== '' ? (int)$_POST['order'] : (count($allExisting) + 1);

        $serviceData = [
            'id'          => $_POST['id'] ?? null,
            'slug'        => $slug,
            'title'       => $title,
            'short'       => trim($_POST['short'] ?? $title),
            'icon'        => trim($_POST['icon'] ?? '🛡️'),
            'image'       => $imagePath,
            'description' => trim($_POST['description'] ?? ''),
            'overview'    => trim($_POST['overview'] ?? ''),
            'order'       => $order,
            'status'      => $_POST['status'] ?? 'active'
        ];

        $saved = ck_save_investigation_service($serviceData, $originalSlug);
        if ($saved) {
            ck_set_flash('success', "Investigation practice '{$title}' successfully saved!");
            header('Location: services-investigation.php');
            exit;
        } else {
            ck_set_flash('error', 'Failed to save investigation service to storage.');
        }
    }
}

// Fetch current service if editing
$editingItem = null;
if ($action === 'edit' && $editSlug) {
    $editingItem = ck_get_investigation_service($editSlug);
    if (!$editingItem) {
        ck_set_flash('error', "Investigation service '{$editSlug}' not found.");
        header('Location: services-investigation.php');
        exit;
    }
}

$allServicesList = ck_get_investigation_services(true);
$activeCount     = 0;
$hiddenCount     = 0;
foreach ($allServicesList as $s) {
    if (($s['status'] ?? 'active') === 'active') {
        $activeCount++;
    } else {
        $hiddenCount++;
    }
}

// Filter for display
$displayList = $allServicesList;
if ($currentStatus === 'active') {
    $displayList = array_filter($allServicesList, function($s) {
        return ($s['status'] ?? 'active') === 'active';
    });
} elseif ($currentStatus === 'inactive') {
    $displayList = array_filter($allServicesList, function($s) {
        return ($s['status'] ?? 'active') === 'inactive';
    });
}

$adminPageTitle = 'Digital Investigation Services';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Comprehensive Digital Investigation Solutions</h1>
        <p class="page-header-desc">Manage digital forensics, OSINT, cyber fraud tracing, and evidence preservation practices displayed on the website.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <?php if ($action === 'list'): ?>
            <a href="services-investigation.php?action=add" class="btn btn-primary">
                <span>+</span> Add Investigation Practice
            </a>
            <a href="../cyber-intelligence.php#ci-services" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Digital Investigation page">
                Preview on Website ➔
            </a>
        <?php else: ?>
            <a href="services-investigation.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" class="btn btn-secondary">
                &larr; Back to Services List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Practice: ' . htmlspecialchars($editingItem['title']) : 'Add New Investigation Practice' ?></h3>
        <span class="category-tag" style="background: rgba(139, 32, 255, 0.15); color: var(--accent-purple-light);">
            <?= ($action === 'edit') ? 'Slug: ' . htmlspecialchars($editingItem['slug']) : 'New Practice' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="services-investigation.php" enctype="multipart/form-data">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="original_slug" value="<?= htmlspecialchars($editingItem['slug']) ?>">
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id'] ?? '') ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group col-full">
                    <label for="title" class="form-label">Practice / Service Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" required data-slug-source placeholder="e.g. Cybercrime Victim Assistance & Account Recovery" value="<?= htmlspecialchars($editingItem['title'] ?? '') ?>">
                    <span class="form-help">Main headline displayed on the front-end service card.</span>
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">URL Slug <span class="required">*</span></label>
                    <input type="text" id="slug" name="slug" class="form-control" required data-slug-target placeholder="e.g. cybercrime-victim-assistance-account-recovery" value="<?= htmlspecialchars($editingItem['slug'] ?? '') ?>">
                    <span class="form-help">Unique URL identifier (creates <code>/services/{slug}.php</code>)</span>
                </div>

                <div class="form-group">
                    <label for="short" class="form-label">Short / Navigation Title <span class="required">*</span></label>
                    <input type="text" id="short" name="short" class="form-control" required placeholder="e.g. Victim & Account Recovery" value="<?= htmlspecialchars($editingItem['short'] ?? '') ?>">
                    <span class="form-help">Used for compact badges, header dropdowns, and pills</span>
                </div>

                <div class="form-group">
                    <label for="icon" class="form-label">Emoji / Icon</label>
                    <input type="text" id="icon" name="icon" class="form-control" placeholder="🛡️" value="<?= htmlspecialchars($editingItem['icon'] ?? '🛡️') ?>">
                    <span class="form-help">Icon symbol (e.g. 🛡️, 🔍, 📱, 💳, 💾, 👨‍👩‍👧‍👦, 🎓, 👶)</span>
                </div>

                <div class="form-group">
                    <label for="order" class="form-label">Display Order Sequence</label>
                    <input type="number" id="order" name="order" class="form-control" min="1" value="<?= htmlspecialchars($editingItem['order'] ?? (count($allServicesList) + 1)) ?>">
                    <span class="form-help">Order position on the website cards grid (1 = first card)</span>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Publication Status</label>
                    <select id="status" name="status" class="form-control" style="font-weight: 600;">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Hidden (Hide from Website)</option>
                    </select>
                    <span class="form-help">Instantly show or hide this card from the live site</span>
                </div>

                <div class="form-group col-full">
                    <label for="image" class="form-label">Card Banner Image <span class="required">*</span></label>
                    <div class="input-with-preview" style="align-items: flex-start;">
                        <?php 
                        $currentImg = $editingItem['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg';
                        ?>
                        <div style="background: rgba(10, 10, 31, 0.9); padding: 6px; border-radius: 12px; border: 1px solid var(--border-color); width: 220px; height: 130px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0; box-shadow: 0 4px 16px rgba(0,0,0,0.4);">
                            <img src="../<?= htmlspecialchars($currentImg) ?>" alt="" id="serviceImgPreview" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                        </div>
                        <div style="flex: 1;">
                            <input type="file" id="image_file" name="image_file" class="form-control" accept="image/*" data-preview="#serviceImgPreview" style="margin-bottom: 0.6rem;">
                            <input type="text" id="image" name="image" class="form-control" placeholder="assets/images/investigation_01_victim_recovery.jpg" value="<?= htmlspecialchars($currentImg) ?>">
                            <span class="form-help">Upload JPG, PNG, or WebP image. This visual is displayed at the top of the card in the "Comprehensive Digital Investigation Solutions" section.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-full">
                    <label for="description" class="form-label">Card Summary Description <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="4" class="form-control" required placeholder="Describe what this practice offers (e.g. Support for individuals affected by account hacking, online fraud...)..."><?= htmlspecialchars($editingItem['description'] ?? '') ?></textarea>
                    <span class="form-help">This is the core paragraph text rendered inside the card on the website.</span>
                </div>

                <div class="form-group col-full">
                    <label for="overview" class="form-label">Extended Overview (Service Detail Page)</label>
                    <textarea id="overview" name="overview" rows="5" class="form-control" placeholder="In-depth explanation rendered on the dedicated service page (/services/slug.php)..."><?= htmlspecialchars($editingItem['overview'] ?? '') ?></textarea>
                    <span class="form-help">Optional deep-dive content displayed when users click "Explore Investigation &rarr;".</span>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="services-investigation.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Investigation Practice
                </button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->

<!-- Status Filter Navigation Pills -->
<div style="display: flex; gap: 0.6rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <a href="services-investigation.php?status=all" class="btn btn-sm <?= ($currentStatus === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
        All Practices (<?= count($allServicesList) ?>)
    </a>
    <a href="services-investigation.php?status=active" class="btn btn-sm <?= ($currentStatus === 'active') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'active') ? 'background: #00e676; border-color: #00e676; color: #000;' : '' ?>">
        ● Active on Website (<?= $activeCount ?>)
    </a>
    <a href="services-investigation.php?status=inactive" class="btn btn-sm <?= ($currentStatus === 'inactive') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'inactive') ? 'background: #ffab00; border-color: #ffab00; color: #000;' : '' ?>">
        ○ Hidden / Draft (<?= $hiddenCount ?>)
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <?php if ($currentStatus === 'active'): ?>
                ● Active Practices (<?= count($displayList) ?>)
            <?php elseif ($currentStatus === 'inactive'): ?>
                ○ Hidden Practices (<?= count($displayList) ?>)
            <?php else: ?>
                Comprehensive Digital Investigation Practices (<?= count($displayList) ?>)
            <?php endif; ?>
        </h3>
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <a href="services-investigation.php?action=add" class="btn btn-primary btn-sm">
                + Add Practice
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 100px;">Banner</th>
                    <th>Practice Title</th>
                    <th>Short Nav</th>
                    <th>Card Description</th>
                    <th style="width: 60px;">Order</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($displayList)): ?>
                    <?php foreach ($displayList as $svc): ?>
                    <tr>
                        <td>
                            <div style="background: rgba(10, 10, 31, 0.9); padding: 3px; border-radius: 8px; border: 1px solid var(--border-color); width: 90px; height: 54px; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                                <img src="../<?= htmlspecialchars($svc['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg') ?>" alt="" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                            </div>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.4rem; margin-bottom: 2px;">
                                <span style="font-size: 1.1rem;"><?= htmlspecialchars($svc['icon'] ?? '🛡️') ?></span>
                                <span class="cell-title"><?= htmlspecialchars($svc['title']) ?></span>
                            </div>
                            <span class="cell-subtitle">
                                Slug: <code style="color: var(--accent-purple-light);"><?= htmlspecialchars($svc['slug']) ?></code>
                            </span>
                        </td>
                        <td>
                            <span class="category-tag"><?= htmlspecialchars($svc['short'] ?? '') ?></span>
                        </td>
                        <td style="max-width: 320px;">
                            <p style="font-size: 0.82rem; color: var(--text-secondary); line-height: 1.45; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin: 0;">
                                <?= htmlspecialchars($svc['description'] ?? '') ?>
                            </p>
                        </td>
                        <td>
                            <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem;">
                                #<?= htmlspecialchars($svc['order'] ?? 1) ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST" action="services-investigation.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" style="display:inline; margin:0;">
                                <?= ck_csrf_field() ?>
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="slug" value="<?= htmlspecialchars($svc['slug']) ?>">
                                <?php if (($svc['status'] ?? 'active') === 'active'): ?>
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
                                <form method="POST" action="services-investigation.php<?= ($currentStatus !== 'all') ? "?status={$currentStatus}" : '' ?>" style="display:inline; margin:0;">
                                    <?= ck_csrf_field() ?>
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="slug" value="<?= htmlspecialchars($svc['slug']) ?>">
                                    <?php if (($svc['status'] ?? 'active') === 'active'): ?>
                                        <button type="submit" class="btn-action hide" title="Hide this practice from website">
                                            Hide
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn-action show" title="Make this practice visible on website">
                                            Show
                                        </button>
                                    <?php endif; ?>
                                </form>
                                <a href="../services/<?= htmlspecialchars($svc['slug']) ?>.php?section=forensics" target="_blank" class="btn-action view" title="View live page">View</a>
                                <a href="services-investigation.php?action=edit&slug=<?= urlencode($svc['slug']) ?>" class="btn-action edit">Edit</a>
                                <button type="button" class="btn-action delete" onclick="confirmDelete('services-investigation.php', '<?= htmlspecialchars(addslashes($svc['title'])) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'slug\' value=\'<?= htmlspecialchars($svc['slug']) ?>\'>';">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                            No investigation practices found for this filter. Click "Add Investigation Practice" above to create one.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
