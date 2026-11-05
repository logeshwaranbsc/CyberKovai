<?php
/**
 * Cyber Kovai - Testimonials Management (CRUD)
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? null;

// Handle Form Submissions (Create, Update, Delete) BEFORE ANY HTML OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: testimonials.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    if ($postAction === 'toggle_visibility') {
        $curSettings = ck_get_settings();
        $newVal = empty($curSettings['show_testimonials']);
        ck_save_settings(['show_testimonials' => $newVal]);
        ck_set_flash('success', $newVal ? 'Testimonials section is now VISIBLE on the website.' : 'Testimonials section is now HIDDEN from the website.');
        header('Location: testimonials.php');
        exit;
    }

    if ($postAction === 'toggle_status') {
        $toggleId = $_POST['id'] ?? '';
        if (!empty($toggleId)) {
            $newStatus = ck_toggle_testimonial_status($toggleId);
            if ($newStatus !== false) {
                $testi = ck_get_testimonial($toggleId);
                $name = $testi['name'] ?? 'Testimonial';
                if ($newStatus === 'active') {
                    ck_set_flash('success', "Testimonial by '{$name}' is now ACTIVE and visible on the website.");
                } else {
                    ck_set_flash('success', "Testimonial by '{$name}' is now HIDDEN from the website.");
                }
            } else {
                ck_set_flash('error', "Could not toggle testimonial visibility status.");
            }
        }
        header('Location: testimonials.php');
        exit;
    }

    if ($postAction === 'delete') {
        $deleteId = $_POST['id'] ?? '';
        if (!empty($deleteId)) {
            $deleted = ck_delete_testimonial($deleteId);
            if ($deleted) {
                ck_set_flash('success', "Testimonial was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete testimonial.");
            }
        }
        header('Location: testimonials.php');
        exit;
    }

    if ($postAction === 'save') {
        $id = !empty($_POST['id']) ? trim($_POST['id']) : null;
        $name = trim($_POST['name'] ?? '');
        $quote = trim($_POST['quote'] ?? '');

        if ($name === '' || $quote === '') {
            ck_set_flash('error', 'Client name and testimonial quote cannot be empty.');
            header('Location: testimonials.php?action=' . ($id ? "edit&id={$id}" : 'add'));
            exit;
        }

        // Handle avatar upload if provided
        $avatarPath = trim($_POST['avatar'] ?? 'assets/images/avatar_karthik.jpg');
        if (!empty($_FILES['avatar_file']) && $_FILES['avatar_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = ck_handle_upload($_FILES['avatar_file'], 'avatar');
            if ($uploadResult['success']) {
                $avatarPath = $uploadResult['path'];
            } else {
                ck_set_flash('warning', 'Avatar upload notice: ' . $uploadResult['error'] . '. Retained existing image.');
            }
        }

        $testiData = [
            'id'     => $id,
            'name'   => $name,
            'role'   => trim($_POST['role'] ?? ''),
            'quote'  => $quote,
            'avatar' => $avatarPath,
            'rating' => isset($_POST['rating']) ? (int)$_POST['rating'] : 5,
            'tag'    => trim($_POST['tag'] ?? 'Digital Investigation'),
            'order'  => isset($_POST['order']) ? (int)$_POST['order'] : 1,
            'status' => $_POST['status'] ?? 'active'
        ];

        $saved = ck_save_testimonial($testiData, $id);
        if ($saved) {
            ck_set_flash('success', "Testimonial by '{$name}' successfully saved!");
            header('Location: testimonials.php');
            exit;
        } else {
            ck_set_flash('error', 'Failed to save testimonial to file storage.');
        }
    }
}

// Fetch current testimonial if editing
$editingItem = null;
if ($action === 'edit' && $editId) {
    $editingItem = ck_get_testimonial($editId);
    if (!$editingItem) {
        ck_set_flash('error', "Testimonial not found.");
        header('Location: testimonials.php');
        exit;
    }
}

$testimonialsList = ck_get_testimonials(true);
$siteSettings = ck_get_settings();
$showTestimonialsMaster = !empty($siteSettings['show_testimonials']);

$adminPageTitle = 'Client Testimonials';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Client Testimonials &amp; Reviews</h1>
        <p class="page-header-desc">Manage verified client feedback, corporate case reviews, and testimonials displayed on the website.</p>
    </div>
    <?php if ($action === 'list'): ?>
    <div>
        <a href="testimonials.php?action=add" class="btn btn-primary">
            <span>+</span> Add Testimonial
        </a>
    </div>
    <?php else: ?>
    <div>
        <a href="testimonials.php" class="btn btn-secondary">
            &larr; Back to Testimonials List
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- ================= TESTIMONIALS VISIBILITY MASTER SWITCH BANNER ================= -->
<div style="background: rgba(13,13,38,0.7); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; align-items: center; gap: 0.85rem;">
        <span style="font-size: 1.4rem;">💬</span>
        <div>
            <div style="font-size: 0.92rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                Website Testimonials Visibility:
                <?php if ($showTestimonialsMaster): ?>
                    <span class="status-pill active">● Publicly Visible</span>
                <?php else: ?>
                    <span class="status-pill inactive" style="background: rgba(255,171,0,0.15); color: #ffab00; border-color: rgba(255,171,0,0.3);">○ Hidden from Website</span>
                <?php endif; ?>
            </div>
            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem;">
                <?= $showTestimonialsMaster 
                    ? 'Active testimonials are displayed on the website and linked in the footer.' 
                    : 'The entire testimonials section is currently HIDDEN from the public website.' ?>
            </div>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
        <a href="../cyber-intelligence.php#ci-testimonials" target="_blank" class="btn btn-secondary btn-sm" title="View live on website">
            Preview on Website ➔
        </a>
        <form method="POST" action="testimonials.php" style="margin: 0;">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="toggle_visibility">
            <?php if ($showTestimonialsMaster): ?>
                <button type="submit" class="btn btn-secondary btn-sm" style="border-color: rgba(255,171,0,0.4); color: #ffab00;">
                    Hide All from Website
                </button>
            <?php else: ?>
                <button type="submit" class="btn btn-primary btn-sm">
                    Make Visible on Website
                </button>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Testimonial: ' . htmlspecialchars($editingItem['name']) : 'Add New Client Testimonial' ?></h3>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="testimonials.php" enctype="multipart/form-data">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id']) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Client Name / Pseudonym <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Rajesh M." value="<?= htmlspecialchars($editingItem['name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Client Role &amp; Organization <span class="required">*</span></label>
                    <input type="text" id="role" name="role" class="form-control" required placeholder="e.g. Managing Partner, Legal Advisory" value="<?= htmlspecialchars($editingItem['role'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="tag" class="form-label">Service Tag</label>
                    <input type="text" id="tag" name="tag" class="form-control" placeholder="e.g. Digital Forensics / Cyber Defense" value="<?= htmlspecialchars($editingItem['tag'] ?? 'Digital Forensics') ?>">
                </div>

                <div class="form-group">
                    <label for="rating" class="form-label">Star Rating</label>
                    <select id="rating" name="rating" class="form-control">
                        <option value="5" <?= (($editingItem['rating'] ?? 5) == 5) ? 'selected' : '' ?>>⭐⭐⭐⭐⭐ (5 Stars)</option>
                        <option value="4" <?= (($editingItem['rating'] ?? 5) == 4) ? 'selected' : '' ?>>⭐⭐⭐⭐ (4 Stars)</option>
                        <option value="3" <?= (($editingItem['rating'] ?? 5) == 3) ? 'selected' : '' ?>>⭐⭐⭐ (3 Stars)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="order" class="form-label">Display Order</label>
                    <input type="number" id="order" name="order" class="form-control" min="1" value="<?= htmlspecialchars($editingItem['order'] ?? (count($testimonialsList) + 1)) ?>">
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Publication Status</label>
                    <select id="status" name="status" class="form-control" style="font-weight: 600;">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Hidden (Hide from Website)</option>
                    </select>
                    <span class="form-help">Choose whether this testimonial should appear on the public website.</span>
                </div>

                <div class="form-group col-full">
                    <label for="avatar" class="form-label">Client Photo / Avatar</label>
                    <div class="input-with-preview">
                        <?php 
                        $currentAvatar = $editingItem['avatar'] ?? 'assets/images/avatar_karthik.jpg';
                        ?>
                        <img src="../<?= htmlspecialchars($currentAvatar) ?>" alt="" class="preview-box" id="avatarPreview" style="border-radius: 50%;">
                        <div style="flex: 1;">
                            <input type="file" id="avatar_file" name="avatar_file" class="form-control" accept="image/*" data-preview="#avatarPreview" style="margin-bottom: 0.5rem;">
                            <input type="text" id="avatar" name="avatar" class="form-control" placeholder="assets/images/avatar_karthik.jpg" value="<?= htmlspecialchars($currentAvatar) ?>">
                            <span class="form-help">Upload client portrait (JPG/PNG/WebP) or specify image path.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-full">
                    <label for="quote" class="form-label">Client Testimonial Quote <span class="required">*</span></label>
                    <textarea id="quote" name="quote" rows="4" class="form-control" required placeholder="Detailed feedback or case resolution statement..."><?= htmlspecialchars($editingItem['quote'] ?? '') ?></textarea>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="testimonials.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Testimonial
                </button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">All Testimonials (<?= count($testimonialsList) ?>)</h3>
        <a href="../cyber-intelligence.php#ci-testimonials" target="_blank" class="btn btn-secondary btn-sm" title="Preview testimonials section on live website">Preview on Website ➔</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Avatar</th>
                    <th>Client / Organization</th>
                    <th>Quote Excerpt</th>
                    <th>Service Tag</th>
                    <th>Rating</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($testimonialsList)): ?>
                    <?php foreach ($testimonialsList as $t): ?>
                    <tr>
                        <td>
                            <img src="../<?= htmlspecialchars($t['avatar'] ?? 'assets/images/avatar_karthik.jpg') ?>" alt="" class="table-avatar">
                        </td>
                        <td>
                            <span class="cell-title"><?= htmlspecialchars($t['name']) ?></span>
                            <span class="cell-subtitle"><?= htmlspecialchars($t['role'] ?? '') ?></span>
                        </td>
                        <td style="max-width: 320px;">
                            <p style="font-size: 0.82rem; color: var(--text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                &ldquo;<?= htmlspecialchars($t['quote']) ?>&rdquo;
                            </p>
                        </td>
                        <td>
                            <span class="category-tag"><?= htmlspecialchars($t['tag'] ?? 'Investigation') ?></span>
                        </td>
                        <td style="color: #ffab00; font-size: 0.85rem;">
                            <?= str_repeat('★', (int)($t['rating'] ?? 5)) ?>
                        </td>
                        <td>
                            <form method="POST" action="testimonials.php" style="display:inline; margin:0;">
                                <?= ck_csrf_field() ?>
                                <input type="hidden" name="action" value="toggle_status">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($t['id']) ?>">
                                <?php if (($t['status'] ?? 'active') === 'active'): ?>
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
                                <form method="POST" action="testimonials.php" style="display:inline; margin:0;">
                                    <?= ck_csrf_field() ?>
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($t['id']) ?>">
                                    <?php if (($t['status'] ?? 'active') === 'active'): ?>
                                        <button type="submit" class="btn-action hide" title="Hide this testimonial from website">
                                            Hide
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" class="btn-action show" title="Make this testimonial visible on website">
                                            Show
                                        </button>
                                    <?php endif; ?>
                                </form>
                                <a href="testimonials.php?action=edit&id=<?= urlencode($t['id']) ?>" class="btn-action edit">Edit</a>
                                <button type="button" class="btn-action delete" onclick="confirmDelete('testimonials.php', '<?= htmlspecialchars(addslashes($t['name'])) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'id\' value=\'<?= htmlspecialchars($t['id']) ?>\'>';">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                            No testimonials found. Click "Add Testimonial" above to add your first review.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

