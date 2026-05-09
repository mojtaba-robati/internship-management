<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن معاون جدید</title>
    
    <!-- ========== فایل‌های محلی (اولویت اول) ========== -->
    <!-- فونت شبنم محلی -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap محلی -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons محلی -->
    @if(file_exists(public_path('assets/css/bootstrap-icons.min.css')))
        <link href="{{ asset('assets/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    @endif
    
    <!-- ========== فایل‌های CDN (پشتیبان) ========== -->
    <!-- Bootstrap RTL از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- فونت وزیرمتن از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.1/Vazirmatn-font-face.css" rel="stylesheet">
    
    <!-- Bootstrap Icons از CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
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
        
        @media (min-width: 992px) {
            .content-wrapper {
                margin-right: 240px;
                padding: 25px;
            }
        }
        
        @media (max-width: 991px) {
            .content-wrapper {
                margin-right: 0;
                padding: 15px;
            }
        }
        
        .card {
            border-radius: 15px;
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
        
        .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
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
        
        .btn-secondary {
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            transform: translateY(-2px);
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        .text-muted {
            font-size: 12px;
        }
    </style>
</head>
<body>

@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">افزودن معاون جدید</h2>
                <p class="text-muted">اطلاعات معاون آموزشی را وارد کنید</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>خطا!</strong> لطفاً اطلاعات را بررسی کنید.
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('vice-principals.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">نام <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نام خانوادگی <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">شماره موبایل <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="09xxxxxxxxx" value="{{ old('phone') }}" maxlength="11" required>
                            <small class="text-muted">11 رقم و با 09 شروع شود</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">کد ملی <span class="text-danger">*</span></label>
                            <input type="text" name="national_code" class="form-control" placeholder="10 رقم عددی" value="{{ old('national_code') }}" maxlength="10" required>
                            <small class="text-muted">10 رقم عددی (اجباری)</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">رمز عبور <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="حداقل 4 کاراکتر" required>
                            <small class="text-muted">حداقل 4 کاراکتر</small>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> ذخیره
                            </button>
                            <a href="{{ route('vice-principals.index') }}" class="btn btn-secondary px-4">
                                <i class="bi bi-x-circle"></i> انصراف
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    // محدودیت شماره موبایل به 11 رقم (فقط اعداد)
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        });
    }
    
    // محدودیت کد ملی به 10 رقم (فقط اعداد)
    const nationalCodeInput = document.querySelector('input[name="national_code"]');
    if (nationalCodeInput) {
        nationalCodeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }
    
    // حذف فاصله و کاراکترهای غیرمجاز در زمان کپی/پیست
    const inputs = document.querySelectorAll('input[type="text"], input[type="tel"]');
    inputs.forEach(input => {
        input.addEventListener('paste', function(e) {
            setTimeout(() => {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, this.maxLength || 999);
            }, 10);
        });
    });
</script>

</body>
</html>