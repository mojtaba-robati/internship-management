@include('mentor.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">⭐ ثبت نمره نهایی</h2>
                        <p class="text-muted">
                            دانش‌آموز: {{ $student->first_name }} {{ $student->last_name }} |
                            محل کارآموزی: {{ $internshipRequest->company_name ?? '-' }}
                        </p>
                    </div>
                    <a href="{{ route('mentor.grading.index') }}" class="btn btn-secondary">
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
                <form action="{{ route('mentor.grading.store', $student->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label">نمره نهایی کارآموزی <span class="text-danger">*</span></label>
                        <input type="number" name="grade" class="form-control" step="0.5" min="0" max="15" 
                               value="{{ $finalGrade->grade ?? '' }}" required placeholder="0 تا 15">
                        <small class="text-muted">حداکثر 15</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">یادداشت مربی (اختیاری)</label>
                        <textarea name="mentor_note" class="form-control" rows="4" placeholder="یادداشت خود را وارد کنید...">{{ $finalGrade->mentor_note ?? '' }}</textarea>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save"></i> ثبت نمره نهایی
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ========== بخش کارنامه (بعد از ثبت نمره) ========== --}}
        @if($finalGrade && $finalGrade->grade !== null)
        <div class="card shadow-sm border-0 rounded-4 mt-4" id="certificate-section">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i> کارنامه نهایی
                    </h5>
                    <button onclick="printCertificate()" class="btn btn-primary">
                        <i class="bi bi-printer-fill"></i> چاپ کارنامه
                    </button>
                </div>
            </div>
            <div class="card-body p-4" id="certificate-content">
                <div class="certificate-box p-4" style="border: 2px solid #1a1a2e; border-radius: 12px; background: white;">
                    
                    {{-- هدر کارنامه --}}
                    <div class="text-center border-bottom pb-3 mb-3">
                        <h3 class="fw-bold text-primary">کارنامه کارآموزی</h3>
                        <p class="text-muted">سیستم مدیریت کارآموزی هنرستان</p>
                    </div>

                    {{-- اطلاعات دانش‌آموز --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 40%;">نام و نام خانوادگی:</th>
                                    <td>{{ $student->first_name }} {{ $student->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>کد ملی:</th>
                                    <td dir="ltr">{{ $student->national_code }}</td>
                                </tr>
                                <tr>
                                    <th>شماره موبایل:</th>
                                    <td dir="ltr">{{ $student->phone }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 40%;">رشته تحصیلی:</th>
                                    <td>{{ $student->major }}</td>
                                </tr>
                                <tr>
                                    <th>پایه:</th>
                                    <td>{{ $student->grade }}</td>
                                </tr>
                                <tr>
                                    <th>محل کارآموزی:</th>
                                    <td>{{ $internshipRequest->company_name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- نمره نهایی --}}
                    <div class="text-center py-3 mb-3" style="background: #f8f9fa; border-radius: 8px;">
                        <h5 class="text-muted mb-2">نمره نهایی کارآموزی</h5>
                        <span class="display-3 fw-bold text-success">{{ number_format($finalGrade->grade, 1) }}</span>
                        <span class="fs-4 text-muted">از ۱۵</span>
                    </div>

                    {{-- یادداشت مربی --}}
                    @if($finalGrade->mentor_note)
                    <div class="mb-3">
                        <h6 class="fw-bold">یادداشت مربی:</h6>
                        <p class="text-muted">{{ $finalGrade->mentor_note }}</p>
                    </div>
                    @endif

                    {{-- گزارش‌های کار --}}
                    @if($reports && $reports->count() > 0)
                    <div class="mb-3">
                        <h6 class="fw-bold">خلاصه گزارش‌های کار</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>ردیف</th>
                                        <th>تاریخ</th>
                                        <th>گزارش</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $report->row_number }}</td
                                        <td dir="ltr">{{ Jalalian::fromDateTime($report->report_date)->format('Y/m/d') }}</td
                                        <td>{{ Str::limit($report->report_text, 50) }}</td
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    {{-- امضاها --}}
                    <div class="row mt-4 pt-3 border-top">
                        <div class="col-6 text-center">
                            <p class="text-muted mb-1">امضای مربی ناظر</p>
                            <div style="height: 40px; border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                            <small class="text-muted">........................</small>
                        </div>
                        <div class="col-6 text-center">
                            <p class="text-muted mb-1">تاریخ</p>
                            <div style="height: 40px; border-bottom: 1px solid #000; width: 80%; margin: 0 auto;"></div>
                            <small class="text-muted">{{ Jalalian::fromDateTime(now())->format('Y/m/d') }}</small>
                        </div>
                    </div>

                    {{-- فوتر --}}
                    <div class="text-center mt-3 pt-2 border-top">
                        <small class="text-muted">این کارنامه به صورت خودکار توسط سیستم مدیریت کارآموزی صادر شده است.</small>
                    </div>

                </div>
            </div>
        </div>
        @endif

    </div>
</div>

<style>
    @media (min-width: 992px) {
        .mentor-content-wrapper { margin-right: 260px; min-height: 100vh; }
    }
    @media (max-width: 991px) { .mentor-content-wrapper { margin-right: 0; } }
    
    .card {
        border-radius: 15px;
    }
    
    @media print {
        body * {
            visibility: hidden;
        }
        #certificate-section, #certificate-section * {
            visibility: visible;
        }
        #certificate-section {
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            padding: 20px;
            background: white;
        }
        .btn, .no-print {
            display: none !important;
        }
        .certificate-box {
            border: 2px solid #1a1a2e !important;
            box-shadow: none !important;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #000 !important;
        }
    }
</style>

<script>
    function printCertificate() {
        window.print();
    }
</script>