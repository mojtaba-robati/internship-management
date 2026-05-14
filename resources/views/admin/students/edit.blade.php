<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ویرایش دانش‌آموز</title>
    
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
        
        .alert {
            border-radius: 12px;
        }
    </style>
</head>
<body>

@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">

        <div class="row mb-4">
            <div class="col">
                <h4 class="fw-bold">
                    <i class="bi bi-pencil-square text-primary"></i> ویرایش دانش‌آموز
                </h4>
                <p class="text-muted">اطلاعات دانش‌آموز را ویرایش کنید</p>
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

                <form action="{{ route('students.update', $student->id) }}" method="POST" id="editStudentForm">
                    @csrf
                    @method('PUT')

                    <div class="row g-4">

                        <div class="col-md-6">
                            <label class="form-label">
                                نام
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $student->first_name) }}" required>
                            <div class="invalid-feedback">لطفاً نام را وارد کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                نام خانوادگی
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $student->last_name) }}" required>
                            <div class="invalid-feedback">لطفاً نام خانوادگی را وارد کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                شماره موبایل
                                <span class="text-danger">*</span>
                            </label>
                            <input type="tel" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}" placeholder="09xxxxxxxxx" maxlength="11" required>
                            <div class="invalid-feedback">شماره موبایل باید 11 رقم و با 09 شروع شود</div>
                            <small class="text-muted">مثال: 09123456789</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">
                                کد ملی
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="national_code" class="form-control" value="{{ old('national_code', $student->national_code) }}" maxlength="10" required>
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
                                <option value="کامپیوتر" {{ $student->major == 'کامپیوتر' ? 'selected' : '' }}>کامپیوتر</option>
                                <option value="تاسیسات" {{ $student->major == 'تاسیسات' ? 'selected' : '' }}>تاسیسات</option>
                                <option value="مکانیک" {{ $student->major == 'مکانیک' ? 'selected' : '' }}>مکانیک</option>
                                <option value="برق" {{ $student->major == 'برق' ? 'selected' : '' }}>برق</option>
                                <option value="معماری" {{ $student->major == 'معماری' ? 'selected' : '' }}>معماری</option>
                                <option value="گرافیک" {{ $student->major == 'گرافیک' ? 'selected' : '' }}>گرافیک</option>
                                <option value="حسابداری" {{ $student->major == 'حسابداری' ? 'selected' : '' }}>حسابداری</option>
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
                                <option value="دهم" {{ $student->grade == 'دهم' ? 'selected' : '' }}>دهم</option>
                                <option value="یازدهم" {{ $student->grade == 'یازدهم' ? 'selected' : '' }}>یازدهم</option>
                                <option value="دوازدهم" {{ $student->grade == 'دوازدهم' ? 'selected' : '' }}>دوازدهم</option>
                            </select>
                            <div class="invalid-feedback">لطفاً پایه را انتخاب کنید</div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">وضعیت حساب</label>
                            <select name="is_active" class="form-select">
                                <option value="1" {{ $student->is_active == 1 ? 'selected' : '' }}>فعال</option>
                                <option value="0" {{ $student->is_active == 0 ? 'selected' : '' }}>غیرفعال</option>
                            </select>
                        </div>

                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> بروزرسانی
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
    // محدودیت شماره موبایل به 11 رقم
    const phoneInput = document.querySelector('input[name="phone"]');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        });
    }
    
    // محدودیت کد ملی به 10 رقم
    const nationalCodeInput = document.querySelector('input[name="national_code"]');
    if (nationalCodeInput) {
        nationalCodeInput.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
        });
    }
    
    // اعتبارسنجی هنگام ارسال
    const form = document.getElementById('editStudentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            const phone = phoneInput?.value;
            const nationalCode = nationalCodeInput?.value;
            const phonePattern = /^09[0-9]{9}$/;
            const nationalPattern = /^[0-9]{10}$/;
            
            if (!phonePattern.test(phone)) {
                e.preventDefault();
                alert('شماره موبایل باید 11 رقم و با 09 شروع شود');
                phoneInput?.focus();
                return false;
            }
            
            if (!nationalPattern.test(nationalCode)) {
                e.preventDefault();
                alert('کد ملی باید 10 رقم باشد');
                nationalCodeInput?.focus();
                return false;
            }
        });
    }
</script>

</body>
</html>