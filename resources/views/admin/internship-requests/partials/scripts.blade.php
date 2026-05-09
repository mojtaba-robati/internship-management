<script>
    document.addEventListener('DOMContentLoaded', function() {
        // مودال تایید سریع
        const quickApproveModal = document.getElementById('quickApproveModal');
        if (quickApproveModal) {
            quickApproveModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const approveForm = document.getElementById('quickApproveForm');
                
                document.getElementById('approveStudentName').textContent = name;
                approveForm.action = '/admin/internship-requests/' + id + '/approve';
                approveForm.method = 'POST';
            });
        }

        // مودال رد سریع
        const quickRejectModal = document.getElementById('quickRejectModal');
        if (quickRejectModal) {
            quickRejectModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const name = button.getAttribute('data-name');
                const rejectForm = document.getElementById('quickRejectForm');
                
                document.getElementById('rejectStudentName').textContent = name;
                rejectForm.action = '/admin/internship-requests/' + id + '/reject';
                rejectForm.method = 'POST';
            });
        }

        // ========== حذف گروهی ==========
        const selectAllCheckbox = document.getElementById('selectAll');
        const checkItems = document.querySelectorAll('.check-item');
        const bulkActions = document.getElementById('bulkActions');
        const selectedCountSpan = document.getElementById('selectedCount');
        const bulkDeleteCount = document.getElementById('bulkDeleteCount');
        const bulkDeleteForm = document.getElementById('bulkDeleteForm');

        function updateBulkActions() {
            const checkedItems = document.querySelectorAll('.check-item:checked');
            const count = checkedItems.length;
            
            if (count > 0) {
                bulkActions.classList.remove('d-none');
                selectedCountSpan.textContent = count;
            } else {
                bulkActions.classList.add('d-none');
            }
        }

        // انتخاب همه
        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                checkItems.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateBulkActions();
            });
        }

        // هر چک‌باکس جدا
        checkItems.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                updateBulkActions();
                
                // بررسی اینکه همه چک شده‌اند یا نه
                const allChecked = [...checkItems].every(cb => cb.checked);
                if (selectAllCheckbox) {
                    selectAllCheckbox.checked = allChecked;
                }
            });
        });

        // مودال حذف گروهی
        const bulkDeleteModal = document.getElementById('bulkDeleteModal');
        if (bulkDeleteModal) {
            bulkDeleteModal.addEventListener('show.bs.modal', function() {
                const checkedItems = document.querySelectorAll('.check-item:checked');
                const ids = [...checkedItems].map(cb => cb.value);
                const count = ids.length;
                
                bulkDeleteCount.textContent = count;
                
                // ساخت فرم action با ids
                bulkDeleteForm.action = '/admin/internship-requests/bulk-delete';
                
                // اضافه کردن ids به فرم
                let input = document.getElementById('bulkIds');
                if (!input) {
                    input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids';
                    input.id = 'bulkIds';
                    bulkDeleteForm.appendChild(input);
                }
                input.value = JSON.stringify(ids);
            });
        }
    });
</script>