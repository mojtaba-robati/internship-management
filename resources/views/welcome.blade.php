<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سامانه مدیریت کارآموزی</title>

    <!-- ========== فایل‌های محلی ========== -->
    <!-- فونت شبنم محلی -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap محلی -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons محلی -->
    <link href="{{ asset('assets/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap JS محلی -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <style>
        body {
            font-family: 'Shabnam', 'Vazirmatn', 'IRANSans', 'Tahoma', sans-serif;
            background: #f5f6fa;
        }
        
        .hero-section {
            padding: 100px 20px;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .info-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 18px rgba(0,0,0,0.05);
            margin-top: -50px;
        }
        
        .navbar-brand {
            font-weight: bold;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .info-box i {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        
        .text-primary {
            color: #667eea !important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-mortarboard-fill text-primary"></i> سامانه مدیریت کارآموزی
        </a>
        <div>
            <a href="{{ route('login') }}" class="btn btn-primary">
                <i class="bi bi-box-arrow-in-right"></i> ورود به سامانه
            </a>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <h1 class="fw-bold">سامانه مدیریت کارآموزی هنرستان مرشدیان</h1>
        <p class="mt-3 opacity-75">
            این سامانه برای مدیریت دانش‌آموزان، دوره‌های کارآموزی و گزارش‌های روزانه طراحی شده است.
        </p>
    </div>
</section>

<div class="container">
    <div class="info-box">
        <h4 class="text-center fw-bold mb-4">این سامانه چه قابلیت‌هایی دارد؟</h4>
        <div class="row text-center">
            <div class="col-md-4 mb-3">
                <div class="p-3">
                    <i class="bi bi-people-fill text-primary"></i>
                    <h5 class="mt-2">مدیریت دانش‌آموزان</h5>
                    <p class="text-muted">ثبت‌نام، ویرایش و مشاهده وضعیت کارآموزی دانش‌آموزان</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="p-3">
                    <i class="bi bi-file-text-fill text-primary"></i>
                    <h5 class="mt-2">گزارش کار عملی</h5>
                    <p class="text-muted">ثبت و بررسی گزارش‌های روزانه و هفتگی دانش‌آموزان</p>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="p-3">
                    <i class="bi bi-building-fill text-primary"></i>
                    <h5 class="mt-2">شرکت‌ها و مراکز کارآموزی</h5>
                    <p class="text-muted">مدیریت محل کارآموزی و مربیان مربوطه</p>
                </div>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-box-arrow-in-right"></i> ورود به سامانه
            </a>
        </div>
    </div>
</div>

</body>
</html>