<?php
/**
 * Cyber Kovai - Page Section Visibility Controller
 * Hide or unhide any section across Cyber Security, Digital Investigation, About Us,
 * Service Detail, Contact, and Global Layout pages.
 */

require_once __DIR__ . '/includes/auth.php';
ck_admin_require_login();

$registry = ck_get_section_registry();

// Handle POST Actions (Instant AJAX single toggle, Show All, or Bulk Form Save)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isAjax = !empty($_POST['ajax']);

    if (!ck_csrf_verify()) {
        if ($isAjax) {
            header('Content-Type: application/json', true, 403);
            echo json_encode(['success' => false, 'error' => 'Security session expired. Refresh the page and try again.']);
            exit;
        }
        ck_set_flash('error', 'Security session token expired. Please try again.');
        header('Location: section-visibility.php');
        exit;
    }

    $postAction = $_POST['action'] ?? 'save_all';

    // 1. Instant single section toggle via AJAX or button
    if ($postAction === 'toggle_single') {
        $key     = trim((string)($_POST['key'] ?? ''));
        $visible = !empty($_POST['visible']) && $_POST['visible'] !== '0' && $_POST['visible'] !== 'false';
        $saved   = ck_set_single_section_visibility($key, $visible);

        if ($isAjax) {
            header('Content-Type: application/json');
            if ($saved) {
                echo json_encode([
                    'success' => true,
                    'key'     => $key,
                    'visible' => $visible,
                    'message' => $visible ? 'Section is now VISIBLE on website.' : 'Section is now HIDDEN from website.'
                ]);
            } else {
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Invalid section key or failed to save.']);
            }
            exit;
        }

        if ($saved) {
            ck_set_flash('success', 'Section visibility updated.');
        } else {
            ck_set_flash('error', 'Failed to update section visibility.');
        }
        header('Location: section-visibility.php');
        exit;
    }

    // 2. Show All Sections across entire site
    if ($postAction === 'show_all') {
        $allVisible = [];
        foreach ($registry as $group) {
            foreach ($group['sections'] as $key => $meta) {
                $allVisible[$key] = true;
            }
        }
        $saved = ck_save_section_visibility($allVisible);
        ck_set_flash($saved ? 'success' : 'error', $saved ? 'All website sections are now set to VISIBLE.' : 'Failed to update visibility settings.');
        header('Location: section-visibility.php');
        exit;
    }

    // 3. Group bulk Show / Hide
    if ($postAction === 'group_toggle') {
        $targetGroup = trim((string)($_POST['group'] ?? ''));
        $visible     = !empty($_POST['visible']) && $_POST['visible'] !== '0';
        $current     = ck_get_section_visibility(true);
        if (isset($registry[$targetGroup])) {
            foreach ($registry[$targetGroup]['sections'] as $key => $meta) {
                $current[$key] = $visible;
            }
            $saved = ck_save_section_visibility($current);
            $gName = $registry[$targetGroup]['group_title'];
            ck_set_flash($saved ? 'success' : 'error', $saved ? "All sections in '{$gName}' are now " . ($visible ? 'VISIBLE' : 'HIDDEN') . '.' : 'Failed to save group visibility.');
        }
        header('Location: section-visibility.php#group-' . urlencode($targetGroup));
        exit;
    }

    // 4. Bulk form save
    if ($postAction === 'save_all') {
        $submitted = $_POST['sections'] ?? [];
        $map = [];
        foreach ($registry as $group) {
            foreach ($group['sections'] as $key => $meta) {
                $map[$key] = !empty($submitted[$key]) && $submitted[$key] !== '0';
            }
        }
        $saved = ck_save_section_visibility($map);
        ck_set_flash($saved ? 'success' : 'error', $saved ? 'All section visibility settings have been saved and synced across the website!' : 'Failed to write section visibility settings.');
        header('Location: section-visibility.php');
        exit;
    }
}

$visibility = ck_get_section_visibility(true);

