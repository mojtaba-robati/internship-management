@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">📋 درخواست‌های کارآموزی</h2>
                <p class="text-muted">مدیریت، بررسی و فیلتر درخواست‌های دانش‌آموزان</p>
            </div>
        </div>

        {{-- کارت‌های آماری --}}
        @include('admin.internship-requests.partials.stats-cards')

        {{-- فرم فیلتر --}}
        @include('admin.internship-requests.partials.filter-form')

        {{-- دکمه حذف گروهی (در ابتدا مخفی) --}}
        <div class="card shadow-sm border-0 mb-4 d-none" id="bulkActions">
            <div class="card-body py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-check-circle-fill text-primary"></i>
                        <span id="selectedCount">0</span> درخواست انتخاب شده
                    </div>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#bulkDeleteModal">
                        <i class="bi bi-trash3-fill"></i> حذف موارد انتخاب شده
                    </button>
                </div>
            </div>
        </div>

        {{-- پیام‌ها --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- جدول --}}
        @include('admin.internship-requests.partials.table')

    </div>
</div>

{{-- مودال‌ها --}}
@include('admin.internship-requests.partials.modals')

<style>
    @media (min-width: 992px) {
        .content-wrapper {
            margin-right: 240px;
            padding: 25px;
        }
    }
    @media (max-width: 991px) {
        .content-wrapper {
            margin-right: 0;
            padding: 15px;
        }
    }
    .card { transition: transform 0.2s; }
    .card:hover { transform: translateY(-3px); }
    .table th, .table td { vertical-align: middle; }
</style>

{{-- اسکریپت کامل با حذف گروهی --}}
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
                bulkDeleteForm.action = '/admin/internship-requests/bulk-delete';
                
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