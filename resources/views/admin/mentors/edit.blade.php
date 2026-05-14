@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">ویرایش مربی</h2>
                <p class="text-muted">اطلاعات مربی ناظر را ویرایش کنید</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('mentors.update', $mentor->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">نام <span class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $mentor->first_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">نام خانوادگی <span class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $mentor->last_name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">کد ملی <span class="text-danger">*</span></label>
                            <input type="text" name="national_code" class="form-control" maxlength="10" value="{{ old('national_code', $mentor->national_code) }}" required>
                            <small class="text-muted">10 رقم عددی</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">شماره موبایل <span class="text-danger">*</span></label>
                            <input type="tel" name="phone" class="form-control" placeholder="09xxxxxxxxx" maxlength="11" value="{{ old('phone', $mentor->phone) }}" required>
                            <small class="text-muted">11 رقم و با 09 شروع شود</small>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">رمز عبور جدید <span class="text-muted">(اختیاری)</span></label>
                            <input type="password" name="password" class="form-control" minlength="4" placeholder="در صورت تمایل تغییر دهید">
                            <small class="text-muted">حداقل 4 کاراکتر - در صورت نخواستن تغییر، خالی بگذارید</small>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> بروزرسانی
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
    document.querySelector('input[name="phone"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
    });
    
    document.querySelector('input[name="national_code"]').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
    });
</script>