$totalSections  = 0;
$visibleTotal   = 0;
$hiddenTotal    = 0;
foreach ($registry as $group) {
    foreach ($group['sections'] as $key => $meta) {
        $totalSections++;
        if (!empty($visibility[$key])) {
            $visibleTotal++;
        } else {
            $hiddenTotal++;
        }
    }
}

$adminPageTitle = 'Section Visibility Controls';
require_once __DIR__ . '/includes/header.php';
?>

<style>
.sv-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem 1.25rem;
    background: var(--bg-surface-card);
    border: 1px solid var(--border-color);
    border-radius: var(--radius-md);
}
.sv-filter-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}
.sv-tab-btn {
    padding: 0.48rem 0.9rem;
    border-radius: 50px;
    border: 1px solid var(--border-color);
    background: rgba(255, 255, 255, 0.03);
    color: var(--text-secondary);
    font-size: 0.82rem;
    font-weight: 600;
    cursor: pointer;
    transition: var(--transition);
    font-family: inherit;
}
.sv-tab-btn:hover {
    border-color: var(--accent-purple);
    color: var(--text-primary);
}
.sv-tab-btn.active {
    background: linear-gradient(135deg, var(--accent-purple), var(--accent-purple-dark));
    border-color: var(--accent-purple-light);
    color: #fff;
    box-shadow: 0 4px 14px rgba(158, 62, 255, 0.3);
}
.sv-search-input {
    min-width: 240px;
    max-width: 320px;
    flex: 1;
}
.sv-group-card {
    margin-bottom: 1.75rem;
}
.sv-group-actions {
    display: flex;
    align-items: center;
    gap: 0.6rem;
    flex-wrap: wrap;
}
.sv-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 1rem;
}
.sv-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1rem;
    padding: 1rem 1.15rem;
    border-radius: 12px;
    background: rgba(255, 255, 255, 0.025);
    border: 1px solid rgba(158, 62, 255, 0.16);
    transition: border-color 0.25s ease, background 0.25s ease, opacity 0.25s ease;
}
.sv-item:hover {
    border-color: rgba(158, 62, 255, 0.45);
    background: rgba(158, 62, 255, 0.05);
}
.sv-item.is-hidden-state {
    border-color: rgba(255, 171, 0, 0.35);
    background: rgba(255, 171, 0, 0.04);
}
.sv-item-info {
    flex: 1;
    min-width: 0;
}
.sv-item-title-row {
    display: flex;
    align-items: center;
    gap: 0.55rem;
    flex-wrap: wrap;
    margin-bottom: 0.25rem;
}
.sv-item-title {
    font-size: 0.94rem;
    font-weight: 600;
    color: var(--text-primary);
}
.sv-item-desc {
    font-size: 0.78rem;
    color: var(--text-secondary);
    line-height: 1.45;
}
.sv-state-pill {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 0.14rem 0.5rem;
    border-radius: 50px;
}
.sv-state-pill.visible {
    background: rgba(0, 230, 118, 0.14);
    color: var(--accent-green);
    border: 1px solid rgba(0, 230, 118, 0.32);
}
.sv-state-pill.hidden {
    background: rgba(255, 171, 0, 0.14);
    color: var(--accent-amber);
    border: 1px solid rgba(255, 171, 0, 0.35);
}
.sv-switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 28px;
    flex-shrink: 0;
}
.sv-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.sv-slider {
    position: absolute;
    cursor: pointer;
    inset: 0;
    background: rgba(255, 171, 0, 0.25);
    border: 1px solid rgba(255, 171, 0, 0.5);
    border-radius: 30px;
    transition: 0.25s ease;
}
.sv-slider::before {
    content: "";
    position: absolute;
    height: 20px;
    width: 20px;
    left: 3px;
    top: 3px;
    background: #ffab00;
    border-radius: 50%;
    transition: 0.25s ease;
    box-shadow: 0 2px 6px rgba(0,0,0,0.4);
}
.sv-switch input:checked + .sv-slider {
    background: rgba(0, 230, 118, 0.22);
    border-color: rgba(0, 230, 118, 0.65);
}
.sv-switch input:checked + .sv-slider::before {
    transform: translateX(22px);
    background: #00e676;
}
.sv-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 9999;
    padding: 0.85rem 1.2rem;
    border-radius: 12px;
    background: #10102e;
    border: 1px solid var(--accent-purple-light);
    color: #fff;
    font-size: 0.86rem;
    font-weight: 600;
    box-shadow: 0 12px 35px rgba(0,0,0,0.65), 0 0 20px rgba(158,62,255,0.28);
    display: none;
    align-items: center;
    gap: 0.6rem;
}
.sv-toast.show {
    display: inline-flex;
}
@media (max-width: 640px) {
    .sv-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="page-header-row">
    <div>
        <h1 class="page-header-title">Website Section Visibility Controls</h1>
        <p class="page-header-desc">
            Instantly hide or unhide any section across Cyber Security, Digital Investigation, About Us, Service Detail, Contact, and Global pages. Changes apply live immediately.
        </p>
    </div>
    <div style="display: flex; gap: 0.75rem; align-items: center; flex-wrap: wrap;">
        <div style="display: flex; gap: 0.5rem; align-items: center; padding: 0.45rem 0.9rem; background: var(--bg-surface-card); border: 1px solid var(--border-color); border-radius: 10px; font-size: 0.82rem;">
            <span style="color: var(--accent-green); font-weight: 700;" id="svGlobalVisibleCount"><?= $visibleTotal ?></span> Visible
            <span style="opacity: 0.3;">|</span>
            <span style="color: var(--accent-amber); font-weight: 700;" id="svGlobalHiddenCount"><?= $hiddenTotal ?></span> Hidden
        </div>
        <form method="POST" action="section-visibility.php" style="margin: 0;">
            <?= ck_csrf_field() ?>
            <input type="hidden" name="action" value="show_all">
            <button type="submit" class="btn btn-secondary btn-sm" onclick="return confirm('Make all <?= $totalSections ?> sections visible across the entire website?');">
                <span>👁️</span> Show All Sections
            </button>
        </form>
    </div>
</div>

<!-- Filter Tabs & Search -->
<div class="sv-toolbar">
    <div class="sv-filter-tabs" id="svFilterTabs">
        <button type="button" class="sv-tab-btn active" data-group="all">All Pages (<?= $totalSections ?>)</button>
        <?php foreach ($registry as $gKey => $group): ?>
            <button type="button" class="sv-tab-btn" data-group="<?= htmlspecialchars($gKey) ?>">
                <?= $group['group_icon'] ?> <?= htmlspecialchars($group['group_title']) ?> (<?= count($group['sections']) ?>)
            </button>
        <?php endforeach; ?>
    </div>
    <input type="text" id="svSearchInput" class="form-control sv-search-input" placeholder="Filter sections by name or keyword...">
</div>

<form method="POST" action="section-visibility.php" id="svBulkForm">
    <?= ck_csrf_field() ?>
    <input type="hidden" name="action" value="save_all">

    <?php foreach ($registry as $gKey => $group):
        $gTotal = count($group['sections']);
        $gVisible = 0;
        foreach ($group['sections'] as $k => $m) {
            if (!empty($visibility[$k])) $gVisible++;
        }
    ?>
    <div class="admin-card sv-group-card" id="group-<?= htmlspecialchars($gKey) ?>" data-group-card="<?= htmlspecialchars($gKey) ?>">
        <div class="admin-card-header" style="flex-wrap: wrap; gap: 1rem;">
            <div>
                <h3 class="admin-card-title" style="display: flex; align-items: center; gap: 0.55rem;">
                    <span><?= $group['group_icon'] ?></span>
                    <span><?= htmlspecialchars($group['group_title']) ?></span>
                    <code style="font-size: 0.72rem; color: var(--accent-cyan); font-weight: 500; margin-left: 0.35rem;"><?= htmlspecialchars($group['group_file']) ?></code>
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.25rem;"><?= htmlspecialchars($group['group_desc']) ?></p>
            </div>
            <div class="sv-group-actions">
                <span class="status-pill active" data-group-counter="<?= htmlspecialchars($gKey) ?>"><?= $gVisible ?> / <?= $gTotal ?> Visible</span>
                <button type="button" class="btn btn-secondary btn-sm sv-bulk-group-btn" data-group="<?= htmlspecialchars($gKey) ?>" data-visible="1">Show All</button>
                <button type="button" class="btn btn-secondary btn-sm sv-bulk-group-btn" data-group="<?= htmlspecialchars($gKey) ?>" data-visible="0">Hide All</button>
            </div>
        </div>
        <div class="admin-card-body">
            <div class="sv-grid">
                <?php foreach ($group['sections'] as $key => $meta):
                    $isVis = !empty($visibility[$key]);
                ?>
                <div class="sv-item <?= $isVis ? '' : 'is-hidden-state' ?>"
                     data-section-key="<?= htmlspecialchars($key) ?>"
                     data-search-text="<?= htmlspecialchars(strtolower($meta['label'] . ' ' . $meta['desc'] . ' ' . $key)) ?>">
                    <div class="sv-item-info">
                        <div class="sv-item-title-row">
                            <span class="sv-item-title"><?= htmlspecialchars($meta['label']) ?></span>
                            <span class="sv-state-pill <?= $isVis ? 'visible' : 'hidden' ?>" data-pill-for="<?= htmlspecialchars($key) ?>">
                                <?= $isVis ? 'Visible' : 'Hidden' ?>
                            </span>
                        </div>
                        <div class="sv-item-desc"><?= htmlspecialchars($meta['desc']) ?></div>
                    </div>
                    <label class="sv-switch" title="Toggle visibility for <?= htmlspecialchars($meta['label']) ?>">
                        <input type="hidden" name="sections[<?= htmlspecialchars($key) ?>]" value="0">
                        <input type="checkbox"
                               class="sv-toggle-checkbox"
                               name="sections[<?= htmlspecialchars($key) ?>]"
                               value="1"
                               data-key="<?= htmlspecialchars($key) ?>"
                               data-group="<?= htmlspecialchars($gKey) ?>"
                               <?= $isVis ? 'checked' : '' ?>>
                        <span class="sv-slider"></span>
                    </label>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endforeach; ?>

    <div style="display: flex; justify-content: flex-end; gap: 1rem; padding-top: 0.5rem; margin-bottom: 2rem;">
        <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        <button type="submit" class="btn btn-primary">
            <span>💾</span> Save All Section Visibility Settings
        </button>
    </div>
</form>

<!-- Hidden helper form for Group Show/Hide submission -->
<form method="POST" action="section-visibility.php" id="svGroupHelperForm" style="display: none;">
    <?= ck_csrf_field() ?>
    <input type="hidden" name="action" value="group_toggle">
    <input type="hidden" name="group" id="svHelperGroup" value="">
    <input type="hidden" name="visible" id="svHelperVisible" value="1">
</form>

<div class="sv-toast" id="svToast" role="status" aria-live="polite">
    <span id="svToastIcon">✅</span>
    <span id="svToastMsg">Section visibility saved.</span>
</div>

<script>
(function() {
    var csrfToken = <?= json_encode(ck_csrf_token()) ?>;
    var toastEl = document.getElementById('svToast');
    var toastMsg = document.getElementById('svToastMsg');
    var toastIcon = document.getElementById('svToastIcon');
    var toastTimer = null;

    function showToast(msg, ok) {
        if (!toastEl) return;
        toastIcon.textContent = ok ? '✅' : '⚠️';
        toastMsg.textContent = msg;
        toastEl.style.borderColor = ok ? 'rgba(0, 230, 118, 0.65)' : 'rgba(255, 51, 102, 0.75)';
        toastEl.classList.add('show');
        clearTimeout(toastTimer);
        toastTimer = setTimeout(function() {
            toastEl.classList.remove('show');
        }, 2600);
    }

    function updateCounters() {
        var allCheckboxes = document.querySelectorAll('.sv-toggle-checkbox');
        var totalVis = 0;
        var totalHid = 0;
        var byGroup = {};

        allCheckboxes.forEach(function(cb) {
            var g = cb.dataset.group;
            if (!byGroup[g]) byGroup[g] = { vis: 0, total: 0 };
            byGroup[g].total++;
            if (cb.checked) {
                totalVis++;
                byGroup[g].vis++;
            } else {
                totalHid++;
            }
        });

        var gVisEl = document.getElementById('svGlobalVisibleCount');
        var gHidEl = document.getElementById('svGlobalHiddenCount');
        if (gVisEl) gVisEl.textContent = totalVis;
        if (gHidEl) gHidEl.textContent = totalHid;

        Object.keys(byGroup).forEach(function(g) {
            var badge = document.querySelector('[data-group-counter="' + g + '"]');
            if (badge) {
                badge.textContent = byGroup[g].vis + ' / ' + byGroup[g].total + ' Visible';
            }
        });
    }

    function updateItemUI(cb) {
        var key = cb.dataset.key;
        var item = cb.closest('.sv-item');
        var pill = document.querySelector('[data-pill-for="' + key + '"]');
        if (item) {
            item.classList.toggle('is-hidden-state', !cb.checked);
        }
        if (pill) {
            pill.classList.toggle('visible', cb.checked);
            pill.classList.toggle('hidden', !cb.checked);
            pill.textContent = cb.checked ? 'Visible' : 'Hidden';
        }
        updateCounters();
    }

    // Instant AJAX toggle on switch click
    document.querySelectorAll('.sv-toggle-checkbox').forEach(function(cb) {
        cb.addEventListener('change', function() {
            var key = cb.dataset.key;
            var visible = cb.checked ? '1' : '0';
            updateItemUI(cb);

            var fd = new FormData();
            fd.append('csrf_token', csrfToken);
            fd.append('action', 'toggle_single');
            fd.append('ajax', '1');
            fd.append('key', key);
            fd.append('visible', visible);

            fetch('section-visibility.php', {
                method: 'POST',
                body: fd
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    showToast(data.message || 'Saved!', true);
                } else {
                    cb.checked = !cb.checked;
                    updateItemUI(cb);
                    showToast((data && data.error) || 'Failed to save toggle.', false);
                }
            })
            .catch(function() {
                cb.checked = !cb.checked;
                updateItemUI(cb);
                showToast('Network error saving visibility.', false);
            });
        });
    });

    // Group Show All / Hide All buttons
    document.querySelectorAll('.sv-bulk-group-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var g = btn.dataset.group;
            var vis = btn.dataset.visible;
            if (vis === '0' && !confirm('Hide all sections in this page group?')) {
                return;
            }
            document.getElementById('svHelperGroup').value = g;
            document.getElementById('svHelperVisible').value = vis;
            document.getElementById('svGroupHelperForm').submit();
        });
    });

    // Filter tabs & search
    var activeGroup = 'all';
    var searchInput = document.getElementById('svSearchInput');

    function applyFilters() {
        var q = (searchInput ? searchInput.value : '').trim().toLowerCase();
        document.querySelectorAll('[data-group-card]').forEach(function(card) {
            var cg = card.dataset.groupCard;
            var groupMatches = (activeGroup === 'all' || cg === activeGroup);
            var anyVisibleItem = false;

            card.querySelectorAll('.sv-item').forEach(function(item) {
                var hay = item.dataset.searchText || '';
                var showItem = groupMatches && (!q || hay.indexOf(q) !== -1);
                item.style.display = showItem ? '' : 'none';
                if (showItem) anyVisibleItem = true;
            });

            card.style.display = (groupMatches && anyVisibleItem) ? '' : 'none';
        });
    }

    document.querySelectorAll('#svFilterTabs .sv-tab-btn').forEach(function(tab) {
        tab.addEventListener('click', function() {
            document.querySelectorAll('#svFilterTabs .sv-tab-btn').forEach(function(t) { t.classList.remove('active'); });
            tab.classList.add('active');
            activeGroup = tab.dataset.group;
            applyFilters();
        });
    });

    if (searchInput) {
        searchInput.addEventListener('input', applyFilters);
    }
})();
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

