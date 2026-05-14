<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>افزودن دانش‌آموز جدید</title>
    
    <!-- ========== فایل‌های محلی (اولویت اول) ========== -->
    <!-- فونت شبنم محلی -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap محلی -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons محلی -->
    @if(file_exists(public_path('assets/css/bootstrap-icons.min.css')))
        <link href="{{ asset('assets/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    @endif
    
 
    
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
        
        .form-control:focus, .form-select:focus {
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
        
        .text-danger {
            font-size: 1.1rem;
            font-weight: bold;
        }
        
        .text-muted {
            font-size: 12px;
        }
        
        /* استایل خطاها */
        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-left: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: left calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
    </style>
</head>
<body>

@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">

        <div class="row mb-4">
            <div class="col">
                <h4 class="fw-bold">افزودن دانش‌آموز جدید</h4>
                <p class="text-muted">اطلاعات دانش‌آموز را وارد کنید</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>خطا!</strong> لطفاً اطلاعات را بررسی کنید.
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">

                <form action="{{ route('students.store') }}" method="POST" id="studentForm">
                    @csrf

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">
                                نام
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="first_name" class="form-control" required>
                            <div class="invalid-feedback">لطفاً نام را وارد کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                نام خانوادگی
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="last_name" class="form-control" required>
                            <div class="invalid-feedback">لطفاً نام خانوادگی را وارد کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                شماره موبایل
                                <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="phone" class="form-control" placeholder="09xxxxxxxxx" 
                                   maxlength="11" pattern="09[0-9]{9}" required>
                            <div class="invalid-feedback">شماره موبایل باید 11 رقم و با 09 شروع شود</div>
                            <small class="text-muted">مثال: 09123456789</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                کد ملی
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="national_code" class="form-control" 
                                   maxlength="10" pattern="[0-9]{10}" required>
                            <div class="invalid-feedback">کد ملی باید 10 رقم باشد</div>
                            <small class="text-muted">10 رقم عددی</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                رشته
                                <span class="text-danger">*</span>
                            </label>
                            <select name="major" class="form-select" required>
                                <option value="">انتخاب کنید</option>
                                <option value="کامپیوتر">کامپیوتر</option>
                                <option value="تاسیسات">تاسیسات</option>
                                <option value="مکانیک">مکانیک</option>
                                <option value="برق">برق</option>
                                <option value="معماری">معماری</option>
                                <option value="گرافیک">گرافیک</option>
                                <option value="حسابداری">حسابداری</option>
                            </select>
                            <div class="invalid-feedback">لطفاً رشته را انتخاب کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                پایه
                                <span class="text-danger">*</span>
                            </label>
                            <select name="grade" class="form-select" required>
                                <option value="">انتخاب کنید</option>
                                <option value="دهم">دهم</option>
                                <option value="یازدهم">یازدهم</option>
                                <option value="دوازدهم">دوازدهم</option>
                            </select>
                            <div class="invalid-feedback">لطفاً پایه را انتخاب کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                رمز عبور اولیه
                                <span class="text-danger">*</span>
                            </label>
                            <input type="password" name="password" class="form-control" required>
                            <div class="invalid-feedback">رمز عبور باید برابر با کد ملی باشد</div>
                            <small class="text-muted">رمز عبور اولیه باید با کد ملی یکسان باشد</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وضعیت حساب</label>
                            <select name="is_active" class="form-select">
                                <option value="1">فعال</option>
                                <option value="0">غیرفعال</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> ذخیره اطلاعات
                            </button>
                            <a href="{{ route('students.index') }}" class="btn btn-secondary px-4">
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
    // اعتبارسنجی سمت کاربر
    (function() {
        'use strict';
        
        const form = document.getElementById('studentForm');
        const phoneInput = document.querySelector('input[name="phone"]');
        const nationalCodeInput = document.querySelector('input[name="national_code"]');
        const passwordInput = document.querySelector('input[name="password"]');
        
        // تابع اعتبارسنجی شماره موبایل
        function validatePhone() {
            const phone = phoneInput.value;
            const phonePattern = /^09[0-9]{9}$/;
            
            if (!phonePattern.test(phone)) {
                phoneInput.setCustomValidity('شماره موبایل باید 11 رقم و با 09 شروع شود');
                return false;
            } else {
                phoneInput.setCustomValidity('');
                return true;
            }
        }
        
        // تابع اعتبارسنجی کد ملی
        function validateNationalCode() {
            const nationalCode = nationalCodeInput.value;
            const nationalPattern = /^[0-9]{10}$/;
            
            if (!nationalPattern.test(nationalCode)) {
                nationalCodeInput.setCustomValidity('کد ملی باید 10 رقم باشد');
                return false;
            } else {
                nationalCodeInput.setCustomValidity('');
                return true;
            }
        }
        
        // تابع اعتبارسنجی رمز عبور (برابر با کد ملی)
        function validatePassword() {
            const password = passwordInput.value;
            const nationalCode = nationalCodeInput.value;
            
            if (password !== nationalCode) {
                passwordInput.setCustomValidity('رمز عبور اولیه باید با کد ملی یکسان باشد');
                return false;
            } else if (password === '') {
                passwordInput.setCustomValidity('رمز عبور الزامی است');
                return false;
            } else {
                passwordInput.setCustomValidity('');
                return true;
            }
        }
        
        // اضافه کردن event listenerها
        if (phoneInput) {
            phoneInput.addEventListener('input', function() {
                validatePhone();
                if (phoneInput.value.length > 11) {
                    phoneInput.value = phoneInput.value.slice(0, 11);
                }
            });
        }
        
        if (nationalCodeInput) {
            nationalCodeInput.addEventListener('input', function() {
                validateNationalCode();
                if (nationalCodeInput.value.length > 10) {
                    nationalCodeInput.value = nationalCodeInput.value.slice(0, 10);
                }
                validatePassword();
            });
        }
        
        if (passwordInput) {
            passwordInput.addEventListener('input', validatePassword);
        }
        
        // اعتبارسنجی هنگام ارسال فرم
        if (form) {
            form.addEventListener('submit', function(event) {
                const isPhoneValid = validatePhone();
                const isNationalValid = validateNationalCode();
                const isPasswordValid = validatePassword();
                
                if (!isPhoneValid || !isNationalValid || !isPasswordValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    
                    if (!isPhoneValid && phoneInput) phoneInput.classList.add('is-invalid');
                    if (!isNationalValid && nationalCodeInput) nationalCodeInput.classList.add('is-invalid');
                    if (!isPasswordValid && passwordInput) passwordInput.classList.add('is-invalid');
                    
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstError.focus();
                    }
                }
                
                form.classList.add('was-validated');
            });
        }
        
        // حذف کلاس is-invalid هنگام تایپ
        [phoneInput, nationalCodeInput, passwordInput].forEach(input => {
            if (input) {
                input.addEventListener('input', function() {
                    this.classList.remove('is-invalid');
                });
            }
        });
        
    })();
</script>

</body>
</html>