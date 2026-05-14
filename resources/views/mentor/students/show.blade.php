@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">👤 اطلاعات کامل دانش‌آموز</h2>
                        <p class="text-muted">مشاهده اطلاعات شخصی و محل کارآموزی</p>
                    </div>
                    <a href="{{ route('mentor.students.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
        
        {{-- بخش 1: اطلاعات شخصی --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-person-circle text-primary"></i> اطلاعات شخصی
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">نام کامل</label>
                        <p class="fw-bold mb-0">{{ $student->first_name }} {{ $student->last_name }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">کد ملی</label>
                        <p class="fw-bold mb-0" dir="ltr">{{ $student->national_code }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">شماره موبایل</label>
                        <p class="fw-bold mb-0" dir="ltr">{{ $student->phone }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">رشته تحصیلی</label>
                        <p class="fw-bold mb-0">{{ $student->major }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">پایه تحصیلی</label>
                        <p class="fw-bold mb-0">{{ $student->grade }}</p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="text-muted small">وضعیت</label>
                        <p>
                            @if($student->is_active == 1)
                                <span class="badge bg-success">فعال</span>
                            @else
                                <span class="badge bg-danger">غیرفعال</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- بخش 2: اطلاعات محل کارآموزی --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-building-fill text-success"></i> اطلاعات محل کارآموزی
                </h5>
            </div>
            <div class="card-body p-4">
                @if($internship)
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">نام محل کارآموزی</label>
                            <p class="fw-bold mb-0">{{ $internship->company_name ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">تلفن محل کارآموزی</label>
                            <p class="fw-bold mb-0" dir="ltr">{{ $internship->company_phone ?? '-' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small">آدرس</label>
                            <p class="mb-0">{{ $internship->company_address ?? '-' }}</p>
                        </div>
                        @if($internship->supervisor_name)
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">نام سرپرست</label>
                            <p class="fw-bold mb-0">{{ $internship->supervisor_name }}</p>
                        </div>
                        @endif
                        @if($internship->supervisor_phone)
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">تلفن سرپرست</label>
                            <p class="fw-bold mb-0" dir="ltr">{{ $internship->supervisor_phone }}</p>
                        </div>
                        @endif
                        @if($internship->description)
                        <div class="col-12 mb-3">
                            <label class="text-muted small">توضیحات</label>
                            <p class="mb-0">{{ $internship->description }}</p>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="alert alert-warning mb-0">هنوز اطلاعات کارآموزی ثبت نشده است.</div>
                @endif
            </div>
        </div>
        
    </div>
</div>

<style>
    @media (min-width: 992px) {
        .mentor-content-wrapper { margin-right: 260px; min-height: 100vh; }
    }
    @media (max-width: 991px) { .mentor-content-wrapper { margin-right: 0; } }
    .card { border-radius: 15px; }
</style>