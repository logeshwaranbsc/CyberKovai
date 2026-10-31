<?php
/**
 * Cyber Kovai - Cyber Services Management (CRUD)
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action = $_GET['action'] ?? 'list';
$editSlug = $_GET['slug'] ?? null;
$categoryFilter = $_GET['category'] ?? 'all';

$categories = ck_get_cyber_categories();

// Handle Form Submissions (Create, Update, Delete) BEFORE ANY HTML OUTPUT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: services-cyber.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    if ($postAction === 'delete') {
        $deleteSlug = $_POST['slug'] ?? '';
        if (!empty($deleteSlug)) {
            $deleted = ck_delete_cyber_service($deleteSlug);
            if ($deleted) {
                ck_set_flash('success', "Cyber service '{$deleteSlug}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete cyber service '{$deleteSlug}'.");
            }
        }
        header('Location: services-cyber.php');
        exit;
    }

    if ($postAction === 'save') {
        $originalSlug = !empty($_POST['original_slug']) ? trim($_POST['original_slug']) : null;
        $title = trim($_POST['title'] ?? '');
        $slug = !empty($_POST['slug']) ? ck_slugify($_POST['slug']) : ck_slugify($title);

        if ($title === '') {
            ck_set_flash('error', 'Service title cannot be empty.');
            header('Location: services-cyber.php?action=' . ($originalSlug ? "edit&slug={$originalSlug}" : 'add'));
            exit;
        }

        $serviceData = [
            'slug'         => $slug,
            'title'        => $title,
            'nav_label'    => trim($_POST['nav_label'] ?? $title),
            'category'     => trim($_POST['category'] ?? 'application-security'),
            'badge'        => trim($_POST['badge'] ?? ''),
            'tagline'      => trim($_POST['tagline'] ?? ''),
            'short_desc'   => trim($_POST['short_desc'] ?? ''),
            'overview'     => trim($_POST['overview'] ?? ''),
            'why_needed'   => trim($_POST['why_needed'] ?? ''),
            'key_features' => $_POST['key_features'] ?? '',
            'deliverables' => $_POST['deliverables'] ?? '',
            'status'       => $_POST['status'] ?? 'active'
        ];

        $saved = ck_save_cyber_service($serviceData, $originalSlug);
        if ($saved) {
            ck_set_flash('success', "Cyber service '{$title}' successfully saved!");
            header('Location: services-cyber.php');
            exit;
        } else {
            ck_set_flash('error', 'Failed to save cyber service to storage.');
        }
    }
}

// Fetch current service if editing
$editingItem = null;
if ($action === 'edit' && $editSlug) {
    $editingItem = ck_get_cyber_service($editSlug);
    if (!$editingItem) {
        ck_set_flash('error', "Cyber service '{$editSlug}' not found.");
        header('Location: services-cyber.php');
        exit;
    }
}

$allCyberServices = ck_get_cyber_services(true);

// Apply category filter if requested
$filteredServices = [];
foreach ($allCyberServices as $sSlug => $s) {
    if ($categoryFilter !== 'all' && ($s['category'] ?? '') !== $categoryFilter) {
        continue;
    }
    $filteredServices[$sSlug] = $s;
}

$adminPageTitle = 'Cyber Security Services';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Cyber Security &amp; Defense Services</h1>
        <p class="page-header-desc">Manage penetration testing, cloud architecture, network hardening, and enterprise cybersecurity services.</p>
    </div>
    <?php if ($action === 'list'): ?>
    <div>
        <a href="services-cyber.php?action=add" class="btn btn-primary">
            <span>+</span> Add Cyber Service
        </a>
    </div>
    <?php else: ?>
    <div>
        <a href="services-cyber.php" class="btn btn-secondary">
            &larr; Back to Services List
        </a>
    </div>
    <?php endif; ?>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit Cyber Service: ' . htmlspecialchars($editingItem['title']) : 'Add New Cyber Service' ?></h3>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="services-cyber.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="original_slug" value="<?= htmlspecialchars($editSlug) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <div class="form-group col-full">
                    <label for="title" class="form-label">Full Service Title <span class="required">*</span></label>
                    <input type="text" id="title" name="title" class="form-control" required data-slug-source placeholder="e.g. REST & GraphQL API Penetration Testing" value="<?= htmlspecialchars($editingItem['title'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="slug" class="form-label">URL Slug <span class="required">*</span></label>
                    <input type="text" id="slug" name="slug" class="form-control" required data-slug-target placeholder="e.g. api-penetration-testing" value="<?= htmlspecialchars($editSlug ?? '') ?>">
                    <span class="form-help">Unique URL path (e.g. /services/api-penetration-testing.php)</span>
                </div>

                <div class="form-group">
                    <label for="category" class="form-label">Security Category <span class="required">*</span></label>
                    <select id="category" name="category" class="form-control" required>
                        <?php foreach ($categories as $catKey => $cat): ?>
                            <option value="<?= htmlspecialchars($catKey) ?>" <?= (($editingItem['category'] ?? '') === $catKey) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="nav_label" class="form-label">Menu / Navigation Label</label>
                    <input type="text" id="nav_label" name="nav_label" class="form-control" placeholder="e.g. API Security Testing" value="<?= htmlspecialchars($editingItem['nav_label'] ?? '') ?>">
                    <span class="form-help">Compact label for header dropdown &amp; mega menu lists</span>
                </div>

                <div class="form-group">
                    <label for="badge" class="form-label">Certification / Standard Badge</label>
                    <input type="text" id="badge" name="badge" class="form-control" placeholder="e.g. OWASP API Security Top 10" value="<?= htmlspecialchars($editingItem['badge'] ?? '') ?>">
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Publication Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Draft / Hidden</option>
                    </select>
                </div>

                <div class="form-group col-full">
                    <label for="tagline" class="form-label">Hero Tagline</label>
                    <input type="text" id="tagline" name="tagline" class="form-control" placeholder="Short impactful punchline for the hero banner..." value="<?= htmlspecialchars($editingItem['tagline'] ?? '') ?>">
                </div>

                <div class="form-group col-full">
                    <label for="short_desc" class="form-label">Short Description <span class="required">*</span></label>
                    <textarea id="short_desc" name="short_desc" rows="3" class="form-control" required placeholder="Concise 1-2 sentence description for cards and search summaries..."><?= htmlspecialchars($editingItem['short_desc'] ?? '') ?></textarea>
                </div>

                <div class="form-group col-full">
                    <label for="overview" class="form-label">Detailed Overview</label>
                    <textarea id="overview" name="overview" rows="5" class="form-control" placeholder="Detailed service description displayed on the dedicated service page..."><?= htmlspecialchars($editingItem['overview'] ?? '') ?></textarea>
                </div>

                <div class="form-group col-full">
                    <label for="why_needed" class="form-label">Why This Service is Critical ("Why Needed" Section)</label>
                    <textarea id="why_needed" name="why_needed" rows="3" class="form-control" placeholder="Explain the risks, business impacts, or regulatory mandates..."><?= htmlspecialchars($editingItem['why_needed'] ?? '') ?></textarea>
                </div>

                <div class="form-group col-full">
                    <label for="key_features" class="form-label">Key Features (One feature per line, format: "Feature Title: Feature Description")</label>
                    <?php 
                    $featuresText = '';
                    if (!empty($editingItem['key_features'])) {
                        foreach ($editingItem['key_features'] as $f) {
                            $featuresText .= ($f['title'] ?? '') . ': ' . ($f['desc'] ?? '') . "\n";
                        }
                    }
                    ?>
                    <textarea id="key_features" name="key_features" rows="5" class="form-control" placeholder="Dual Methodology: Automated and manual verification&#10;Threat Modeling: Realistic adversary simulations&#10;Business Logic Flaws: Nuanced state testing"><?= htmlspecialchars(trim($featuresText)) ?></textarea>
                    <span class="form-help">Enter each capability on a new line.</span>
                </div>

                <div class="form-group col-full">
                    <label for="deliverables" class="form-label">Deliverables (One item per line)</label>
                    <?php 
                    $delivText = '';
                    if (!empty($editingItem['deliverables'])) {
                        $delivText = implode("\n", $editingItem['deliverables']);
                    }
                    ?>
                    <textarea id="deliverables" name="deliverables" rows="4" class="form-control" placeholder="Executive Summary Report&#10;Technical Vulnerability Dossier with CVSS v3.1&#10;Proof of Concept (PoC) Exploit Code&#10;Complimentary Re-Testing Attestation"><?= htmlspecialchars(trim($delivText)) ?></textarea>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="services-cyber.php" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save Cyber Service
                </button>
            </div>
        </form>
    </div>
</div>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">All Cyber Services (<?= count($filteredServices) ?> of <?= count($allCyberServices) ?>)</h3>
        
        <!-- Category Filter Pills -->
        <div style="display: flex; gap: 0.4rem; flex-wrap: wrap;">
            <a href="services-cyber.php?category=all" class="btn btn-sm <?= ($categoryFilter === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
                All (<?= count($allCyberServices) ?>)
            </a>
            <?php foreach ($categories as $catKey => $c): 
                $countInCat = 0;
                foreach ($allCyberServices as $s) {
                    if (($s['category'] ?? '') === $catKey) $countInCat++;
                }
            ?>
            <a href="services-cyber.php?category=<?= urlencode($catKey) ?>" class="btn btn-sm <?= ($categoryFilter === $catKey) ? 'btn-primary' : 'btn-secondary' ?>">
                <?= htmlspecialchars($c['name']) ?> (<?= $countInCat ?>)
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>Service Name</th>
                    <th>Category</th>
                    <th>Badge / Standard</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($filteredServices)): 
                    $rowIdx = 0;
                    foreach ($filteredServices as $sSlug => $svc): 
                        $rowIdx++;
                        $catName = $categories[$svc['category'] ?? '']['name'] ?? ucfirst($svc['category'] ?? 'General');
                ?>
                <tr>
                    <td><span style="font-weight: 700; color: var(--text-muted);"><?= $rowIdx ?></span></td>
                    <td>
                        <span class="cell-title"><?= htmlspecialchars($svc['title']) ?></span>
                        <span class="cell-subtitle">Slug: <code style="color: var(--accent-purple-light);"><?= htmlspecialchars($sSlug) ?></code></span>
                    </td>
                    <td>
                        <span class="category-tag"><?= htmlspecialchars($catName) ?></span>
                    </td>
                    <td>
                        <span style="font-size: 0.8rem; color: var(--text-muted);">
                            <?= htmlspecialchars($svc['badge'] ?? '—') ?>
                        </span>
                    </td>
                    <td>
                        <span class="status-pill <?= (($svc['status'] ?? 'active') === 'active') ? 'active' : 'inactive' ?>">
                            <?= htmlspecialchars($svc['status'] ?? 'active') ?>
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div class="action-btns-group" style="justify-content: flex-end;">
                            <a href="../services/<?= htmlspecialchars($sSlug) ?>.php" target="_blank" class="btn-action view" title="View live page">View</a>
                            <a href="services-cyber.php?action=edit&slug=<?= urlencode($sSlug) ?>" class="btn-action edit">Edit</a>
                            <button type="button" class="btn-action delete" onclick="confirmDelete('services-cyber.php', '<?= htmlspecialchars(addslashes($svc['title'])) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'slug\' value=\'<?= htmlspecialchars($sSlug) ?>\'>';">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 2.5rem; color: var(--text-muted);">
                        No cyber services found in this category. Click "Add Cyber Service" above to create one.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

