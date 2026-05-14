@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">📋 دفترچه حضور غیاب</h2>
                        <p class="text-muted">
                            دانش‌آموز: {{ $student->first_name }} {{ $student->last_name }} |
                            شرکت: {{ $internshipRequest->company_name }}
                        </p>
                    </div>
                    <a href="{{ route('admin.attendance.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ردیف</th>
                                <th>تاریخ</th>
                                <th>ورود</th>
                                <th>خروج</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($days as $row => $day)
                            <tr>
                                <td class="fw-bold">{{ $row }}</td>
                                <td dir="ltr">{{ $day['date'] ?? '-' }}</td>
                                <td dir="ltr">{{ $day['check_in'] ?? 'ثبت نشده' }}</td>
                                <td dir="ltr">{{ $day['check_out'] ?? 'ثبت نشده' }}</td>
                                <td>
                                    @if($day['status'] == 'pending')
                                        <span class="badge bg-warning text-dark">در انتظار</span>
                                    @elseif($day['status'] == 'approved')
                                        <span class="badge bg-success">تایید شده</span>
                                    @else
                                        <span class="badge bg-danger">رد شده</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <form action="{{ route('admin.attendance.approve', [$attendance->id, $row]) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success" {{ $day['status'] == 'approved' ? 'disabled' : '' }}>
                                                <i class="bi bi-check-lg"></i> تایید
                                            </button>
                                        </form>
                                        <button type="button" 
                                                class="btn btn-sm btn-danger" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#rejectModal{{ $row }}"
                                                {{ $day['status'] == 'rejected' ? 'disabled' : '' }}>
                                            <i class="bi bi-x-lg"></i> رد
                                        </button>
                                    </div>
                                    
                                    {{-- مودال رد --}}
                                    <div class="modal fade" id="rejectModal{{ $row }}" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title">رد روز {{ $row }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('admin.attendance.reject', [$attendance->id, $row]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <p>لطفاً دلیل رد را وارد کنید:</p>
                                                        <textarea name="reason" class="form-control" rows="3" required></textarea>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">انصراف</button>
                                                        <button type="submit" class="btn btn-danger">تأیید رد</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
    .table td, .table th {
        vertical-align: middle;
    }
    .btn-group {
        gap: 5px;
    }
</style>