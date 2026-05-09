@include('admin.components.sidebar')

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ========== فایل‌های محلی (اولویت اول) ========== -->
    <!-- فونت شبنم محلی -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap محلی -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons محلی (اگه داری) -->
    @if(file_exists(public_path('assets/css/bootstrap-icons.min.css')))
        <link href="{{ asset('assets/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    @endif
    
    <!-- Chart.js محلی (اگه داری) -->
    @if(file_exists(public_path('assets/js/chart.min.js')))
        <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    @endif
    
    <!-- ========== فایل‌های CDN (پشتیبان) ========== -->
    <!-- Bootstrap RTL از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- فونت وزیرمتن از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.1/Vazirmatn-font-face.css" rel="stylesheet">
    
    <!-- Bootstrap Icons از CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Chart.js از CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Bootstrap JS از CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Shabnam', 'Vazirmatn', 'IRANSans', 'Tahoma', sans-serif;
            direction: rtl;
            text-align: right;
        }
        
        .content-wrapper {
            margin-right: 240px;
        }
        
        @media (max-width: 992px) {
            .content-wrapper {
                margin-right: 0;
            }
        }
        
        .card {
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        /* فیلدهای عددی */
        input[type="text"],
        input[type="tel"],
        input[type="password"],
        .ltr-text {
            font-family: 'Shabnam', 'Vazirmatn', 'Tahoma', sans-serif;
            direction: ltr;
            text-align: left;
        }
        
        /* اعداد توی جدول */
        .table-ltr {
            direction: ltr;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">داشبورد مدیریت</h2>
                <p class="text-muted">به پنل مدیریت خوش آمدید {{ session('admin_name') }} 👋</p>
            </div>
        </div>

        {{-- کارت‌های آماری --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 bg-primary bg-gradient text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">تعداد کل دانش آموزان</h6>
                                <h2 class="text-white fw-bold mb-0">{{ $totalStudents ?? 0 }}</h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-people fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 bg-success bg-gradient text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">دانش آموزان فعال</h6>
                                <h2 class="text-white fw-bold mb-0">{{ $activeStudents ?? 0 }}</h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-check-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 bg-warning bg-gradient text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">دانش آموزان غیرفعال</h6>
                                <h2 class="text-white fw-bold mb-0">{{ $inactiveStudents ?? 0 }}</h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-x-circle fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 bg-info bg-gradient text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">تعداد رشته‌ها</h6>
                                <h2 class="text-white fw-bold mb-0">{{ $totalMajors ?? 0 }}</h2>
                            </div>
                            <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                <i class="bi bi-book fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- نمودار پایه و رشته --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-pie-chart text-primary"></i> توزیع دانش آموزان بر اساس پایه
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="gradeChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-bar-chart text-success"></i> توزیع دانش آموزان بر اساس رشته
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="majorChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        {{-- لیست آخرین دانش آموزان --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history text-info"></i> آخرین دانش آموزان ثبت شده
                    </h5>
                    <a href="{{ route('students.index') }}" class="btn btn-sm btn-outline-primary">
                        مشاهده همه <i class="bi bi-arrow-left"></i>
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>نام و نام خانوادگی</th>
                                <th>شماره موبایل</th>
                                <th>رشته</th>
                                <th>پایه</th>
                                <th>تاریخ ثبت</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStudents ?? [] as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $student->first_name }} {{ $student->last_name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td><span class="badge bg-info">{{ $student->major }}</span></td>
                                    <td><span class="badge bg-success">{{ $student->grade }}</span></td>
                                    <td dir="ltr">{{ $student->created_at ? $student->created_at->format('Y/m/d H:i') : '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هنوز دانش آموزی ثبت نشده است
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // نمودار پایه
    const gradeCtx = document.getElementById('gradeChart').getContext('2d');
    new Chart(gradeCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(array_keys($gradeStats ?? [])) !!},
            datasets: [{
                data: {!! json_encode(array_values($gradeStats ?? [])) !!},
                backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    rtl: true
                }
            }
        }
    });

    // نمودار رشته
    const majorCtx = document.getElementById('majorChart').getContext('2d');
    new Chart(majorCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($majorStats ?? [])) !!},
            datasets: [{
                label: 'تعداد دانش آموزان',
                data: {!! json_encode(array_values($majorStats ?? [])) !!},
                backgroundColor: '#4e73df',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>

</body>
</html>