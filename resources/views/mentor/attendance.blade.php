<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>دفترچه حضور غیاب</title>
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Shabnam', 'Vazirmatn', sans-serif;
            background: #f5f6fa;
        }
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
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        .card {
            border-radius: 15px;
        }
    </style>
</head>
<body>

@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">📋 دفترچه حضور غیاب</h2>
                        <p class="text-muted">
                            دانش‌آموز: {{ $student->first_name }} {{ $student->last_name }} |
                            شرکت: {{ $internshipRequest->company_name ?? '-' }}
                        </p>
                    </div>
                    <a href="{{ route('mentor.students.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت به لیست
                    </a>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>ردیف</th>
                                <th>تاریخ</th>
                                <th>ساعت ورود</th>
                                <th>ساعت خروج</th>
                                <th>وضعیت</th>
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
                                    @if($day['status'] == 'pending')
                                        <span class="badge bg-warning text-dark">در انتظار</span>
                                    @elseif($day['status'] == 'approved')
                                        <span class="badge bg-success">تایید شده</span>
                                    @else
                                        <span class="badge bg-danger">رد شده</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-5">
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

</body>
</html>