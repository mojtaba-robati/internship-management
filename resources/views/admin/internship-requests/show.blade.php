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

        {{-- اطلاعات دانش‌آموز و محل کارآموزی در دو ستون --}}
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
        @if($internshipRequest->status == 'pending')
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
                            <button type="submit" class="btn btn-success w-100">تایید درخواست</button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('admin.internship-requests.reject', $internshipRequest->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label text-danger">دلیل رد</label>
                                <textarea name="admin_notes" class="form-control" rows="3" required placeholder="لطفاً دلیل رد درخواست را وارد کنید..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">رد درخواست</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card">
            <div class="card-body text-center">
                @if($internshipRequest->status == 'approved')
                    <div class="alert alert-success">
                        <i class="bi bi-check-circle-fill fs-3"></i>
                        <h5 class="mt-2">این درخواست تایید شده است</h5>
                        @if($internshipRequest->admin_notes)
                            <p><strong>یادداشت:</strong> {{ $internshipRequest->admin_notes }}</p>
                        @endif
                        <small>تاریخ بررسی: {{ $internshipRequest->reviewed_at }}</small>
                    </div>
                @else
                    <div class="alert alert-danger">
                        <i class="bi bi-x-circle-fill fs-3"></i>
                        <h5 class="mt-2">این درخواست رد شده است</h5>
                        @if($internshipRequest->admin_notes)
                            <p><strong>دلیل رد:</strong> {{ $internshipRequest->admin_notes }}</p>
                        @endif
                        <small>تاریخ بررسی: {{ $internshipRequest->reviewed_at }}</small>
                    </div>
                @endif
            </div>
        </div>
        @endif

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
</style>