@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">افزودن مربی جدید</h2>
                <p class="text-muted">اطلاعات مربی ناظر را وارد کنید</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('mentors.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">نام <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نام خانوادگی <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">کد ملی <span class="text-danger">*</span></label>
                            <input type="text" name="national_code" class="form-control" maxlength="10" required>
                            <small class="text-muted">10 رقم عددی</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">شماره موبایل <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="09xxxxxxxxx" maxlength="11" required>
                            <small class="text-muted">11 رقم و با 09 شروع شود</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">رمز عبور <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" minlength="4" required>
                            <small class="text-muted">برای ورود به پنل مربی - حداقل 4 کاراکتر</small>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> ذخیره
                            </button>
                            <a href="{{ route('mentors.index') }}" class="btn btn-secondary px-4">
                                <i class="bi bi-x-circle"></i> انصراف
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
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
</style>

<script>
    // محدودیت شماره موبایل به 11 رقم
    document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
    });
    
    // محدودیت کد ملی به 10 رقم
    document.querySelector('input[name="national_code"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
</script>