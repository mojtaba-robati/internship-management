@include('student.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp


<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">📝 گزارش کار روزانه</h2>
                        <p class="text-muted">
                            محل کارآموزی: {{ $internshipRequest->company_name ?? 'تعیین نشده' }}
                        </p>
                    </div>
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
                                <th style="width: 60px;">ردیف</th>
                                <th style="width: 100px;">تاریخ</th>
                                <th>گزارش کار</th>
                                <th style="width: 100px;">وضعیت</th>
                                <th style="width: 70px;">نمره</th>
                                <th style="width: 120px;">بازخورد</th>
                                <th style="width: 100px;">عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($row = 1; $row <= 40; $row++)
                                @php
                                    $report = $reports->get($row);
                                @endphp
                                <tr>
                                    <td class="fw-bold text-center">{{ $row }}</td>
                                    <td class="text-center">
                                        @if($report)
                                            <span dir="ltr">{{ Jalalian::fromDateTime($report->report_date)->format('Y/m/d') }}</span>
                                        @else
                                            <span class="text-muted">ثبت نشده</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($report)
                                            <div class="report-text-preview">
                                                {{ Str::limit($report->report_text, 100) }}
                                            </div>
                                        @else
                                            <span class="text-muted">گزارشی ثبت نشده</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($report)
                                            @if($report->status == 'pending')
                                                <span class="badge bg-warning text-dark">در انتظار</span>
                                            @elseif($report->status == 'approved')
                                                <span class="badge bg-success">تایید شده</span>
                                            @else
                                                <span class="badge bg-danger">رد شده</span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary">ثبت نشده</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($report && $report->grade)
                                            <span class="fw-bold text-primary">{{ $report->grade }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($report && $report->mentor_feedback)
                                            <span class="text-info" title="{{ $report->mentor_feedback }}">
                                                {{ Str::limit($report->mentor_feedback, 25) }}
                                            </span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if(!$report)
                                            <a href="{{ route('student.work-reports.create', $row) }}" class="btn btn-sm btn-primary">
                                                <i class="bi bi-plus-lg"></i> ثبت
                                            </a>
                                        @elseif($report->status == 'pending')
                                            <span class="text-warning">در انتظار بررسی</span>
                                        @else
                                            <span class="text-muted">قفل شده</span>
                                        @endif
                                    </td>
                                </tr>
                            @endfor
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
    .report-text-preview {
        max-width: 300px;
        white-space: normal;
        word-break: break-word;
        text-align: right;
    }
</style>