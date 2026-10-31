<?php
/**
 * Cyber Kovai - Investigation Services Management (CRUD)
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action = $_GET['action'] ?? 'list';
$editSlug = $_GET['slug'] ?? null;

// Handle Form Submissions (Create, Update, Delete) BEFORE ANY HTML OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: services-investigation.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    if ($postAction === 'delete') {
        $deleteSlug = $_POST['slug'] ?? '';
        if (!empty($deleteSlug)) {
            $deleted = ck_delete_investigation_service($deleteSlug);
            if ($deleted) {
                ck_set_flash('success', "Investigation service '{$deleteSlug}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete service '{$deleteSlug}'.");
            }
        }
        header('Location: services-investigation.php');
        exit;
    }

    if ($postAction === 'save') {
        $originalSlug = !empty($_POST['original_slug']) ? trim($_POST['original_slug']) : null;
        $title = trim($_POST['title'] ?? '');
        $slug = !empty($_POST['slug']) ? ck_slugify($_POST['slug']) : ck_slugify($title);

        if ($title === '') {
            ck_set_flash('error', 'Service title cannot be empty.');
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
                ck_set_flash('warning', 'Image upload issue: ' . $uploadResult['error'] . '. Kept default image.');
            }
        }

        $serviceData = [
            'id'          => $_POST['id'] ?? null,
            'slug'        => $slug,
            'title'       => $title,
            'short'       => trim($_POST['short'] ?? $title),
            'icon'        => trim($_POST['icon'] ?? '🛡️'),
            'image'       => $imagePath,
            'description' => trim($_POST['description'] ?? ''),
            'overview'    => trim($_POST['overview'] ?? ''),
            'status'      => $_POST['status'] ?? 'active'
        ];

        $saved = ck_save_investigation_service($serviceData, $originalSlug);
        if ($saved) {
            ck_set_flash('success', "Investigation service '{$title}' successfully saved!");
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

$servicesList = ck_get_investigation_services(true);

$adminPageTitle = 'Investigation Services';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Digital Investigation &amp; Forensics Services</h1>
        <p class="page-header-desc">Manage digital forensics, OSINT, cyber fraud tracing, and evidence preservation practices.</p>
    </div>
    <?php if ($action === 'list'): ?>
    <div>
        <a href="services-investigation.php?action=add" class="btn btn-primary">
            <span>+</span> Add Investigation Service
        </a>
    </div>
    <?php else: ?>
    <div>
        <a href="services-investigation.php" class="btn btn-secondary">
            &larr; Back to Services List
        </a>
    </div>
    <?php endif; ?>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Investigation Service: ' . htmlspecialchars($editingItem['title']) : 'Add New Investigation Service' ?></h3>
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
                    <label for="title" class="form-label">Service Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" required data-slug-source placeholder="e.g. Digital Investigations & OSINT" value="<?= htmlspecialchars($editingItem['title'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">URL Slug <span class="required">*</span></label>
                    <input type="text" id="slug" name="slug" class="form-control" required data-slug-target placeholder="e.g. digital-investigations-osint" value="<?= htmlspecialchars($editingItem['slug'] ?? '') ?>">
                    <span class="form-help">Unique URL identifier (e.g. /services/digital-investigations-osint.php)</span>
                </div>

                <div class="form-group">
                    <label for="short" class="form-label">Short / Navigation Title <span class="required">*</span></label>
                    <input type="text" id="short" name="short" class="form-control" required placeholder="e.g. Digital Investigations & OSINT" value="<?= htmlspecialchars($editingItem['short'] ?? '') ?>">
                    <span class="form-help">Used for compact cards, pills, and dropdown menu links</span>
                </div>

                <div class="form-group">
                    <label for="icon" class="form-label">Emoji / Icon</label>
                    <input type="text" id="icon" name="icon" class="form-control" placeholder="🔍" value="<?= htmlspecialchars($editingItem['icon'] ?? '🛡️') ?>">
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Publication Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Draft / Hidden</option>
                    </select>
                </div>

                <div class="form-group col-full">
                    <label for="image" class="form-label">Service Card Image</label>
                    <div class="input-with-preview">
                        <?php 
                        $currentImg = $editingItem['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg';
                        ?>
                        <img src="../<?= htmlspecialchars($currentImg) ?>" alt="" class="preview-box" id="serviceImgPreview">
                        <div style="flex: 1;">
                            <input type="file" id="image_file" name="image_file" class="form-control" accept="image/*" data-preview="#serviceImgPreview" style="margin-bottom: 0.5rem;">
                            <input type="text" id="image" name="image" class="form-control" placeholder="Or specify asset path: assets/images/..." value="<?= htmlspecialchars($currentImg) ?>">
                            <span class="form-help">Upload a new JPG/PNG/WebP image or specify an existing relative path.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-full">
                    <label for="description" class="form-label">Summary Description <span class="required">*</span></label>
                    <textarea id="description" name="description" rows="3" class="form-control" required placeholder="Concise overview displayed on the investigation services cards..."><?= htmlspecialchars($editingItem['description'] ?? '') ?></textarea>
                </div>

                <div class="form-group col-full">
                    <label for="overview" class="form-label">Extended Overview (Service Detail Page)</label>
                    <textarea id="overview" name="overview" rows="5" class="form-control" placeholder="In-depth explanation rendered on the dedicated service page (/services/slug.php)..."><?= htmlspecialchars($editingItem['overview'] ?? '') ?></textarea>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="services-investigation.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Investigation Service
                </button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">All Investigation Practices (<?= count($servicesList) ?>)</h3>
        <span class="category-tag">Forensics &amp; OSINT</span>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="width: 65px;">Image</th>
                    <th>Practice Name</th>
                    <th>Short Nav Label</th>
                    <th>Icon</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($servicesList)): ?>
                    <?php foreach ($servicesList as $idx => $svc): ?>
                    <tr>
                        <td><span style="font-weight: 700; color: var(--text-muted);"><?= $idx + 1 ?></span></td>
                        <td>
                            <img src="../<?= htmlspecialchars($svc['image'] ?? 'assets/images/investigation_01_victim_recovery.jpg') ?>" alt="" class="table-thumbnail">
                        </td>
                        <td>
                            <span class="cell-title"><?= htmlspecialchars($svc['title']) ?></span>
                            <span class="cell-subtitle">Slug: <code style="color: var(--accent-purple-light);"><?= htmlspecialchars($svc['slug']) ?></code></span>
                        </td>
                        <td>
                            <span class="category-tag"><?= htmlspecialchars($svc['short'] ?? '') ?></span>
                        </td>
                        <td style="font-size: 1.3rem;">
                            <?= htmlspecialchars($svc['icon'] ?? '🛡️') ?>
                        </td>
                        <td>
                            <span class="status-pill <?= (($svc['status'] ?? 'active') === 'active') ? 'active' : 'inactive' ?>">
                                <?= htmlspecialchars($svc['status'] ?? 'active') ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-btns-group" style="justify-content: flex-end;">
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
                            No investigation services found. Click "Add Investigation Service" above to create one.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

