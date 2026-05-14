@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">📋 لیست دانش‌آموزان</h2>
                        <p class="text-muted">مشاهده تمام دانش‌آموزان تحت نظارت شما</p>
                    </div>
                    <a href="{{ route('mentor.dashboard') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>نام و نام خانوادگی</th>
                                <th>کد ملی</th>
                                <th>رشته</th>
                                <th>پایه</th>
                                <th>محل کارآموزی</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($students as $index => $student)
                            <tr>
                                <td class="text-center">{{ ($students->currentPage() - 1) * $students->perPage() + $index + 1 }}</td>
                                <td class="fw-bold">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                            {{ substr($student->first_name, 0, 1) }}{{ substr($student->last_name, 0, 1) }}
                                        </div>
                                        {{ $student->first_name }} {{ $student->last_name }}
                                    </div>
                                </td>
                                <td dir="ltr">{{ $student->national_code }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $student->major }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $student->grade }}</span>
                                </td>
                                <td>{{ Str::limit($student->company_name ?? '-', 30) }}</td>
                                <td class="text-center">
                                    @if($student->assignment_status == 'active')
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-secondary">تکمیل شده</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('mentor.students.show', $student->id) }}" class="btn btn-sm btn-primary" title="مشاهده جزئیات">
                                            <i class="bi bi-person-badge"></i> جزئیات
                                        </a>
                                        <a href="{{ route('mentor.attendance.show', $student->id) }}" class="btn btn-sm btn-info" title="دفترچه حضور غیاب">
                                            <i class="bi bi-calendar-check"></i> دفترچه
                                        </a>
                                    </div>
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
        
        <div class="mt-4">
            {{ $students->links() }}
        </div>
        
    </div>
</div>

<style>
    @media (min-width: 992px) {
        .mentor-content-wrapper { margin-right: 260px; min-height: 100vh; }
    }
    @media (max-width: 991px) { .mentor-content-wrapper { margin-right: 0; } }
    .avatar-circle { font-weight: bold; font-size: 14px; }
    .table td, .table th { vertical-align: middle; text-align: center; }
    .btn-group { gap: 5px; }
</style>