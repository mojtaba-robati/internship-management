<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ورود به سیستم</title>
  
        
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
    
 

</head>
<body class="bg-primary bg-gradient" style="font-family: 'Vazirmatn', sans-serif;">

    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row justify-content-center w-100">
            <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                
                <div class="card border-0 shadow-lg rounded-4">
                    <div class="card-body p-4 p-sm-5">
                        
                        <div class="text-center mb-4">
                            <div class="bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <span style="font-size: 32px;">🔐</span>
                            </div>
                            <h2 class="fw-bold mb-1">خوش آمدید</h2>
                            <p class="text-muted">لطفاً اطلاعات خود را وارد کنید</p>
                        </div>

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                            </div>
                        @endif

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="بستن"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login.submit') }}">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-phone"></i> شماره موبایل
                                </label>
                                <input type="text" 
                                       name="phone" 
                                       class="form-control form-control-lg rounded-3" 
                                       placeholder="09xxxxxxxxx" 
                                       value="{{ old('phone') }}" 
                                       style="text-align: left; direction: ltr;"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-key"></i> رمز عبور / کد ملی
                                </label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control form-control-lg rounded-3" 
                                       placeholder="رمز عبور (ادمین) یا کد ملی (دانش آموز)"
                                       style="text-align: left; direction: ltr;"
                                       required>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 py-3 fw-bold shadow-sm">
                                ورود به سیستم
                            </button>
                        </form>

                        <hr class="my-4">

                        <div class="text-center">
                            <small class="text-muted">
                                <div>👨‍💼 <strong>ادمین:</strong> با شماره موبایل و رمز عبور وارد شوید</div>
                                <div class="mt-1">🎓 <strong>دانش آموز:</strong> با شماره موبایل و کد ملی وارد شوید</div>
                            </small>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
</body>
</html>