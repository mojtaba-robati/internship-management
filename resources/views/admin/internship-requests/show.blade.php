@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">بررسی درخواست کارآموزی</h2>
                <p class="text-muted">مشاهده جزئیات و تایید/رد درخواست</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        {{-- اطلاعات دانش‌آموز و شرکت در دو ستون --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5>اطلاعات دانش‌آموز</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">نام:</th>
                                <td>{{ $internshipRequest->student->first_name }} {{ $internshipRequest->student->last_name }}</td>
                            </tr>
                            <tr>
                                <th>شماره موبایل:</th>
                                <td dir="ltr">{{ $internshipRequest->student->phone }}</td>
                            </tr>
                            <tr>
                                <th>کد ملی:</th>
                                <td dir="ltr">{{ $internshipRequest->student->national_code }}</td>
                            </tr>
                            <tr>
                                <th>رشته:</th>
                                <td>{{ $internshipRequest->student->major }}</td>
                            </tr>
                            <tr>
                                <th>پایه:</th>
                                <td>{{ $internshipRequest->student->grade }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5>اطلاعات محل کارآموزی</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 35%">نام محل کارآموزی:</th>
                                <td>{{ $internshipRequest->company_name }}</td>
                            </tr>
                            <tr>
                                <th>تلفن محل کارآموزی:</th>
                                <td dir="ltr">{{ $internshipRequest->company_phone ?: '-' }}</td>
                            </tr>
                            <tr>
                                <th>آدرس:</th>
                                <td>{{ $internshipRequest->company_address }}</td>
                            </tr>
                            @if($internshipRequest->supervisor_name)
                            <tr>
                                <th>نام سرپرست:</th>
                                <td>{{ $internshipRequest->supervisor_name }}</td>
                            </tr>
                            @endif
                            @if($internshipRequest->supervisor_phone)
                            <tr>
                                <th>تلفن سرپرست:</th>
                                <td dir="ltr">{{ $internshipRequest->supervisor_phone ?: '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- جزئیات درخواست --}}
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5>جزئیات درخواست</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <tr>
                        <th style="width: 20%">توضیحات:</th>
                        <td>{{ $internshipRequest->description }}</td>
                    </tr>
                    @if($internshipRequest->skills)
                    <tr>
                        <th>مهارت‌ها:</th>
                        <td>{{ $internshipRequest->skills }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th>تاریخ شروع:</th>
                        <td>{{ $internshipRequest->start_date ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>تاریخ پایان:</th>
                        <td>{{ $internshipRequest->end_date ?: '-' }}</td>
                    </tr>
                    <tr>
                        <th>تاریخ ثبت درخواست:</th>
                        <td dir="ltr">{{ $internshipRequest->created_at }}</td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- اقدامات --}}
        <div class="card">
            <div class="card-header bg-white">
                <h5>اقدام مورد نظر</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form action="{{ route('admin.internship-requests.approve', $internshipRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">یادداشت (اختیاری)</label>
                                <textarea name="admin_notes" class="form-control" rows="3" placeholder="در صورت تمایل یادداشتی اضافه کنید..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100" 
                                    {{ $internshipRequest->status == 'approved' ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle"></i> تایید درخواست
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.internship-requests.reject', $internshipRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-danger">دلیل رد (اختیاری)</label>
                                <textarea name="admin_notes" class="form-control" rows="3" placeholder="در صورت تمایل دلیل رد را وارد کنید..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100"
                                    {{ $internshipRequest->status == 'rejected' ? 'disabled' : '' }}>
                                <i class="bi bi-x-circle"></i> رد درخواست
                            </button>
                        </form>
                    </div>
                </div>
                
                {{-- نمایش وضعیت فعلی --}}
                <div class="mt-3 text-center">
                    <span class="text-muted">وضعیت فعلی: </span>
                    @if($internshipRequest->status == 'pending')
                        <span class="badge bg-warning text-dark">در انتظار بررسی</span>
                    @elseif($internshipRequest->status == 'approved')
                        <span class="badge bg-success">تایید شده</span>
                        @if($internshipRequest->admin_notes)
                            <br><small class="text-muted">یادداشت: {{ $internshipRequest->admin_notes }}</small>
                        @endif
                    @else
                        <span class="badge bg-danger">رد شده</span>
                        @if($internshipRequest->admin_notes)
                            <br><small class="text-muted">دلیل رد: {{ $internshipRequest->admin_notes }}</small>
                        @endif
                    @endif
                </div>
                
                {{-- دکمه بازنشانی به حالت در انتظار (برای تغییر مجدد) --}}
                @if($internshipRequest->status != 'pending')
                <div class="text-center mt-3">
                    <form action="{{ route('admin.internship-requests.reset', $internshipRequest->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('آیا از بازنشانی این درخواست مطمئن هستید؟')">
                            <i class="bi bi-arrow-counterclockwise"></i> بازنشانی به حالت در انتظار
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        <div class="mt-4 text-end">
            <a href="{{ route('admin.internship-requests.index') }}" class="btn btn-secondary">بازگشت به لیست</a>
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
    .card {
        border-radius: 12px;
        border: 1px solid #e0e0e0;
    }
    .card-header {
        border-bottom: 1px solid #e0e0e0;
        padding: 15px 20px;
    }
    .card-header h5 {
        margin: 0;
        font-weight: 600;
    }
    .table-bordered th, .table-bordered td {
        padding: 12px;
        border: 1px solid #dee2e6;
    }
    .table-bordered th {
        background-color: #f8f9fa;
    }
    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
</style>