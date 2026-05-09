<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
<meta charset="UTF-8">
<title>سامانه مدیریت کارآموزی</title>

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
    font-family: Vazirmatn, sans-serif !important;
    background:#f5f6fa;
}

.hero-section {
    padding: 100px 20px;
    text-align: center;
    background: linear-gradient(135deg, #007bff 0%, #004085 100%);
    color: white;
}

.info-box {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 18px rgba(0,0,0,0.05);
    margin-top: -50px;
}
</style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm p-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="/">سامانه مدیریت کارآموزی</a>

    <div>
      <a href="{{ route('login') }}" class="btn btn-primary">
        ورود به سامانه
      </a>
    </div>
  </div>
</nav>

<section class="hero-section">
  <h1 class="fw-bold">به سامانه مدیریت کارآموزی خوش آمدید</h1>
  <p class="mt-3">
    این سامانه برای مدیریت دانش‌آموزان، دوره‌های کارآموزی و گزارش‌های روزانه طراحی شده است.
  </p>
</section>

<div class="container">
  <div class="info-box">

    <h4 class="text-center fw-bold mb-4">این سامانه چه قابلیت‌هایی دارد؟</h4>

    <div class="row text-center">

      <div class="col-md-4 mb-3">
        <div class="p-3">
          <i class="fas fa-users fa-2x text-primary mb-3"></i>
          <h5>مدیریت دانش‌آموزان</h5>
          <p>ثبت‌نام، ویرایش و مشاهده وضعیت کارآموزی دانش‌آموزان</p>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="p-3">
          <i class="fas fa-file-alt fa-2x text-primary mb-3"></i>
          <h5>گزارش کار عملی</h5>
          <p>ثبت و بررسی گزارش‌های روزانه و هفتگی دانش‌آموزان</p>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="p-3">
          <i class="fas fa-building fa-2x text-primary mb-3"></i>
          <h5>شرکت‌ها و مراکز کارآموزی</h5>
          <p>مدیریت محل کارآموزی و مربیان مربوطه</p>
        </div>
      </div>

    </div>

    <div class="text-center mt-4">
      <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
        ورود به سامانه
      </a>
    </div>

  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
