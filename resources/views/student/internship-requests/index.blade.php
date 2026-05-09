@include('student.components.sidebar')

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">درخواست‌های کارآموزی</h2>
                <p class="text-muted">لیست درخواست‌های شما و وضعیت آنها</p>
            </div>
            
            {{-- فقط اگر درخواست تایید شده یا pending نداشته باشه، دکمه نمایش داده بشه --}}
            @if(!$hasApprovedRequest && !$hasPendingRequest)
                <a href="{{ route('student.internship-requests.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> درخواست جدید
                </a>
            @else
                <button class="btn btn-secondary" disabled>
                    <i class="bi bi-plus-lg"></i> درخواست جدید (غیرفعال)
                </button>
            @endif
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

        {{-- پیام وضعیت --}}
        @if($hasApprovedRequest)
            <div class="alert alert-success">
                <i class="bi bi-check-circle-fill"></i> 
                <strong>درخواست شما تایید شده است!</strong> شما نمی‌توانید درخواست جدید ثبت کنید.
            </div>
        @elseif($hasPendingRequest)
            <div class="alert alert-warning">
                <i class="bi bi-clock-history"></i> 
                <strong>درخواست شما در حال بررسی است.</strong> لطفاً منتظر بمانید تا نتیجه اعلام شود.
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>نام شرکت</th>
                                <th>تاریخ درخواست</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requests as $index => $req)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $req->company_name }}</td>
                                <td>{{ $req->created_at ? $req->created_at->format('Y/m/d') : '-' }}</td>
                                <td>
                                    @if($req->status == 'pending')
                                        <span class="badge bg-warning text-dark">🕐 در انتظار بررسی</span>
                                    @elseif($req->status == 'approved')
                                        <span class="badge bg-success">✅ تایید شده</span>
                                    @else
                                        <span class="badge bg-danger">❌ رد شده</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('student.internship-requests.show', $req->id) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> مشاهده
                                    </a>
                                    @if($req->status == 'rejected')
                                        <a href="{{ route('student.internship-requests.create') }}" 
                                           class="btn btn-sm btn-primary">
                                            <i class="bi bi-plus-lg"></i> درخواست جدید
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هیچ درخواستی ثبت نشده است
                                        <br>
                                        <small>برای ثبت درخواست کارآموزی، روی دکمه "درخواست جدید" کلیک کنید.</small>
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
    
    .table th, .table td {
        vertical-align: middle;
    }
    
    .badge {
        font-size: 12px;
        padding: 5px 10px;
    }
    
    .alert {
        border-radius: 12px;
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">