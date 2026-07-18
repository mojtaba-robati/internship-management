@include('admin.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">📋 لیست تخصیص‌های مربی به دانش‌آموز</h2>
                <p class="text-muted">نمایش گروه‌بندی شده بر اساس مربی</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @php
            // گروه‌بندی تخصیص‌ها بر اساس مربی
            $groupedAssignments = [];
            foreach($assignments as $assign) {
                $mentorKey = $assign->mentor_id;
                if (!isset($groupedAssignments[$mentorKey])) {
                    $groupedAssignments[$mentorKey] = [
                        'mentor_name' => $assign->mentor_name . ' ' . $assign->mentor_lastname,
                        'mentor_phone' => $assign->mentor_phone,
                        'students' => []
                    ];
                }
                $groupedAssignments[$mentorKey]['students'][] = $assign;
            }
        @endphp

        @forelse($groupedAssignments as $mentorId => $group)
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <i class="bi bi-person-badge-fill"></i>
                            <strong>مربی: {{ $group['mentor_name'] }}</strong>
                            <span class="mx-2">|</span>
                            <i class="bi bi-telephone-fill"></i>
                            <span dir="ltr">{{ $group['mentor_phone'] }}</span>
                        </div>
                        <span class="badge bg-light text-dark">
                            تعداد: {{ count($group['students']) }} دانش‌آموز
                        </span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered align-middle text-center mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>نام دانش‌آموز</th>
                                    <th>نام خانوادگی</th>
                                    <th>کد ملی</th>
                                    <th>محل کارآموزی</th>
                                    <th>تاریخ تخصیص</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($group['students'] as $index => $assign)
                                    @php
                                        $jalaliDate = $assign->created_at ? Jalalian::fromDateTime($assign->created_at)->format('Y/m/d') : '-';
                                    @endphp
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="fw-bold">{{ $assign->student_name }}</td>
                                    <td class="fw-bold">{{ $assign->student_lastname }}</td>
                                    <td dir="ltr">{{ $assign->national_code }}</td>
                                    <td>{{ $assign->company_name ?? '-' }}</td>
                                    <td dir="ltr">{{ $jalaliDate }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('mentors.assignment.destroy', $assign->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">
                                                <i class="bi bi-trash3"></i> حذف
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @empty
            <div class="card shadow-sm border-0">
                <div class="card-body text-center text-muted py-5">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    هیچ تخصیصی یافت نشد
                </div>
            </div>
        @endforelse

    </div>
</div>

<style>
    @media (min-width: 992px) {
        .content-wrapper { margin-right: 240px; padding: 25px; }
    }
    @media (max-width: 991px) {
        .content-wrapper { margin-right: 0; padding: 15px; }
    }
    .table td, .table th {
        vertical-align: middle;
        text-align: center;
    }
    .card-header {
        border-radius: 12px 12px 0 0;
    }
</style>