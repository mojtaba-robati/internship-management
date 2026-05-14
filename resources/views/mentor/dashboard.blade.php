@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        {{-- هدر خوش‌آمدگویی با نام مربی --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="welcome-card rounded-4 p-4 text-white" style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h2 class="fw-bold mb-2">
                                <i class="bi bi-person-badge-fill"></i> خوش آمدید {{ session('mentor_name') }}
                            </h2>
                            <p class="mb-0 opacity-75">به پنل مربی ناظر خوش آمدید. دانش‌آموزان تحت نظارت خود را مدیریت کنید.</p>
                        </div>
                        <div class="text-center d-none d-md-block">
                            <i class="bi bi-mortarboard-fill fs-1 opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- کارت‌های آماری --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                                    <i class="bi bi-people-fill"></i> آمار
                                </span>
                                <h3 class="fw-bold mb-0">{{ $totalStudents }}</h3>
                                <p class="text-muted small mb-0">تعداد کل دانش‌آموزان</p>
                            </div>
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-people-fill text-primary fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                    <i class="bi bi-check-circle-fill"></i> فعال
                                </span>
                                <h3 class="fw-bold mb-0">{{ $activeStudents }}</h3>
                                <p class="text-muted small mb-0">دانش‌آموزان فعال</p>
                            </div>
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-info bg-opacity-10 text-info mb-2">
                                    <i class="bi bi-building"></i> کارآموزی
                                </span>
                                <h3 class="fw-bold mb-0">{{ $students->whereNotNull('company_name')->count() }}</h3>
                                <p class="text-muted small mb-0">دارای محل کارآموزی</p>
                            </div>
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-building text-info fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <span class="badge bg-warning bg-opacity-10 text-warning mb-2">
                                    <i class="bi bi-calendar-check"></i> رشته‌ها
                                </span>
                                <h3 class="fw-bold mb-0">{{ $students->unique('major')->count() }}</h3>
                                <p class="text-muted small mb-0">تعداد رشته‌های مختلف</p>
                            </div>
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-diagram-3 text-warning fs-4"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- لیست دانش‌آموزان --}}
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-mortarboard-fill text-primary"></i> دانش‌آموزان تحت نظارت
                    </h5>
                    <span class="badge bg-secondary">{{ $students->count() }} نفر</span>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="studentsTable">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>نام دانش‌آموز</th>
                                <th>کد ملی</th>
                                <th>رشته</th>
                                <th>پایه</th>
                                <th>محل کارآموزی</th>
                                <th>وضعیت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 14px;">
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        </div>
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                </td>
                                <td dir="ltr"><code>{{ $student->national_code }}</code></td>
                                <td>
                                    <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">{{ $student->major }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2">{{ $student->grade }}</span>
                                </td>
                                <td>
                                    @if($student->company_name)
                                        <span class="fw-bold">{{ Str::limit($student->company_name, 25) }}</span>
                                    @else
                                        <span class="text-muted">ثبت نشده</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($student->assignment_status == 'active')
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-secondary">تکمیل شده</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هیچ دانش‌آموزی به شما تخصیص داده نشده است
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        {{-- اطلاعات تماس --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="alert alert-light border-0 shadow-sm rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-headset text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">پشتیبانی</h6>
                            <small class="text-muted">در صورت نیاز به راهنمایی با اداره کارآموزی تماس بگیرید.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<style>
    @media (min-width: 992px) {
        .mentor-content-wrapper {
            margin-right: 260px;
            min-height: 100vh;
        }
    }
    @media (max-width: 991px) {
        .mentor-content-wrapper {
            margin-right: 0;
        }
    }
    .card {
        border-radius: 15px;
        transition: all 0.3s ease;
    }
    .card:hover {
        transform: translateY(-3px);
    }
    .table td, .table th {
        vertical-align: middle;
    }
    .avatar-circle {
        font-weight: bold;
    }
    .badge {
        font-size: 12px;
    }
    .welcome-card {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    .bg-opacity-10 {
        --bs-bg-opacity: 0.1;
    }
</style>