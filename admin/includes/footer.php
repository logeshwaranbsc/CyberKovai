        </main>
    </div>

    <!-- ================= GENERIC DELETE CONFIRMATION MODAL ================= -->
    <div class="admin-modal-backdrop" id="deleteConfirmModal">
        <div class="admin-modal" style="max-width: 460px;">
            <div class="modal-header">
                <h3 class="modal-title" style="color: var(--accent-red);">Confirm Deletion</h3>
                <button type="button" class="modal-close-btn" onclick="closeModal('deleteConfirmModal')">&times;</button>
            </div>
            <form id="deleteConfirmForm" method="POST" action="">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="csrf_token" id="deleteCsrfToken" value="">
                <div class="modal-body">
                    <p style="margin-bottom: 0.75rem; color: var(--text-primary);">
                        Are you sure you want to permanently delete:
                    </p>
                    <p style="padding: 0.75rem; background: rgba(255, 51, 102, 0.1); border: 1px solid rgba(255, 51, 102, 0.3); border-radius: 8px; font-weight: 700; color: #ff99b3;" id="deleteItemName">
                        Item
                    </p>
                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.75rem;">
                        This action will update file storage immediately and cannot be undone.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="closeModal('deleteConfirmModal')">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, Delete Permanently</button>
                </div>
            </form>
        </div>
    </div>

    <script src="assets/admin.js?v=<?= filemtime(__DIR__ . '/../assets/admin.js') ?>"></script>
</body>
</html>

