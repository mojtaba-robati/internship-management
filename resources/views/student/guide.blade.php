@include('student.components.sidebar')

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">📖 راهنمای کارآموزی</h2>
                <p class="text-muted">مراحل و نکات مهم دوره کارآموزی شما</p>
            </div>
        </div>

        <div class="row g-4">
            
            {{-- مرحله 1: درخواست کارآموزی --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-envelope-paper-fill text-primary fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">مرحله 1: ثبت درخواست کارآموزی</h5>
                                <span class="badge bg-primary">شروع</span>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            ابتدا باید درخواست کارآموزی خود را ثبت کنید. برای این کار:
                        </p>
                        <ul class="list-unstyled">
                            <li class="mb-2">✅ اطلاعات محل کارآموزی خود را وارد کنید</li>
                            <li class="mb-2">✅ نام سرپرست و تلفن تماس را وارد کنید</li>
                            <li class="mb-2">✅ شرح وظایف و فعالیت‌های خود را بنویسید</li>
                        </ul>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i>
                            <strong>نکته:</strong> پس از ثبت درخواست، مدیر یا معاون آموزشی آن را بررسی می‌کنند.
                        </div>
                    </div>
                </div>
            </div>

            {{-- مرحله 2: بررسی درخواست --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-clock-history text-warning fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">مرحله 2: بررسی درخواست</h5>
                                <span class="badge bg-warning text-dark">در انتظار</span>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            درخواست شما توسط مدیر یا معاون آموزشی بررسی می‌شود:
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 text-center bg-success bg-opacity-10">
                                    <i class="bi bi-check-circle-fill text-success fs-2 d-block mb-2"></i>
                                    <h6 class="fw-bold">✅ تایید درخواست</h6>
                                    <p class="text-muted small mb-0">
                                        در صورت تایید، دسترسی به دفترچه حضور غیاب و گزارش کار فعال می‌شود.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 text-center bg-danger bg-opacity-10">
                                    <i class="bi bi-x-circle-fill text-danger fs-2 d-block mb-2"></i>
                                    <h6 class="fw-bold">❌ رد درخواست</h6>
                                    <p class="text-muted small mb-0">
                                        در صورت رد، می‌توانید درخواست جدیدی ثبت کنید و دوباره بررسی شود.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <strong>توجه:</strong> پس از تایید درخواست، دیگر نمی‌توانید درخواست جدیدی ثبت کنید. برای تغییر باید به مدیر یا معاون اطلاع دهید.
                        </div>
                    </div>
                </div>
            </div>

            {{-- مرحله 3: حضور غیاب و گزارش کار --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-clipboard-check text-success fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">مرحله 3: ثبت حضور غیاب و گزارش کار</h5>
                                <span class="badge bg-success">فعال</span>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            پس از تایید درخواست، دو بخش برای شما فعال می‌شود:
                        </p>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-calendar-check-fill text-primary fs-4"></i>
                                        <h6 class="fw-bold mb-0">دفترچه حضور غیاب</h6>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        ساعت ورود و خروج خود را در ۴۰ روز کاری ثبت کنید.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="bi bi-file-text-fill text-info fs-4"></i>
                                        <h6 class="fw-bold mb-0">گزارش کار روزانه</h6>
                                    </div>
                                    <p class="text-muted small mb-0">
                                        شرح فعالیت‌های روزانه خود را برای ۴۰ روز کاری ثبت کنید.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle"></i>
                            <strong>نکته:</strong> از روزی که کارآموزی شما شروع می‌شود، باید گزارش‌های خود را ثبت کنید.
                        </div>
                    </div>
                </div>
            </div>

            {{-- مرحله 4: نمره دهی --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-star-fill text-warning fs-3"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">مرحله 4: نمره نهایی</h5>
                                <span class="badge bg-warning text-dark">پایان دوره</span>
                            </div>
                        </div>
                        <p class="text-muted mb-3">
                            در پایان دوره کارآموزی، مربی ناظر عملکرد شما را بررسی می‌کند:
                        </p>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <ul class="list-unstyled">
                                    <li class="mb-2">✅ بررسی گزارش‌های کار ثبت شده</li>
                                    <li class="mb-2">✅ ارزیابی حضور و غیاب شما</li>
                                    <li class="mb-2">✅ بررسی کیفیت و کمیت کارهای انجام شده</li>
                                    <li class="mb-2">✅ ثبت نمره نهایی از ۰ تا ۱۵</li>
                                </ul>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="bg-light rounded-3 p-4">
                                    <span class="display-4 fw-bold text-primary">۱۵</span>
                                    <p class="text-muted small mb-0">حداکثر نمره</p>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-success mt-3">
                            <i class="bi bi-check-circle-fill"></i>
                            <strong>نکته:</strong> پس از ثبت نمره، دوره کارآموزی شما تکمیل می‌شود و دیگر نمی‌توانید تغییری ایجاد کنید.
                        </div>
                    </div>
                </div>
            </div>

            {{-- خلاصه --}}
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 bg-primary bg-opacity-10">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">📌 خلاصه مراحل کارآموزی</h5>
                        <div class="d-flex flex-wrap gap-3 justify-content-between">
                            <div class="text-center">
                                <span class="badge bg-primary rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">1</span>
                                <p class="small mb-0 mt-1">ثبت درخواست</p>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-warning rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">2</span>
                                <p class="small mb-0 mt-1">بررسی درخواست</p>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-success rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">3</span>
                                <p class="small mb-0 mt-1">ثبت گزارش‌ها</p>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-info rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">4</span>
                                <p class="small mb-0 mt-1">دریافت نمره</p>
                            </div>
                            <div class="text-center">
                                <span class="badge bg-danger rounded-circle p-3 d-inline-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">✓</span>
                                <p class="small mb-0 mt-1">تکمیل دوره</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ارتباط با مدیر --}}
            <div class="col-12">
                <div class="alert alert-light border-0 shadow-sm rounded-4">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="bi bi-headset text-primary fs-4"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">❓ سوالی دارید؟</h6>
                            <small class="text-muted">در صورت نیاز به راهنمایی بیشتر، با مدیر یا معاون آموزشی تماس بگیرید.</small>
                        </div>
                    </div>
                </div>
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
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-3px);
    }
    .badge {
        font-size: 12px;
        padding: 5px 12px;
    }
</style>