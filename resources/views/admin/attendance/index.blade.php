@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col text-end"> <!-- راست‌چین کردن عنوان -->
                <h2 class="fw-bold">📋 حضور غیاب کارآموزی</h2>
                <p class="text-muted">لیست دانش‌آموزانی که درخواست کارآموزی آن‌ها تایید شده است</p>
            </div>
        </div>

        {{-- نمایش پیام‌های موفقیت یا خطا --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show text-end" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-end" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>شماره موبایل</th>
                                <th>رشته</th>
                                <th>پایه</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                            <tr>
                                <td>{{ $index + 1 }}</td> {{-- اینجا تگ اصلاح شد --}}
                                <td class="fw-bold">{{ $student->first_name }}</td>
                                <td class="fw-bold">{{ $student->last_name }}</td>
                                <td dir="ltr">{{ $student->phone }}</td>
                                <td>{{ $student->major }}</td>
                                <td>{{ $student->grade }}</td>
                                <td>
                                    <a href="{{ route('admin.attendance.show', $student->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> مشاهده دفترچه
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-5">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    هیچ دانش‌آموزی با درخواست تایید شده یافت نشد
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    /* تنظیمات فونت فارسی برای کل صفحه (اختیاری اما توصیه شده) */
    body {
        direction: rtl;
        text-align: right;
    }

    @media (min-width: 992px) {
        .content-wrapper {
            margin-right: 240px; /* چون سایدبار سمت راسته، مارجین راست می‌خوایم */
            margin-left: 0;
            padding: 25px;
        }
    }
    @media (max-width: 991px) {
        .content-wrapper {
            margin-right: 0;
            padding: 15px;
        }
    }
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
    }
    .btn-sm {
        padding: 5px 12px;
    }
</style>    