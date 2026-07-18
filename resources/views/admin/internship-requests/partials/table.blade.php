@php
    use Morilog\Jalali\Jalalian;
@endphp

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>نام دانش‌آموز</th>
                        <th>کد ملی</th>
                        <th>نام شرکت</th>
                        <th>پایه</th>
                        <th>تاریخ درخواست</th>
                        <th>وضعیت</th>
                        <th>دلیل رد</th>
                        <th>عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $index => $req)
                        @php
                            $jalaliDate = $req->created_at ? Jalalian::fromDateTime($req->created_at)->format('Y/m/d H:i') : '-';
                        @endphp
                    <tr>
                        <td>{{ ($requests->currentPage() - 1) * $requests->perPage() + $index + 1 }}</td>
                        <td class="fw-bold">
                            @if($req->student)
                                {{ $req->student->first_name }} {{ $req->student->last_name }}
                            @else
                                <span class="text-danger">کاربر حذف شده</span>
                            @endif
                        </td>
                        <td dir="ltr">
                            @if($req->student)
                                {{ $req->student->national_code }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $req->company_name ?? '-' }}</td>
                        <td>
                            @if($req->student)
                                <span class="badge bg-secondary">{{ $req->student->grade ?? '-' }}</span>
                            @else
                                <span class="badge bg-secondary">-</span>
                            @endif
                        </td>
                        <td dir="ltr">{{ $jalaliDate }}</td>
                        <td>
                            @if($req->status == 'pending')
                                <span class="badge bg-warning text-dark">در انتظار</span>
                            @elseif($req->status == 'approved')
                                <span class="badge bg-success">تایید شده</span>
                            @else
                                <span class="badge bg-danger">رد شده</span>
                            @endif
                        </td>
                        <td>
                            @if($req->status == 'rejected' && $req->admin_notes)
                                <span class="text-danger" title="{{ $req->admin_notes }}">
                                    {{ Str::limit($req->admin_notes, 30) }}
                                </span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.internship-requests.show', $req->id) }}" 
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> مشاهده
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center text-muted py-5">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            هیچ درخواستی با این فیلترها یافت نشد
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($requests->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $requests->appends(request()->query())->links() }}
    </div>
@endif  