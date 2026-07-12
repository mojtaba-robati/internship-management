@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">📝 گزارش‌های کار روزانه</h2>
                <p class="text-muted">مشاهده و بررسی گزارش‌های کار دانش‌آموزان تحت نظارت شما</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>نام دانش‌آموز</th>
                                <th>نام خانوادگی</th>
                                <th>محل کارآموزی</th>
                                <th>تعداد گزارش‌ها</th>
                                <th>در انتظار بررسی</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="fw-bold">{{ $student->first_name }}</td>
                                <td class="fw-bold">{{ $student->last_name }}</td>
                                <td>{{ $student->company_name ?? '-' }}</td>
                                <td class="text-center">{{ $student->total_count ?? 0 }}</td>
                                <td class="text-center">
                                    @if($student->pending_count > 0)
                                        <span class="badge bg-warning text-dark">{{ $student->pending_count }} گزارش جدید</span>
                                    @else
                                        <span class="badge bg-success">همه بررسی شده</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('mentor.work-reports.show', $student->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> مشاهده گزارش‌ها
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هیچ دانش‌آموزی با گزارش کار یافت نشد
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
    @media (min-width: 992px) {
        .mentor-content-wrapper {
            margin-right: 260px;
            min-height: 100vh;
        }
    }
    @media (max-width: 991px) {
        .mentor-content-wrapper {
            margin-right: 0;
        }
    }
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
    }
</style>