<?php
/**
 * Cyber Kovai - Frequently Asked Questions (CRUD)
 * Allows managing FAQs separated by track:
 * - Digital Investigation & Forensics (cyber-intelligence.php)
 * - Cyber Security & VAPT (digital-forensics.php)
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$action        = $_GET['action'] ?? 'list';
$editId        = $_GET['id'] ?? null;
$currentTrack  = $_GET['track'] ?? 'all';
$currentStatus = $_GET['status'] ?? 'all';
$searchQuery   = trim($_GET['q'] ?? '');

// Handle Form Submissions (Create, Update, Delete, Toggle Status)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!ck_csrf_verify()) {
        ck_set_flash('error', 'Security token expired. Please try again.');
        header('Location: faqs.php' . ($currentTrack !== 'all' ? "?track={$currentTrack}" : ''));
        exit;
    }

    $postAction = $_POST['action'] ?? 'save';

    // 1. Delete FAQ
    if ($postAction === 'delete') {
        $deleteId = $_POST['id'] ?? '';
        if (!empty($deleteId)) {
            $faq = ck_get_faq($deleteId);
            $qText = $faq['question'] ?? "FAQ #{$deleteId}";
            $deleted = ck_delete_faq($deleteId);
            if ($deleted) {
                ck_set_flash('success', "FAQ '{$qText}' was successfully deleted.");
            } else {
                ck_set_flash('error', "Could not delete FAQ.");
            }
        }
        header('Location: faqs.php' . ($currentTrack !== 'all' ? "?track={$currentTrack}" : ''));
        exit;
    }

    // 2. Toggle Status (Active / Hidden)
    if ($postAction === 'toggle_status') {
        $toggleId = $_POST['id'] ?? '';
        if (!empty($toggleId)) {
            $newStatus = ck_toggle_faq_status($toggleId);
            if ($newStatus !== false) {
                $faq = ck_get_faq($toggleId);
                $qText = $faq['question'] ?? "FAQ #{$toggleId}";
                if ($newStatus === 'active') {
                    ck_set_flash('success', "FAQ is now ACTIVE and visible on the website.");
                } else {
                    ck_set_flash('success', "FAQ is now HIDDEN from the website.");
                }
            } else {
                ck_set_flash('error', 'Could not toggle FAQ status.');
            }
        }
        header('Location: faqs.php' . ($currentTrack !== 'all' ? "?track={$currentTrack}" : ''));
        exit;
    }

    // 3. Save (Create or Update) FAQ
    if ($postAction === 'save') {
        $id       = !empty($_POST['id']) ? trim($_POST['id']) : null;
        $track    = $_POST['track'] ?? 'investigation';
        $question = trim($_POST['question'] ?? '');
        $answer   = trim($_POST['answer'] ?? '');
        $category = trim($_POST['category'] ?? 'General');
        $status   = $_POST['status'] ?? 'active';

        if ($question === '' || $answer === '') {
            ck_set_flash('error', 'Both Question and Answer fields are required.');
            header('Location: faqs.php?action=' . ($id ? "edit&id={$id}" : 'add') . "&track={$track}");
            exit;
        }

        $allTrackExisting = ck_get_faqs($track, true);
        $order = isset($_POST['order']) && $_POST['order'] !== '' ? (int)$_POST['order'] : (count($allTrackExisting) + 1);

        $faqData = [
            'id'       => $id,
            'track'    => in_array($track, ['investigation', 'cyber', 'both'], true) ? $track : 'investigation',
            'question' => $question,
            'answer'   => $answer,
            'category' => $category,
            'order'    => $order,
            'status'   => $status
        ];

        $saved = ck_save_faq($faqData, $id);
        if ($saved) {
            ck_set_flash('success', "FAQ successfully saved!");
            header('Location: faqs.php?track=' . urlencode($track));
            exit;
        } else {
            ck_set_flash('error', 'Failed to save FAQ to storage.');
        }
    }
}

// Fetch current item if editing
$editingItem = null;
if ($action === 'edit' && $editId) {
    $editingItem = ck_get_faq($editId);
    if (!$editingItem) {
        ck_set_flash('error', "FAQ #{$editId} not found.");
        header('Location: faqs.php');
        exit;
    }
}

// Retrieve datasets for metrics & listing
$allFaqs = ck_get_faqs('all', true);

$countAll          = count($allFaqs);
$countInv          = count(ck_get_faqs('investigation', true));
$countCyber        = count(ck_get_faqs('cyber', true));
$countActiveMaster = 0;
$countHiddenMaster = 0;
foreach ($allFaqs as $f) {
    if (($f['status'] ?? 'active') === 'active') {
        $countActiveMaster++;
    } else {
        $countHiddenMaster++;
    }
}

// Filter dataset for current view
$displayList = $allFaqs;

if ($currentTrack !== 'all') {
    $displayList = array_filter($displayList, function($f) use ($currentTrack) {
        $t = $f['track'] ?? 'both';
        return ($t === $currentTrack || $t === 'both');
    });
}

if ($currentStatus === 'active') {
    $displayList = array_filter($displayList, function($f) {
        return ($f['status'] ?? 'active') === 'active';
    });
} elseif ($currentStatus === 'inactive') {
    $displayList = array_filter($displayList, function($f) {
        return ($f['status'] ?? 'active') === 'inactive';
    });
}

if ($searchQuery !== '') {
    $needle = mb_strtolower($searchQuery);
    $displayList = array_filter($displayList, function($f) use ($needle) {
        $q = mb_strtolower($f['question'] ?? '');
        $a = mb_strtolower($f['answer'] ?? '');
        $c = mb_strtolower($f['category'] ?? '');
        return (mb_strpos($q, $needle) !== false || mb_strpos($a, $needle) !== false || mb_strpos($c, $needle) !== false);
    });
}

$adminPageTitle = 'Frequently Asked Questions (FAQs)';
require_once __DIR__ . '/includes/header.php';
?>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Frequently Asked Questions (FAQs)</h1>
        <p class="page-header-desc">Manage client questions and answers separately for Digital Investigation and Cyber Security tracks.</p>
    </div>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <?php if ($action === 'list'): ?>
            <a href="faqs.php?action=add&track=<?= urlencode($currentTrack !== 'all' ? $currentTrack : 'investigation') ?>" class="btn btn-primary">
                <span>+</span> Add New FAQ
            </a>
            <a href="../cyber-intelligence.php#ci-faq" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Digital Investigation page">
                Preview Investigation FAQs ➔
            </a>
            <a href="../digital-forensics.php#faq" target="_blank" class="btn btn-secondary btn-sm" title="Preview on Cyber Security page">
                Preview Cyber FAQs ➔
            </a>
        <?php else: ?>
            <a href="faqs.php?track=<?= urlencode($currentTrack) ?>" class="btn btn-secondary">
                &larr; Back to FAQs List
            </a>
        <?php endif; ?>
    </div>
</div>

<?php if ($action === 'add' || $action === 'edit'): ?>
<!-- ================= ADD / EDIT FORM ================= -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title"><?= ($action === 'edit') ? 'Edit FAQ: ' . htmlspecialchars($editingItem['question']) : 'Add New Frequently Asked Question' ?></h3>
        <span class="category-tag">
            <?= ($action === 'edit') ? 'ID: ' . htmlspecialchars($editingItem['id']) : 'New Question' ?>
        </span>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="faqs.php">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="save">
            <?php if ($action === 'edit'): ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($editingItem['id']) ?>">
            <?php endif; ?>

            <div class="form-grid">
                <!-- Service Track Radio / Select -->
                <div class="form-group col-full">
                    <label class="form-label">Service Track <span class="required">*</span></label>
                    <?php 
                        $selectedTrack = $editingItem['track'] ?? ($currentTrack !== 'all' ? $currentTrack : 'investigation');
                    ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 0.85rem; margin-top: 0.25rem;">
                        <label style="display: flex; align-items: flex-start; gap: 0.65rem; padding: 0.9rem 1rem; border-radius: 10px; background: rgba(34, 211, 238, 0.08); border: 1px solid <?= $selectedTrack === 'investigation' ? '#22d3ee' : 'rgba(34, 211, 238, 0.25)' ?>; cursor: pointer;">
                            <input type="radio" name="track" value="investigation" <?= $selectedTrack === 'investigation' ? 'checked' : '' ?> style="margin-top: 3px;">
                            <div>
                                <strong style="color: #22d3ee; display: block; font-size: 0.9rem;">🔍 Digital Investigation</strong>
                                <span style="font-size: 0.78rem; color: var(--text-muted);">Displays on <code>cyber-intelligence.php#ci-faq</code> (Forensics, OSINT, Scams)</span>
                            </div>
                        </label>

                        <label style="display: flex; align-items: flex-start; gap: 0.65rem; padding: 0.9rem 1rem; border-radius: 10px; background: rgba(168, 85, 247, 0.08); border: 1px solid <?= $selectedTrack === 'cyber' ? '#c084fc' : 'rgba(168, 85, 247, 0.25)' ?>; cursor: pointer;">
                            <input type="radio" name="track" value="cyber" <?= $selectedTrack === 'cyber' ? 'checked' : '' ?> style="margin-top: 3px;">
                            <div>
                                <strong style="color: #c084fc; display: block; font-size: 0.9rem;">🛡️ Cyber Security</strong>
                                <span style="font-size: 0.78rem; color: var(--text-muted);">Displays on <code>digital-forensics.php#faq</code> (VAPT, Cloud, Audits)</span>
                            </div>
                        </label>

                        <label style="display: flex; align-items: flex-start; gap: 0.65rem; padding: 0.9rem 1rem; border-radius: 10px; background: rgba(52, 211, 153, 0.08); border: 1px solid <?= $selectedTrack === 'both' ? '#34d399' : 'rgba(52, 211, 153, 0.25)' ?>; cursor: pointer;">
                            <input type="radio" name="track" value="both" <?= $selectedTrack === 'both' ? 'checked' : '' ?> style="margin-top: 3px;">
                            <div>
                                <strong style="color: #34d399; display: block; font-size: 0.9rem;">🌐 Both Services</strong>
                                <span style="font-size: 0.78rem; color: var(--text-muted);">Universal questions displayed across both pages</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Topic Category -->
                <div class="form-group">
                    <label for="faq_category" class="form-label">Topic / Category Tag</label>
                    <input type="text" id="faq_category" name="category" class="form-control" placeholder="e.g. Evidence & Legal, VAPT Timelines, Confidentiality" value="<?= htmlspecialchars($editingItem['category'] ?? 'General') ?>">
                    <span class="form-help">Badge category shown alongside the question.</span>
                </div>

                <!-- Order Sequence -->
                <div class="form-group">
                    <label for="faq_order" class="form-label">Display Order Sequence</label>
                    <input type="number" id="faq_order" name="order" class="form-control" min="1" value="<?= htmlspecialchars($editingItem['order'] ?? (count($allFaqs) + 1)) ?>">
                    <span class="form-help">Position sequence in the accordion list (1 = first item).</span>
                </div>

                <!-- Status -->
                <div class="form-group">
                    <label for="faq_status" class="form-label">Publication Status</label>
                    <select id="faq_status" name="status" class="form-control" style="font-weight: 600;">
                        <option value="active" <?= (($editingItem['status'] ?? 'active') === 'active') ? 'selected' : '' ?>>Active (Visible on Website)</option>
                        <option value="inactive" <?= (($editingItem['status'] ?? '') === 'inactive') ? 'selected' : '' ?>>Hidden (Hide from Website)</option>
                    </select>
                    <span class="form-help">Instantly publish or unpublish this question.</span>
                </div>

                <!-- Question -->
                <div class="form-group col-full">
                    <label for="faq_question" class="form-label">Question Text <span class="required">*</span></label>
                    <input type="text" id="faq_question" name="question" class="form-control" required placeholder="e.g. Are your forensic reports admissible in court?" value="<?= htmlspecialchars($editingItem['question'] ?? '') ?>">
                    <span class="form-help">The primary question header clicked by the user to expand.</span>
                </div>

                <!-- Answer -->
                <div class="form-group col-full">
                    <label for="faq_answer" class="form-label">Detailed Answer <span class="required">*</span></label>
                    <textarea id="faq_answer" name="answer" rows="5" class="form-control" required placeholder="Provide clear, reassuring, and technically accurate answer..."><?= htmlspecialchars($editingItem['answer'] ?? '') ?></textarea>
                    <span class="form-help">Expanded answer content shown when the accordion expands.</span>
                </div>

                <!-- LIVE ACCORDION PREVIEW -->
                <div class="form-group col-full">
                    <label class="form-label">Live Accordion Preview (Real-time)</label>
                    <div style="background: radial-gradient(circle at center, #150f2e 0%, #060513 100%); padding: 1.75rem; border-radius: 14px; border: 1px dashed var(--border-color);">
                        <div class="admin-faq-preview">
                            <div class="admin-faq-preview-q">
                                <span id="previewQText"><?= htmlspecialchars($editingItem['question'] ?? 'Sample Question Preview') ?></span>
                                <span style="font-size: 1.1rem; color: var(--accent-cyan);">⌄</span>
                            </div>
                            <div class="admin-faq-preview-a">
                                <p id="previewAText" style="margin: 0;"><?= htmlspecialchars($editingItem['answer'] ?? 'Sample answer text preview will be rendered here as you type into the form fields above.') ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div style="padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; justify-content: flex-end; gap: 0.75rem;">
                <a href="faqs.php?track=<?= urlencode($currentTrack) ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <span>💾</span> Save FAQ
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const qInput = document.getElementById('faq_question');
    const aInput = document.getElementById('faq_answer');
    const previewQ = document.getElementById('previewQText');
    const previewA = document.getElementById('previewAText');

    function updatePreview() {
        if (qInput && previewQ) {
            previewQ.textContent = qInput.value.trim() !== '' ? qInput.value : 'Sample Question Preview';
        }
        if (aInput && previewA) {
            previewA.textContent = aInput.value.trim() !== '' ? aInput.value : 'Sample answer text preview will be rendered here as you type into the form fields above.';
        }
    }

    if (qInput) qInput.addEventListener('input', updatePreview);
    if (aInput) aInput.addEventListener('input', updatePreview);
});
</script>

<?php else: ?>
<!-- ================= LIST VIEW ================= -->

<!-- Track Navigation Tabs (Separating Investigation & Cyber) -->
<div style="display: flex; gap: 0.65rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
    <a href="faqs.php?track=all<?= ($currentStatus !== 'all') ? "&status={$currentStatus}" : '' ?>" class="btn btn-sm <?= ($currentTrack === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
        🌐 All Tracks (<?= $countAll ?>)
    </a>

    <a href="faqs.php?track=investigation<?= ($currentStatus !== 'all') ? "&status={$currentStatus}" : '' ?>" class="btn btn-sm <?= ($currentTrack === 'investigation') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentTrack === 'investigation') ? 'background: #22d3ee; border-color: #22d3ee; color: #000; font-weight: 700;' : '' ?>">
        🔍 Digital Investigation FAQs (<?= $countInv ?>)
    </a>

    <a href="faqs.php?track=cyber<?= ($currentStatus !== 'all') ? "&status={$currentStatus}" : '' ?>" class="btn btn-sm <?= ($currentTrack === 'cyber') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentTrack === 'cyber') ? 'background: #c084fc; border-color: #c084fc; color: #000; font-weight: 700;' : '' ?>">
        🛡️ Cyber Security FAQs (<?= $countCyber ?>)
    </a>
</div>

<!-- Secondary Filters: Status & Search -->
<div style="display: flex; gap: 0.75rem; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap;">
    <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
        <a href="faqs.php?track=<?= urlencode($currentTrack) ?>&status=all" class="btn btn-sm <?= ($currentStatus === 'all') ? 'btn-primary' : 'btn-secondary' ?>">
            All (<?= count($displayList) ?>)
        </a>
        <a href="faqs.php?track=<?= urlencode($currentTrack) ?>&status=active" class="btn btn-sm <?= ($currentStatus === 'active') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'active') ? 'background: #00e676; border-color: #00e676; color: #000;' : '' ?>">
            ● Active
        </a>
        <a href="faqs.php?track=<?= urlencode($currentTrack) ?>&status=inactive" class="btn btn-sm <?= ($currentStatus === 'inactive') ? 'btn-primary' : 'btn-secondary' ?>" style="<?= ($currentStatus === 'inactive') ? 'background: #ffab00; border-color: #ffab00; color: #000;' : '' ?>">
            ○ Hidden
        </a>
    </div>

    <form method="GET" action="faqs.php" style="display: flex; gap: 0.5rem; align-items: center; margin: 0;">
        <input type="hidden" name="track" value="<?= htmlspecialchars($currentTrack) ?>">
        <input type="hidden" name="status" value="<?= htmlspecialchars($currentStatus) ?>">
        <input type="text" name="q" class="form-control" placeholder="Search questions..." value="<?= htmlspecialchars($searchQuery) ?>" style="width: 220px; padding: 0.4rem 0.75rem; font-size: 0.82rem;">
        <button type="submit" class="btn btn-secondary btn-sm">Filter</button>
        <?php if ($searchQuery !== ''): ?>
            <a href="faqs.php?track=<?= urlencode($currentTrack) ?>&status=<?= urlencode($currentStatus) ?>" class="btn btn-secondary btn-sm" title="Clear search">✕</a>
        <?php endif; ?>
    </form>
</div>

<!-- Main Table Card -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">
            <?php if ($currentTrack === 'investigation'): ?>
                🔍 Digital Investigation &amp; Forensics FAQs (<?= count($displayList) ?>)
            <?php elseif ($currentTrack === 'cyber'): ?>
                🛡️ Cyber Security &amp; VAPT FAQs (<?= count($displayList) ?>)
            <?php else: ?>
                All Frequently Asked Questions (<?= count($displayList) ?>)
            <?php endif; ?>
        </h3>
        <a href="faqs.php?action=add&track=<?= urlencode($currentTrack !== 'all' ? $currentTrack : 'investigation') ?>" class="btn btn-primary btn-sm">
            + Add FAQ
        </a>
    </div>
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Order</th>
                    <th style="width: 140px;">Service Track</th>
                    <th>Question &amp; Topic</th>
                    <th>Answer Summary</th>
                    <th>Status</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($displayList)): ?>
                    <?php foreach ($displayList as $faq): ?>
                        <?php 
                            $fId    = $faq['id'] ?? '';
                            $fTrack = $faq['track'] ?? 'investigation';
                            $fQ     = $faq['question'] ?? ($faq['q'] ?? '');
                            $fA     = $faq['answer'] ?? ($faq['a'] ?? '');
                            $fCat   = $faq['category'] ?? 'General';
                            $fOrder = $faq['order'] ?? 1;
                            $fStat  = $faq['status'] ?? 'active';
                        ?>
                        <tr>
                            <td>
                                <span style="font-weight: 700; color: var(--text-muted); font-size: 0.85rem;">
                                    #<?= (int)$fOrder ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($fTrack === 'investigation'): ?>
                                    <span class="track-badge investigation">🔍 Investigation</span>
                                <?php elseif ($fTrack === 'cyber'): ?>
                                    <span class="track-badge cyber">🛡️ Cyber Security</span>
                                <?php else: ?>
                                    <span class="track-badge both">🌐 Both Services</span>
                                <?php endif; ?>
                            </td>
                            <td style="max-width: 320px;">
                                <div style="font-weight: 600; color: #ffffff; font-size: 0.92rem; margin-bottom: 0.25rem;">
                                    <?= htmlspecialchars($fQ) ?>
                                </div>
                                <span class="category-tag" style="font-size: 0.72rem;">
                                    <?= htmlspecialchars($fCat) ?>
                                </span>
                            </td>
                            <td style="max-width: 380px;">
                                <p style="font-size: 0.84rem; color: var(--text-secondary); line-height: 1.5; margin: 0; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    <?= htmlspecialchars($fA) ?>
                                </p>
                            </td>
                            <td>
                                <form method="POST" action="faqs.php?track=<?= urlencode($currentTrack) ?>&status=<?= urlencode($currentStatus) ?>" style="display:inline; margin:0;">
                                    <?= ck_csrf_field() ?>
                                    <input type="hidden" name="action" value="toggle_status">
                                    <input type="hidden" name="id" value="<?= htmlspecialchars($fId) ?>">
                                    <?php if ($fStat === 'active'): ?>
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
                                    <form method="POST" action="faqs.php?track=<?= urlencode($currentTrack) ?>&status=<?= urlencode($currentStatus) ?>" style="display:inline; margin:0;">
                                        <?= ck_csrf_field() ?>
                                        <input type="hidden" name="action" value="toggle_status">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($fId) ?>">
                                        <?php if ($fStat === 'active'): ?>
                                            <button type="submit" class="btn-action hide" title="Hide FAQ from website">Hide</button>
                                        <?php else: ?>
                                            <button type="submit" class="btn-action show" title="Make FAQ visible on website">Show</button>
                                        <?php endif; ?>
                                    </form>
                                    <a href="faqs.php?action=edit&id=<?= urlencode($fId) ?>&track=<?= urlencode($currentTrack) ?>" class="btn-action edit" title="Edit FAQ">Edit</a>
                                    <button type="button" class="btn-action delete" title="Delete FAQ" onclick="confirmDelete('faqs.php?track=<?= urlencode($currentTrack) ?>', '<?= htmlspecialchars(addslashes($fQ)) ?>', '<?= ck_csrf_token() ?>'); document.getElementById('deleteConfirmForm').innerHTML += '<input type=\'hidden\' name=\'id\' value=\'<?= htmlspecialchars($fId) ?>\'>';">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2.75rem; color: var(--text-muted);">
                            No FAQs found for this track filter. Click "+ Add FAQ" above to create one.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

