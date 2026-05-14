@include('admin.components.sidebar')

<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- فقط فایل‌های محلی و در صورت وجود -->
    @if(file_exists(public_path('css/fonts.css')))
        <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    @endif
    
    @if(file_exists(public_path('assets/css/bootstrap.min.css')))
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    @endif
    
    <style>
        /* استایل‌های جایگزین برای همه چیز */
        body {
            background: #f5f6fa;
            font-family: 'Shabnam', 'Tahoma', 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
        }
        
        .content-wrapper {
            margin-right: 240px;
            min-height: 100vh;
            padding: 20px;
        }
        
        @media (max-width: 992px) {
            .content-wrapper {
                margin-right: 0;
            }
        }
        
        /* کارت‌ها */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 20px;
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
        
        .card-body {
            padding: 24px;
        }
        
        .card-header {
            padding: 20px 24px 0 24px;
            background: transparent;
            border: none;
        }
        
        /* گرادیانت‌های رنگی */
        .bg-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-success { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .bg-warning { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .bg-info { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        
        .text-white { color: white; }
        .text-white-50 { color: rgba(255,255,255,0.8); }
        .text-muted { color: #6c757d; }
        
        /* بدج (برچسب) */
        .badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .badge-info { background: #17a2b8; color: white; }
        .badge-success { background: #28a745; color: white; }
        .bg-opacity-25 { background: rgba(255,255,255,0.2); }
        
        /* جدول */
        .table-responsive {
            overflow-x: auto;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th,
        .table td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #dee2e6;
        }
        
        .table thead th {
            background: #f8f9fa;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* دکمه */
        .btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s;
        }
        
        .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }
        
        .btn-outline-primary {
            border: 1px solid #007bff;
            color: #007bff;
            background: white;
        }
        
        .btn-outline-primary:hover {
            background: #007bff;
            color: white;
        }
        
        /* یوتیلیتی‌ها */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }
        
        .col {
            flex: 1;
            padding: 10px;
        }
        
        .col-md-6 {
            width: 50%;
            padding: 10px;
        }
        
        .col-lg-3 {
            width: 25%;
            padding: 10px;
        }
        
        .d-flex {
            display: flex;
        }
        
        .justify-content-between {
            justify-content: space-between;
        }
        
        .align-items-center {
            align-items: center;
        }
        
        .fw-bold {
            font-weight: bold;
        }
        
        .mb-0 { margin-bottom: 0; }
        .mb-2 { margin-bottom: 8px; }
        .mb-4 { margin-bottom: 20px; }
        
        .rounded-circle {
            border-radius: 50%;
        }
        
        .text-center {
            text-align: center;
        }
        
        /* آیکون‌های ساده متنی */
        [class*="bi-"] {
            display: none;
        }
        
        @media (max-width: 768px) {
            .col-md-6, .col-lg-3 {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">📊 داشبورد مدیریت</h2>
                <p class="text-muted">به پنل مدیریت خوش آمدید {{ session('admin_name') ?? 'مدیر گرامی' }} 👋</p>
            </div>
        </div>

        {{-- کارت‌های آماری (بدون آیکون Bootstrap) --}}
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="card bg-primary text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">تعداد کل دانش آموزان</h6>
                                <h2 class="fw-bold mb-0">{{ number_format($totalStudents ?? 0) }}</h2>
                            </div>
                            <div class="bg-opacity-25 rounded-circle p-3" style="font-size: 32px;">👥</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card bg-success text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">دانش آموزان فعال</h6>
                                <h2 class="fw-bold mb-0">{{ number_format($activeStudents ?? 0) }}</h2>
                            </div>
                            <div class="bg-opacity-25 rounded-circle p-3" style="font-size: 32px;">✅</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card bg-warning text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">دانش آموزان غیرفعال</h6>
                                <h2 class="fw-bold mb-0">{{ number_format($inactiveStudents ?? 0) }}</h2>
                            </div>
                            <div class="bg-opacity-25 rounded-circle p-3" style="font-size: 32px;">❌</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card bg-info text-white">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-2">تعداد رشته‌ها</h6>
                                <h2 class="fw-bold mb-0">{{ number_format($totalMajors ?? 0) }}</h2>
                            </div>
                            <div class="bg-opacity-25 rounded-circle p-3" style="font-size: 32px;">📚</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول آخرین دانش آموزان (بدون نمودار) --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0">🕒 آخرین دانش آموزان ثبت شده</h5>
                    <a href="{{ route('students.index') }}" class="btn btn-outline-primary btn-sm">
                        مشاهده همه ←
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
                                <td class="fw-bold">{{ $student->first_name ?? '' }} {{ $student->last_name ?? '' }}</td>
                                <td dir="ltr">{{ $student->phone ?? '-' }}</td>
                                <td><span class="badge badge-info">{{ $student->major ?? '-' }}</span></td>
                                <td><span class="badge badge-success">{{ $student->grade ?? '-' }}</span></td>
                                <td dir="ltr">{{ $student->created_at ? $student->created_at->format('Y/m/d') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    📭 هنوز دانش آموزی ثبت نشده است
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
    // حذف کامل Chart.js و آیکون‌ها
    console.log('✅ صفحه بدون هیچ وابستگی خارجی لود شد');
    
    // پاک کردن هرگونه خطای احتمالی
    if (typeof Chart !== 'undefined') {
        delete window.Chart;
    }
</script>

</body>
</html>