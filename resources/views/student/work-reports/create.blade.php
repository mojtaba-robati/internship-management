@include('student.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">📝 ثبت گزارش کار جدید</h2>
                        <p class="text-muted">
                            محل کارآموزی: {{ $internshipRequest->company_name }} | ردیف: {{ $row }}
                        </p>
                    </div>
                    <a href="{{ route('student.work-reports.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('student.work-reports.store') }}" method="POST" id="reportForm">
                    @csrf
                    <input type="hidden" name="row" value="{{ $row }}">
                    
                    <div class="mb-3">
                        <label class="form-label">تاریخ گزارش <span class="text-danger">*</span></label>
                        <input type="text" name="report_date_shamsi" id="reportDateShamsi" class="form-control datepicker" placeholder="مثال: 1403/01/15" required autocomplete="off">
                        <small class="text-muted">تاریخ را به صورت شمسی وارد کنید (مثال: 1403/01/15)</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">متن گزارش کار <span class="text-danger">*</span></label>
                        <textarea name="report_text" class="form-control" rows="10" required placeholder="شرح کامل فعالیت‌هایی که در این روز انجام داده‌اید..."></textarea>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save"></i> ثبت گزارش
                        </button>
                        <a href="{{ route('student.work-reports.index') }}" class="btn btn-secondary px-4">
                            <i class="bi bi-x-circle"></i> انصراف
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
    @media (min-width: 992px) {
        .student-content-wrapper {
            margin-right: 240px;
            min-height: 100vh;
        }
    }
    @media (max-width: 991px) {
        .student-content-wrapper {
            margin-right: 0;
        }
    }
    textarea {
        resize: vertical;
    }
    .datepicker {
        direction: ltr;
        text-align: left;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/persian-date@1.1.0/dist/persian-date.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css" rel="stylesheet">

<script>
    // راه‌اندازی تقویم شمسی
    document.addEventListener('DOMContentLoaded', function() {
        $('#reportDateShamsi').pDatepicker({
            format: 'YYYY/MM/DD',
            autoClose: true,
            initialValue: false,
            calendar: {
                persian: {
                    locale: 'fa'
                }
            }
        });
    });

    // تبدیل تاریخ شمسی به میلادی قبل از ارسال فرم
    document.getElementById('reportForm').addEventListener('submit', function(e) {
        const shamsiInput = document.getElementById('reportDateShamsi');
        if (shamsiInput && shamsiInput.value) {
            let parts = shamsiInput.value.split('/');
            if (parts.length === 3) {
                let jy = parseInt(parts[0]);
                let jm = parseInt(parts[1]);
                let jd = parseInt(parts[2]);
                
                let gy = jy + 621;
                let gm = jm + 3;
                let gd = jd;
                
                if (gm > 12) {
                    gm = gm - 12;
                    gy++;
                }
                
                let gregorianDate = gy + '-' + String(gm).padStart(2, '0') + '-' + String(gd).padStart(2, '0');
                
                let hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'report_date';
                hiddenInput.value = gregorianDate;
                this.appendChild(hiddenInput);
            }
        }
    });
</script>