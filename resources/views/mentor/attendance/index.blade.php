@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col text-end">
                <h2 class="fw-bold">📋 حضور غیاب کارآموزی</h2>
                <p class="text-muted">لیست دانش‌آموزانی که تحت نظارت شما هستند</p>
            </div>
        </div>

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

        <div class="card shadow-sm border-0 rounded-4">
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
                                <th>محل کارآموزی</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $student->first_name }}</td>
                                <td class="fw-bold">{{ $student->last_name }}</td>
                                <td dir="ltr">{{ $student->phone }}</td>
                                <td>{{ $student->major }}</td>
                                <td>{{ $student->grade }}</td>
                                <td>{{ $student->company_name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('mentor.attendance.show', $student->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> مشاهده دفترچه
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هیچ دانش‌آموزی یافت نشد
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
    body {
        direction: rtl;
        text-align: right;
    }

    @media (min-width: 992px) {
        .mentor-content-wrapper {
            margin-right: 260px;
            min-height: 100vh;
            padding: 25px;
        }
    }
    @media (max-width: 991px) {
        .mentor-content-wrapper {
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
    .card {
        border-radius: 15px;
    }
</style>