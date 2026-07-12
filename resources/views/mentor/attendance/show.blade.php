@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">دفترچه حضور غیاب</h2>
                        <p class="text-muted">
                            دانش‌آموز: {{ $student->first_name }} {{ $student->last_name }} |
                            محل کارآموزی: {{ $internshipRequest->company_name ?? '-' }}
                        </p>
                    </div>
                    <a href="{{ route('mentor.attendance.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>تاریخ</th>
                                <th>ساعت ورود</th>
                                <th>ساعت خروج</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($days as $row => $day)
                            <tr>
                                <td class="fw-bold">{{ $row }}</td>
                                <td dir="ltr">{{ $day['date_fa'] ?? $day['date'] ?? '-' }}</td>
                                <td dir="ltr">{{ $day['check_in'] ?? 'ثبت نشده' }}</td>
                                <td dir="ltr">{{ $day['check_out'] ?? 'ثبت نشده' }}</td>
                                <td>
                                    @if(($day['status'] ?? 'pending') == 'pending')
                                        <span class="badge bg-warning text-dark">در انتظار</span>
                                    @elseif(($day['status'] ?? '') == 'approved')
                                        <span class="badge bg-success">تایید شده</span>
                                    @else
                                        <span class="badge bg-danger">رد شده</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if(($day['status'] ?? 'pending') == 'pending')
                                        <div class="btn-group" role="group">
                                            <button type="button" 
                                                    class="btn btn-sm btn-success" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#approveModal{{ $row }}">
                                                <i class="bi bi-check-lg"></i> تایید
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#rejectModal{{ $row }}">
                                                <i class="bi bi-x-lg"></i> رد
                                            </button>
                                        </div>
                                        
                                        {{-- مودال تایید --}}
                                        <div class="modal fade" id="approveModal{{ $row }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-success text-white">
                                                        <h5 class="modal-title">تایید روز {{ $row }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('mentor.attendance.approve', [$attendance->id, $row]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body text-end">
                                                            <p>آیا از تایید روز {{ $row }} مطمئن هستید؟</p>
                                                            <div class="mb-3">
                                                                <label class="form-label">یادداشت (اختیاری)</label>
                                                                <textarea name="mentor_note" class="form-control" rows="2" placeholder="در صورت تمایل یادداشتی اضافه کنید..."></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                            <button type="submit" class="btn btn-success">تایید</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- مودال رد --}}
                                        <div class="modal fade" id="rejectModal{{ $row }}" tabindex="-1">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title">رد روز {{ $row }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form action="{{ route('mentor.attendance.reject', [$attendance->id, $row]) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body text-end">
                                                            <p>لطفاً دلیل رد را وارد کنید:</p>
                                                            <textarea name="reason" class="form-control" rows="3" required></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                            <button type="submit" class="btn btn-danger">رد</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @elseif(($day['status'] ?? '') == 'approved')
                                        <span class="text-success">
                                            <i class="bi bi-check-circle-fill"></i> تایید شده
                                            @if(!empty($day['mentor_note']))
                                                <br><small class="text-muted">{{ $day['mentor_note'] }}</small>
                                            @endif
                                        </span>
                                    @else
                                        <span class="text-danger">
                                            <i class="bi bi-x-circle-fill"></i> رد شده
                                            @if(!empty($day['reason']))
                                                <br><small class="text-danger">{{ $day['reason'] }}</small>
                                            @endif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هیچ رکوردی یافت نشد
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
            padding: 25px;
        }
    }
    @media (max-width: 991px) {
        .mentor-content-wrapper {
            margin-right: 0;
            padding: 15px;
        }
    }
    .table th, .table td {
        vertical-align: middle;
        text-align: center;
    }
    .card {
        border-radius: 15px;
    }
    .btn-group {
        gap: 5px;
    }
</style>