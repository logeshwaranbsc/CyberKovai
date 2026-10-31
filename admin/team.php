<?php
/**
 * Cyber Kovai - Our Team Management (CRUD)
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action = $_GET['action'] ?? 'list';
$editId = $_GET['id'] ?? null;

// Handle Form Submissions (Create, Update, Delete) BEFORE ANY HTML OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: team.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    if ($postAction === 'toggle_visibility') {
        $curSettings = ck_get_settings();
        $newVal = empty($curSettings['show_team']);
        ck_save_settings(['show_team' => $newVal]);
        ck_set_flash('success', $newVal ? 'Our Team section is now VISIBLE on the website and navigation menus.' : 'Our Team section is now HIDDEN from the website and navigation menus.');
        header('Location: team.php');
        exit;
    }

    if ($postAction === 'delete') {
        $deleteId = $_POST['id'] ?? '';
        if (!empty($deleteId)) {
            $deleted = ck_delete_team_member($deleteId);
            if ($deleted) {
                ck_set_flash('success', "Team member was successfully removed.");
            } else {
                ck_set_flash('error', "Could not remove team member.");
            }
        }
        header('Location: team.php');
        exit;
    }

    if ($postAction === 'save') {
        $id = !empty($_POST['id']) ? trim($_POST['id']) : null;
        $name = trim($_POST['name'] ?? '');
        $role = trim($_POST['role'] ?? '');

        if ($name === '' || $role === '') {
            ck_set_flash('error', 'Leader name and professional role cannot be empty.');
            header('Location: team.php?action=' . ($id ? "edit&id={$id}" : 'add'));
            exit;
        }

        // Handle photo upload if provided
        $photoPath = trim($_POST['photo'] ?? 'assets/images/arun_s.png');
        if (!empty($_FILES['photo_file']) && $_FILES['photo_file']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploadResult = ck_handle_upload($_FILES['photo_file'], 'team');
            if ($uploadResult['success']) {
                $photoPath = $uploadResult['path'];
            } else {
                ck_set_flash('warning', 'Photo upload notice: ' . $uploadResult['error'] . '. Retained existing photo.');
            }
        }

        // Parse up to 4 domain capabilities
        $domains = [];
        for ($d = 1; $d <= 4; $d++) {
            $dTitle = trim($_POST["domain_title_{$d}"] ?? '');
            $dDesc  = trim($_POST["domain_desc_{$d}"] ?? '');
            $dIcon  = trim($_POST["domain_icon_{$d}"] ?? '🛡️');
            if ($dTitle !== '') {
                $domains[] = [
                    'icon'  => $dIcon,
                    'title' => $dTitle,
                    'desc'  => $dDesc
                ];
            }
        }

        $memberData = [
            'id'              => $id,
            'name'            => $name,
            'role'            => $role,
            'company'         => trim($_POST['company'] ?? 'Cyber Kovai'),
            'experience'      => trim($_POST['experience'] ?? '10+'),
            'badge'           => trim($_POST['badge'] ?? 'Verified Security Leader'),
            'photo'           => $photoPath,
            'specializations' => $_POST['specializations'] ?? '',
            'bio'             => trim($_POST['bio'] ?? ''),
            'domains'         => $domains,
            'order'           => isset($_POST['order']) ? (int)$_POST['order'] : 1,
            'status'          => $_POST['status'] ?? 'active'
        ];

        $saved = ck_save_team_member($memberData, $id);
        if ($saved) {
            ck_set_flash('success', "Team profile for '{$name}' successfully saved!");
            header('Location: team.php');
            exit;
        } else {
            ck_set_flash('error', 'Failed to save team member to file storage.');
        }
    }
}

// Fetch current team member if editing
$editingItem = null;
if ($action === 'edit' && $editId) {
    $editingItem = ck_get_team_member($editId);
    if (!$editingItem) {
        ck_set_flash('error', "Team member not found.");
        header('Location: team.php');
        exit;
    }
}

$teamList = ck_get_team_members(true);
$siteSettings = ck_get_settings();

$adminPageTitle = 'Our Team & Leadership';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Our Team &amp; Security Architects</h1>
        <p class="page-header-desc">Manage leadership profiles, verified security leader badges, expertise domains, and biographies.</p>
    </div>
    <?php if ($action === 'list'): ?>
    <div>
        <a href="team.php?action=add" class="btn btn-primary">
            <span>+</span> Add Team Member
        </a>
    </div>
    <?php else: ?>
    <div>
        <a href="team.php" class="btn btn-secondary">
            &larr; Back to Team List
        </a>
    </div>
    <?php endif; ?>
</div>

<!-- ================= TEAM VISIBILITY MASTER SWITCH BANNER ================= -->
<div style="background: rgba(13,13,38,0.7); border: 1px solid var(--border-color); border-radius: var(--radius-sm); padding: 1rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; align-items: center; gap: 0.85rem;">
        <span style="font-size: 1.4rem;">👥</span>
        <div>
            <div style="font-size: 0.92rem; font-weight: 700; color: var(--text-primary); display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
                Website Team Visibility:
                <?php if (!empty($siteSettings['show_team'])): ?>
                    <span class="status-pill active">● Publicly Visible</span>
                <?php else: ?>
                    <span class="status-pill inactive" style="background: rgba(255,171,0,0.15); color: #ffab00; border-color: rgba(255,171,0,0.3);">○ Hidden from Website</span>
                <?php endif; ?>
            </div>
            <div style="font-size: 0.78rem; color: var(--text-muted); margin-top: 0.2rem;">
                <?= !empty($siteSettings['show_team']) 
                    ? '"Our Team" link is active in the header menu &amp; footer, and /team.php is accessible.' 
                    : '"Our Team" link is hidden from all menus, and /team.php safely redirects to the About page.' ?>
            </div>
        </div>
    </div>
    <form method="POST" action="team.php" style="margin: 0;">
        <?= ck_csrf_field() ?>
        <input type="hidden" name="action" value="toggle_visibility">
        <?php if (!empty($siteSettings['show_team'])): ?>
            <button type="submit" class="btn btn-secondary btn-sm" style="border-color: rgba(255,171,0,0.4); color: #ffab00;">
                Hide Team from Website
            </button>
        <?php else: ?>
            <button type="submit" class="btn btn-primary btn-sm">
                Make Team Visible on Website
            </button>
        <?php endif; ?>
    </form>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Team Member: ' . htmlspecialchars($editingItem['name']) : 'Add New Team Member' ?></h3>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="team.php" enctype="multipart/form-data">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id']) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" class="form-control" required placeholder="e.g. Arun S" value="<?= htmlspecialchars($editingItem['name'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">Professional Role / Title <span class="required">*</span></label>
                    <input type="text" id="role" name="role" class="form-control" required placeholder="e.g. Principal Security Architect" value="<?= htmlspecialchars($editingItem['role'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="company" class="form-label">Company / Affiliation Tag</label>
                    <input type="text" id="company" name="company" class="form-control" placeholder="e.g. IBM India or Cyber Kovai" value="<?= htmlspecialchars($editingItem['company'] ?? 'IBM India') ?>">
                    <span class="form-help">Appears as highlighted badge next to the role</span>
                </div>

                <div class="form-group">
                    <label for="experience" class="form-label">Years of Experience Badge</label>
                    <input type="text" id="experience" name="experience" class="form-control" placeholder="12+" value="<?= htmlspecialchars($editingItem['experience'] ?? '12+') ?>">
                    <span class="form-help">Badge shown over the photo (e.g. 12+)</span>
                </div>

                <div class="form-group">
                    <label for="badge" class="form-label">Verification Badge Label</label>
                    <input type="text" id="badge" name="badge" class="form-control" placeholder="Verified Security Leader" value="<?= htmlspecialchars($editingItem['badge'] ?? 'Verified Security Leader') ?>">
                </div>

                <div class="form-group">
                    <label for="order" class="form-label">Display Order</label>
                    <input type="number" id="order" name="order" class="form-control" min="1" value="<?= htmlspecialchars($editingItem['order'] ?? (count($teamList) + 1)) ?>">
                </div>

                <div class="form-group col-full">
                    <label for="status" class="form-label">Publication Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Draft / Hidden</option>
                    </select>
                </div>

                <div class="form-group col-full">
                    <label for="photo" class="form-label">Leader Portrait Photo</label>
                    <div class="input-with-preview">
                        <?php 
                        $currentPhoto = $editingItem['photo'] ?? 'assets/images/arun_s.png';
                        ?>
                        <img src="../<?= htmlspecialchars($currentPhoto) ?>" alt="" class="preview-box" id="teamPhotoPreview">
                        <div style="flex: 1;">
                            <input type="file" id="photo_file" name="photo_file" class="form-control" accept="image/*" data-preview="#teamPhotoPreview" style="margin-bottom: 0.5rem;">
                            <input type="text" id="photo" name="photo" class="form-control" placeholder="assets/images/arun_s.png" value="<?= htmlspecialchars($currentPhoto) ?>">
                            <span class="form-help">Upload high-res portrait (PNG/JPG/WebP) or specify relative asset path.</span>
                        </div>
                    </div>
                </div>

                <div class="form-group col-full">
                    <label for="specializations" class="form-label">Specialization Tag Pills (Comma-separated)</label>
                    <?php 
                    $specsString = '';
                    if (!empty($editingItem['specializations'])) {
                        $specsString = is_array($editingItem['specializations']) ? implode(', ', $editingItem['specializations']) : $editingItem['specializations'];
                    }
                    ?>
                    <input type="text" id="specializations" name="specializations" class="form-control" placeholder="Product Security Expert, Security Architect, Cyber Strategist, Cyber Crime Investigator" value="<?= htmlspecialchars($specsString) ?>">
                    <span class="form-help">Separate tags by commas. Rendered as purple badges on the team card.</span>
                </div>

                <div class="form-group col-full">
                    <label for="bio" class="form-label">Executive Biography / Statement</label>
                    <textarea id="bio" name="bio" rows="3" class="form-control" placeholder="Principal Security Architect with 12+ years across cybersecurity leadership..."><?= htmlspecialchars($editingItem['bio'] ?? '') ?></textarea>
                </div>

                <!-- Domain Capabilities (4 Domains) -->
                <div class="form-group col-full" style="padding-top: 1rem; border-top: 1px solid var(--border-color);">
                    <h4 style="font-size: 0.95rem; color: var(--accent-purple-light); margin-bottom: 0.5rem;">
                        Domain Capabilities (Up to 4 Core Practice Areas)
                    </h4>
                    <p style="font-size: 0.78rem; color: var(--text-muted); margin-bottom: 1rem;">
                        Showcased in the 2x2 capability grid at the bottom of the leader profile.
                    </p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                        <?php 
                        $domains = $editingItem['domains'] ?? [];
                        for ($i = 1; $i <= 4; $i++): 
                            $d = $domains[$i - 1] ?? [];
                        ?>
                        <div style="padding: 1rem; background: rgba(5,5,17,0.5); border: 1px solid var(--border-color); border-radius: var(--radius-sm);">
                            <div style="font-size: 0.8rem; font-weight: 700; color: var(--text-muted); margin-bottom: 0.5rem;">
                                Domain #<?= $i ?>
                            </div>
                            <div style="display: flex; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <input type="text" name="domain_icon_<?= $i ?>" class="form-control" style="width: 55px; text-align: center;" placeholder="🛡️" value="<?= htmlspecialchars($d['icon'] ?? '🛡️') ?>" title="Icon">
                                <input type="text" name="domain_title_<?= $i ?>" class="form-control" placeholder="Domain Title" value="<?= htmlspecialchars($d['title'] ?? '') ?>">
                            </div>
                            <input type="text" name="domain_desc_<?= $i ?>" class="form-control" placeholder="Sub-capabilities (e.g. VAPT, Threat Modeling)" value="<?= htmlspecialchars($d['desc'] ?? '') ?>">
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="team.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Team Member Profile
                </button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Leadership &amp; Security Architects (<?= count($teamList) ?>)</h3>
        <a href="../team.php" target="_blank" class="btn btn-secondary btn-sm">Preview Public Team Page ➔</a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 65px;">Photo</th>
                    <th>Leader Name</th>
                    <th>Role &amp; Affiliation</th>
                    <th>Experience</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($teamList)): ?>
                    <?php foreach ($teamList as $m): ?>
                    <tr>
                        <td>
                            <img src="../<?= htmlspecialchars($m['photo'] ?? 'assets/images/arun_s.png') ?>" alt="" class="table-thumbnail">
                        </td>
                        <td>
                            <span class="cell-title"><?= htmlspecialchars($m['name']) ?></span>
                            <?php if (!empty($m['badge'])): ?>
                                <span class="cell-subtitle" style="color: var(--accent-purple-light);">● <?= htmlspecialchars($m['badge']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="font-weight: 600; color: var(--text-primary);"><?= htmlspecialchars($m['role']) ?></span>
                            <?php if (!empty($m['company'])): ?>
                                <span class="category-tag" style="margin-left: 0.35rem;"><?= htmlspecialchars($m['company']) ?></span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span class="status-pill active" style="font-weight: 700;">
                                <?= htmlspecialchars($m['experience'] ?? '10+') ?> YEARS
                            </span>
                        </td>
                        <td>
                            <span class="status-pill <?= (($m['status'] ?? 'active') === 'active') ? 'active' : 'inactive' ?>">
                                <?= htmlspecialchars($m['status'] ?? 'active') ?>
                            </span>
                        </td>
                        <td style="text-align: right;">
                            <div class="action-btns-group" style="justify-content: flex-end;">
                                <a href="../team.php" target="_blank" class="btn-action view" title="View live on website">View</a>
                                <a href="team.php?action=edit&id=<?= urlencode($m['id']) ?>" class="btn-action edit">Edit</a>
                                <button type="button" class="btn-action delete" onclick="confirmDelete('team.php', '<?= htmlspecialchars(addslashes($m['name'])) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'id\' value=\'<?= htmlspecialchars($m['id']) ?>\'>';">
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                            No team profiles found. Click "Add Team Member" above to create a leadership profile.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

