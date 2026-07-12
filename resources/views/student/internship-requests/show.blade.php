@include('student.components.sidebar')

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">مشاهده درخواست کارآموزی</h2>
                <p class="text-muted">جزئیات درخواست شما</p>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold">اطلاعات محل کارآموزی</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">نام محل کارآموزی:</label>
                        <p class="fw-bold">{{ $internshipRequest->company_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">تلفن محل کارآموزی:</label>
                        <p class="fw-bold" dir="ltr">{{ $internshipRequest->company_phone ?: '-' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-muted">آدرس محل کارآموزی:</label>
                        <p class="fw-bold">{{ $internshipRequest->company_address }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">نام سرپرست:</label>
                        <p class="fw-bold">{{ $internshipRequest->supervisor_name ?: '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">تلفن سرپرست:</label>
                        <p class="fw-bold" dir="ltr">{{ $internshipRequest->supervisor_phone ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold">جزئیات کارآموزی</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label class="text-muted">توضیحات:</label>
                        <p class="fw-bold">{{ $internshipRequest->description ?: '-' }}</p>
                    </div>
                    @if($internshipRequest->skills)
                    <div class="col-12 mb-3">
                        <label class="text-muted">مهارت‌های مرتبط:</label>
                        <p class="fw-bold">{{ $internshipRequest->skills }}</p>
                    </div>
                    @endif
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">تاریخ شروع:</label>
                        <p class="fw-bold">{{ $internshipRequest->start_date ?: '-' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">تاریخ پایان:</label>
                        <p class="fw-bold">{{ $internshipRequest->end_date ?: '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold">وضعیت درخواست</h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">وضعیت:</label>
                        <p>
                            @if($internshipRequest->status == 'pending')
                                <span class="badge bg-warning text-dark">🕐 در انتظار بررسی</span>
                            @elseif($internshipRequest->status == 'approved')
                                <span class="badge bg-success">✅ تایید شده</span>
                            @else
                                <span class="badge bg-danger">❌ رد شده</span>
                            @endif
                        </p>
                    </div>
                    @if($internshipRequest->admin_notes)
                    <div class="col-12 mb-3">
                        <label class="text-muted">توضیحات معاون/ادمین:</label>
                        <p class="fw-bold text-primary">{{ $internshipRequest->admin_notes }}</p>
                    </div>
                    @endif
                    @if($internshipRequest->reviewed_at)
                    <div class="col-md-6 mb-3">
                        <label class="text-muted">تاریخ بررسی:</label>
                        <p class="fw-bold">{{ $internshipRequest->reviewed_at }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="mt-4 text-end">
            @if($internshipRequest->status == 'rejected')
                <a href="{{ route('student.internship-requests.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> ثبت درخواست جدید
                </a>
            @endif
            <a href="{{ route('student.internship-requests.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-right"></i> بازگشت
            </a>
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
    .card {
        border-radius: 15px;
    }
    .badge {
        font-size: 14px;
        padding: 6px 12px;
    }
</style>