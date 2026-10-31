/**
 * Cyber Kovai - Admin Console JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
    // Mobile sidebar toggle
    const toggleBtn = document.getElementById('mobileSidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('open');
        });
    }

    // Auto dismiss flash alerts after 5 seconds
    const flashAlerts = document.querySelectorAll('.flash-alert');
    flashAlerts.forEach(function (alert) {
        const closeBtn = alert.querySelector('.flash-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                alert.style.display = 'none';
            });
        }
        setTimeout(function () {
            alert.style.transition = 'opacity 0.5s ease';
            alert.style.opacity = '0';
            setTimeout(function () { alert.style.display = 'none'; }, 500);
        }, 5000);
    });

    // Image preview on file input change
    const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
    fileInputs.forEach(function (input) {
        input.addEventListener('change', function () {
            const previewTarget = document.querySelector(input.dataset.preview);
            if (previewTarget && input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewTarget.src = e.target.result;
                    previewTarget.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    });

    // Modal open / close handlers
    window.openModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
    };

    window.closeModal = function (modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        }
    };

    // Close on backdrop click
    document.querySelectorAll('.admin-modal-backdrop').forEach(function (backdrop) {
        backdrop.addEventListener('click', function (e) {
            if (e.target === backdrop) {
                backdrop.classList.remove('show');
                document.body.style.overflow = '';
            }
        });
    });

    // Auto-generate slug from title input if slug field is empty
    const titleInput = document.querySelector('[data-slug-source]');
    const slugInput = document.querySelector('[data-slug-target]');
    if (titleInput && slugInput) {
        titleInput.addEventListener('input', function () {
            if (!slugInput.dataset.manual) {
                slugInput.value = titleInput.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
        });
        slugInput.addEventListener('input', function () {
            slugInput.dataset.manual = 'true';
        });
    }

    // Generic Delete Confirmation Modal
    window.confirmDelete = function (actionUrl, itemName, csrfToken) {
        const modal = document.getElementById('deleteConfirmModal');
        const form = document.getElementById('deleteConfirmForm');
        const nameSpan = document.getElementById('deleteItemName');
        const csrfInput = document.getElementById('deleteCsrfToken');

        if (modal && form) {
            form.action = actionUrl;
            if (nameSpan) nameSpan.textContent = itemName;
            if (csrfInput) csrfInput.value = csrfToken;
            openModal('deleteConfirmModal');
        } else {
            if (confirm('Are you sure you want to delete "' + itemName + '"? This action cannot be undone.')) {
                window.location.href = actionUrl;
            }
        }
    };
});

