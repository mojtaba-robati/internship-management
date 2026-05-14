@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">👨‍🏫 مدیریت مربیان ناظر</h2>
                <p class="text-muted">لیست تمام مربیان ناظر کارآموزی</p>
            </div>
            <a href="{{ route('mentors.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> افزودن مربی جدید
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>کد ملی</th>
                                <th>شماره موبایل</th>
                                <th>وضعیت</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mentors as $index => $mentor)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $mentor->first_name }}</td>
                                <td>{{ $mentor->last_name }}</td>
                                <td dir="ltr">{{ $mentor->national_code }}</td>
                                <td dir="ltr">{{ $mentor->phone }}</td>
                                <td>
                                    @if($mentor->status == 'active')
                                        <span class="badge bg-success">فعال</span>
                                    @else
                                        <span class="badge bg-danger">غیرفعال</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('mentors.edit', $mentor->id) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> ویرایش
                                    </a>
                                    <form action="{{ route('mentors.destroy', $mentor->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('حذف شود؟')">
                                            <i class="bi bi-trash3"></i> حذف
                                        </button>
                                    </form>
                                 </td
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                        هیچ مربی ثبت نشده است
                                    </td
                                </tr>
                            @endforelse
                        </tbody>
                    </table
                </div>
            </div>
        </div>

    </div>
</div>

<style>
    @media (min-width: 992px) {
        .content-wrapper { margin-right: 240px; padding: 25px; }
    }
    @media (max-width: 991px) {
        .content-wrapper { margin-right: 0; padding: 15px; }
    }
    .table td, .table th { vertical-align: middle; text-align: center; }
</style>    