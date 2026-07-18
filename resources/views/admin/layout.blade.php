@include('admin.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp

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
        
        /* کارت‌ها - ساده و بدون رنگ */
        .card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            margin-bottom: 20px;
            transition: transform 0.2s;
            border: 1px solid #f0f0f0;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }
        
        .card-body {
            padding: 24px;
        }
        
        .card-header {
            padding: 20px 24px 0 24px;
            background: transparent;
            border: none;
        }
        
        .stat-card {
            background: white;
            border: 1px solid #e8ecf1;
            border-radius: 16px;
            padding: 20px 24px;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            border-color: #c8d0d8;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stat-number {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a2e;
            margin: 0;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }
        
        /* بدج (برچسب) */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-info { background: #e3f2fd; color: #0d47a1; }
        .badge-success { background: #e8f5e9; color: #1b5e20; }
        .badge-warning { background: #fff3e0; color: #e65100; }
        
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
            padding: 12px 16px;
            text-align: right;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table thead th {
            background: #f8f9fa;
            font-weight: 600;
            color: #495057;
            border-bottom: 2px solid #e9ecef;
        }
        
        .table tbody tr:hover {
            background: #f8f9fa;
        }
        
        /* دکمه */
        .btn {
            display: inline-block;
            padding: 6px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
            border: 1px solid #dee2e6;
            background: white;
            color: #495057;
        }
        
        .btn-sm {
            padding: 4px 12px;
            font-size: 12px;
        }
        
        .btn-outline-primary {
            border: 1px solid #6c7a89;
            color: #6c7a89;
            background: white;
        }
        
        .btn-outline-primary:hover {
            background: #6c7a89;
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
            font-weight: 700;
        }
        
        .mb-0 { margin-bottom: 0; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 16px; }
        .mb-4 { margin-bottom: 24px; }
        
        .rounded-circle {
            border-radius: 50%;
        }
        
        .text-center {
            text-align: center;
        }
        
        .gap-2 {
            gap: 8px;
        }
        
        .gap-3 {
            gap: 16px;
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
                <h2 class="fw-bold" style="color: #1a1a2e;">📊 داشبورد مدیریت</h2>
                <p style="color: #6c757d; margin: 0;">به پنل مدیریت خوش آمدید {{ session('admin_name') ?? 'مدیر گرامی' }} 👋</p>
            </div>
        </div>

        {{-- کارت‌های آماری (ساده و بدون رنگ) --}}
        <div class="row mb-4">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">تعداد کل دانش آموزان</div>
                            <div class="stat-number">{{ number_format($totalStudents ?? 0) }}</div>
                        </div>
                        <div class="stat-icon">👥</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">دانش آموزان فعال</div>
                            <div class="stat-number">{{ number_format($activeStudents ?? 0) }}</div>
                        </div>
                        <div class="stat-icon">✅</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">دانش آموزان غیرفعال</div>
                            <div class="stat-number">{{ number_format($inactiveStudents ?? 0) }}</div>
                        </div>
                        <div class="stat-icon">⛔</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="stat-card">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="stat-label">تعداد رشته‌ها</div>
                            <div class="stat-number">{{ number_format($totalMajors ?? 0) }}</div>
                        </div>
                        <div class="stat-icon">📚</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- جدول آخرین دانش آموزان --}}
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="color: #1a1a2e;">🕒 آخرین دانش آموزان ثبت شده</h5>
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
                                <td dir="ltr">
                                    @php
                                        $jalaliDate = $student->created_at ? Jalalian::fromDateTime($student->created_at)->format('Y/m/d') : '-';
                                    @endphp
                                    {{ $jalaliDate }}
                                </td>
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
    console.log('✅ صفحه بدون هیچ وابستگی خارجی لود شد');
</script>

</body>
</html>