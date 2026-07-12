@include('mentor.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">

        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold">📝 گزارش‌های کار روزانه</h2>
                        <p class="text-muted">
                            دانش‌آموز: {{ $student->first_name }} {{ $student->last_name }} |
                            محل کارآموزی: {{ $internshipRequest->company_name ?? '-' }}
                        </p>
                    </div>

                    <a href="{{ route('mentor.work-reports.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i>
                        بازگشت
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-0">

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle mb-0">

                        <thead class="table-dark">
                            <tr>
                                <th>ردیف</th>
                                <th>تاریخ گزارش</th>
                                <th>گزارش کار</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($reports as $report)

                                @php
                                    $jalaliDate = $report->report_date
                                        ? Jalalian::fromDateTime($report->report_date)->format('Y/m/d')
                                        : '-';
                                @endphp

                                <tr>

                                    <td class="fw-bold text-center">
                                        {{ $report->row_number }}
                                    </td>

                                    <td class="text-center" dir="ltr">
                                        {{ $jalaliDate }}
                                    </td>

                                    <td class="text-end"
                                        style="max-width:350px;white-space:normal;word-break:break-word;">
                                        {{ $report->report_text }}
                                    </td>

                                    <td class="text-center">

                                        @if($report->status == 'pending')
                                            <span class="badge bg-warning text-dark">
                                                در انتظار
                                            </span>

                                        @elseif($report->status == 'approved')
                                            <span class="badge bg-success">
                                                تایید شده
                                            </span>

                                        @else
                                            <span class="badge bg-danger">
                                                رد شده
                                            </span>
                                        @endif

                                    </td>

                                    <td class="text-center">

                                        @if($report->status == 'pending')

                                            <button type="button"
                                                    class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#approveModal{{ $report->id }}">

                                                <i class="bi bi-check-lg"></i>
                                                تایید

                                            </button>

                                        @else

                                            <span class="text-muted">
                                                بررسی شده
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">

                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                                        هیچ گزارشی ثبت نشده است

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


{{-- مودال تایید --}}
@foreach($reports as $report)

<div class="modal fade"
     id="approveModal{{ $report->id }}"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header bg-success text-white">

                <h5 class="modal-title">
                    <i class="bi bi-check-circle"></i>
                    تایید گزارش کار
                </h5>

                <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form action="{{ route('mentor.work-reports.approve', $report->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="modal-body">

                    <p>
                        آیا از تایید این گزارش کار مطمئن هستید؟
                    </p>

                    <div class="mb-3">

                        <label class="form-label">
                            بازخورد (اختیاری)
                        </label>

                        <textarea name="mentor_feedback"
                                  class="form-control"
                                  rows="3"
                                  placeholder="بازخورد خود را وارد کنید..."></textarea>

                        <small class="text-muted">
                            اختیاری
                        </small>

                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal">

                        انصراف

                    </button>

                    <button type="submit"
                            class="btn btn-success">

                        تایید

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endforeach


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

    .table td,
    .table th {

        vertical-align: middle;
        text-align: center;

    }

</style>