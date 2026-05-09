@include('student.components.sidebar')

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        {{-- هدر خوش‌آمدگویی با گرافیک --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">خوش آمدید {{ session('student_name') }} 👋</h2>
                            <p class="mb-0 opacity-75">به پنل دانش آموزی خوش آمدید. وضعیت کارآموزی و اطلاعات خود را مشاهده کنید.</p>
                        </div>
                        <div class="text-center d-none d-md-block">
                            <i class="bi bi-mortarboard-fill fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- کارت‌های آماری با آمار واقعی --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">وضعیت</span>
                                <h3 class="fw-bold mb-0 text-success">فعال</h3>
                                <small class="text-muted">حساب کاربری</small>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle-fill text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success bg-opacity-10 text-success mb-2">پایه</span>
                                <h3 class="fw-bold mb-0">{{ $student->grade }}</h3>
                                <small class="text-muted">پایه تحصیلی</small>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-book-fill text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-warning bg-opacity-10 text-warning mb-2">رشته</span>
                                <h3 class="fw-bold mb-0 fs-6">{{ $student->major }}</h3>
                                <small class="text-muted">رشته تحصیلی</small>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-diagram-3-fill text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-info bg-opacity-10 text-info mb-2">کد ملی</span>
                                <h3 class="fw-bold mb-0 fs-6">{{ $student->national_code }}</h3>
                                <small class="text-muted">شناسه یکتا</small>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-person-badge-fill text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- آمار درخواست‌ها --}}
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class="bi bi-clock-history text-warning fs-3"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $pendingRequests ?? 0 }}</h3>
                        <p class="text-muted mb-0">درخواست در انتظار</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class="bi bi-check-circle-fill text-success fs-3"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $approvedRequests ?? 0 }}</h3>
                        <p class="text-muted mb-0">درخواست تایید شده</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 text-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3 d-inline-block mb-3">
                            <i class="bi bi-x-circle-fill text-danger fs-3"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $rejectedRequests ?? 0 }}</h3>
                        <p class="text-muted mb-0">درخواست رد شده</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            {{-- اطلاعات شخصی --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-person-circle text-primary"></i> اطلاعات شخصی
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="text-muted small">نام</label>
                                <p class="fw-bold mb-0">{{ $student->first_name }}</p>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">نام خانوادگی</label>
                                <p class="fw-bold mb-0">{{ $student->last_name }}</p>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">شماره موبایل</label>
                                <p class="fw-bold mb-0" dir="ltr">{{ $student->phone }}</p>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">کد ملی</label>
                                <p class="fw-bold mb-0" dir="ltr">{{ $student->national_code }}</p>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">رشته تحصیلی</label>
                                <p class="fw-bold mb-0">{{ $student->major }}</p>
                            </div>
                            <div class="col-6">
                                <label class="text-muted small">پایه</label>
                                <p class="fw-bold mb-0">{{ $student->grade }}</p>
                            </div>
                            <div class="col-12">
                                <label class="text-muted small">تاریخ عضویت</label>
                                <p class="fw-bold mb-0">{{ $student->created_at ? $student->created_at->format('Y/m/d') : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- اقدامات سریع --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-lightning-charge-fill text-warning"></i> اقدامات سریع
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-grid gap-3">
                            <a href="{{ route('student.internship-requests.create') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle"></i> درخواست کارآموزی جدید
                            </a>
                            <a href="{{ route('student.internship-requests.index') }}" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-list-check"></i> مشاهده درخواست‌های من
                            </a>
                            <a href="{{ route('student.profile') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-person-gear"></i> ویرایش پروفایل
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    .student-content-wrapper {
        min-height: 100vh;
    }
    
    @media (min-width: 992px) {
        .student-content-wrapper {
            margin-right: 240px;
        }
    }
    
    @media (max-width: 991px) {
        .student-content-wrapper {
            margin-right: 0;
        }
    }
    
    .card {
        transition: all 0.3s ease;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1) !important;
    }
    
    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
    
    .btn-lg {
        padding: 12px 20px;
        font-size: 1rem;
    }
</style>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">