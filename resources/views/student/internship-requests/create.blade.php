@include('student.components.sidebar')

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">درخواست کارآموزی جدید</h2>
                <p class="text-muted">اطلاعات محل کارآموزی خود را وارد کنید</p>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('student.internship-requests.store') }}" method="POST">
                    @csrf
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label>نام محل کارآموزی <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>تلفن محل کارآموزی</label>
                            <input type="text" name="company_phone" class="form-control" maxlength="11" placeholder="09xxxxxxxxx">
                            <small class="text-muted">اختیاری - 11 رقم</small>
                        </div>
                        <div class="col-12">
                            <label>آدرس کامل محل کارآموزی <span class="text-danger">*</span></label>
                            <textarea name="company_address" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="col-md-6">
                            <label>نام سرپرست کارآموزی <span class="text-danger">*</span></label>
                            <input type="text" name="supervisor_name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label>تلفن سرپرست <span class="text-danger">*</span></label>
                            <input type="text" name="supervisor_phone" class="form-control" maxlength="11" placeholder="09xxxxxxxxx" required>
                            <small class="text-muted">11 رقم - ضروری</small>
                        </div>
                        <div class="col-md-6">
                            <label>تاریخ شروع</label>
                            <input type="date" name="start_date" class="form-control">
                            <small class="text-muted">اختیاری</small>
                        </div>
                        <div class="col-md-6">
                            <label>تاریخ پایان</label>
                            <input type="date" name="end_date" class="form-control">
                            <small class="text-muted">اختیاری</small>
                        </div>
                        <div class="col-12">
                            <label>توضیحات (چه کاری انجام می‌دهید؟) <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control" rows="4" required placeholder="شرح وظایف و فعالیت‌هایی که قرار است انجام دهید..."></textarea>
                        </div>
                        <div class="col-12">
                            <label>مهارت‌های مرتبط</label>
                            <textarea name="skills" class="form-control" rows="2" placeholder="مهارت‌هایی که دارید و در این کارآموزی استفاده می‌شود..."></textarea>
                            <small class="text-muted">اختیاری</small>
                        </div>
                        <div class="col-12 mt-4 text-end">
                            <button type="submit" class="btn btn-primary px-4">ثبت درخواست</button>
                            <a href="{{ route('student.internship-requests.index') }}" class="btn btn-secondary px-4">انصراف</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
    @media (min-width: 992px) { 
        .student-content-wrapper { 
            margin-right: 240px; 
            min-height: 100vh; 
        } 
    }
    @media (max-width: 991px) { 
        .student-content-wrapper { 
            margin-right: 0; 
        } 
    }
</style>

<script>
    // محدودیت تلفن محل کارآموزی به 11 رقم
    const companyPhone = document.querySelector('input[name="company_phone"]');
    if (companyPhone) {
        companyPhone.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        });
    }
    
    // محدودیت تلفن سرپرست به 11 رقم
    const supervisorPhone = document.querySelector('input[name="supervisor_phone"]');
    if (supervisorPhone) {
        supervisorPhone.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
        });
    }
</script>