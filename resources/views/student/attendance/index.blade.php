@include('student.components.sidebar')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col text-end">
                <h2 class="fw-bold text-primary">📋 دفترچه حضور غیاب کارآموزی</h2>
                <p class="text-muted">
                    <i class="bi bi-building"></i> شرکت: <strong>{{ $internshipRequest->company_name }}</strong>
                </p>
            </div>
        </div>

        {{-- نمایش پیام‌ها --}}
        <div id="alert-container">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show text-end" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 60px;">#</th>
                                <th style="width: 150px;">تاریخ</th>
                                <th style="width: 140px;">ساعت ورود</th>
                                <th style="width: 140px;">ساعت خروج</th>
                                <th style="width: 120px;">وضعیت</th>
                                <th style="width: 100px;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($days as $row => $day)
                            <tr id="row-{{ $row }}">
                                <td class="fw-bold bg-light">{{ $row }}</td>
                                <td>
                                    @if($day['status'] == 'pending')
                                        <input type="date" class="form-control form-control-sm date-field mb-1" 
                                               value="{{ $day['date'] ?? '' }}">
                                        <small class="text-muted d-block">شمسی: {{ $day['date_fa'] ?? '-' }}</small>
                                    @else
                                        <span class="fw-bold text-dark">{{ $day['date_fa'] ?? $day['date'] ?? '-' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($day['status'] == 'pending')
                                        <input type="time" class="form-control form-control-sm time-in mx-auto" 
                                               value="{{ $day['check_in'] ?? '' }}" style="width: 100px;">
                                    @else
                                        <span class="badge bg-light text-dark border">{{ $day['check_in'] ?? '---' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($day['status'] == 'pending')
                                        <input type="time" class="form-control form-control-sm time-out mx-auto" 
                                               value="{{ $day['check_out'] ?? '' }}" style="width: 100px;">
                                    @else
                                        <span class="badge bg-light text-dark border">{{ $day['check_out'] ?? '---' }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($day['status'] == 'pending')
                                        <span class="badge rounded-pill bg-warning text-dark px-2">منتظر ثبت</span>
                                    @elseif($day['status'] == 'approved')
                                        <span class="badge rounded-pill bg-success px-2">تایید شده</span>
                                    @else
                                        <span class="badge rounded-pill bg-danger px-2">رد شده</span>
                                    @endif
                                </td>
                                <td>
                                    @if($day['status'] == 'pending')
                                        <button class="btn btn-sm btn-primary save-row px-3" data-row="{{ $row }}">
                                            <i class="bi bi-cloud-arrow-up"></i> ثبت
                                        </button>
                                    @else
                                        <i class="bi bi-lock-fill text-muted" title="قفل شده"></i>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .student-content-wrapper { transition: all 0.3s; }
    @media (min-width: 992px) { .student-content-wrapper { margin-right: 240px; min-height: 100vh; } }
    @media (max-width: 991px) { .student-content-wrapper { margin-right: 0; } }
    
    .table th { font-size: 0.85rem; padding: 12px; }
    .table td { font-size: 0.9rem; }
    .form-control-sm { font-size: 0.75rem; text-align: center; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const attendanceId = '{{ $attendance->id ?? '' }}';
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    document.querySelectorAll('.save-row').forEach(button => {
        button.addEventListener('click', function() {
            const row = this.getAttribute('data-row');
            const rowElement = document.getElementById('row-' + row);
            
            const data = {
                row: row,
                date: rowElement.querySelector('.date-field')?.value,
                check_in: rowElement.querySelector('.time-in')?.value,
                check_out: rowElement.querySelector('.time-out')?.value
            };

            // غیرفعال کردن دکمه هنگام ارسال
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            fetch(`/student/attendance/${attendanceId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    location.reload(); // برای اعمال تغییرات و نمایش وضعیت جدید
                } else {
                    alert(res.message || 'خطا در ذخیره اطلاعات');
                    this.disabled = false;
                    this.innerHTML = '<i class="bi bi-save"></i> ذخیره';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('خطا در ارتباط با سرور!');
                this.disabled = false;
                this.innerHTML = '<i class="bi bi-save"></i> ذخیره';
            });
        });
    });
});
</script>