<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <p class="text-muted mb-0">
            <i class="bi bi-people-fill text-primary"></i>
            تعداد دانش آموزان: <strong class="fs-5">{{ $count }}</strong>
            @if($selectedGrade)
                <span class="badge bg-primary ms-2">پایه {{ $selectedGrade }}</span>
            @endif
            @if($searchTerm ?? '')
                <span class="badge bg-info ms-2">جستجو: {{ $searchTerm }}</span>
            @endif
        </p>
    </div>
    <div>
        <button type="button" class="btn btn-sm btn-outline-success" onclick="window.print()">
            <i class="bi bi-printer"></i> چاپ
        </button>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th class="text-center">#</th>
                <th class="text-center">نام</th>
                <th class="text-center">نام خانوادگی</th>
                <th class="text-center">تلفن</th>
                <th class="text-center">کد ملی</th>
                <th class="text-center">رشته</th>
                <th class="text-center">پایه</th>
                <th class="text-center">وضعیت</th>
                <th class="text-center">عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                @php
                    // بررسی وضعیت غیرفعال
                    $isInactive = isset($student->is_active) && $student->is_active == 0;
                @endphp
                <tr class="{{ $isInactive ? 'table-danger' : '' }}">
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-bold">{{ $student->first_name }}</td>
                    <td class="fw-bold">{{ $student->last_name }}</td>
                    <td dir="ltr">{{ $student->phone }}</td>
                    <td dir="ltr">{{ $student->national_code }}</td>
                    <td>
                        <span class="badge bg-info px-3 py-2">
                            <i class="bi bi-book"></i> {{ $student->major }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-success px-3 py-2">
                            <i class="bi bi-star"></i> {{ $student->grade }}
                        </span>
                    </td>
                    <td>
                        @if($student->is_active == 1)
                            <span class="badge bg-success">فعال</span>
                        @else
                            <span class="badge bg-danger">غیرفعال</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('students.edit', $student->id) }}" 
                               class="btn btn-sm btn-warning" 
                               title="ویرایش">
                                <i class="bi bi-pencil-square"></i> ویرایش
                            </a>
                            
                            <form action="{{ route('students.destroy', $student->id) }}" 
                                  method="POST" 
                                  style="display: inline;"
                                  id="delete-form-{{ $student->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        title="حذف"
                                        onclick="confirmDelete({{ $student->id }}, '{{ $student->first_name }} {{ $student->last_name }}')">
                                    <i class="bi bi-trash3"></i> حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center text-muted py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        @if($searchTerm ?? '')
                            نتیجه‌ای برای جستجوی "{{ $searchTerm }}" یافت نشد
                        @elseif($selectedGrade)
                            دانش آموزی برای پایه {{ $selectedGrade }} یافت نشد
                        @else
                            هیچ دانش آموزی ثبت نشده است
                        @endif
                        <div class="mt-3">
                            <a href="{{ route('students.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-lg"></i> افزودن دانش آموز جدید
                            </a>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
    function confirmDelete(id, name) {
        if (confirm('آیا از حذف دانش‌آموز ' + name + ' مطمئن هستید؟')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>

<style scoped>
    .table th, .table td {
        vertical-align: middle;
        padding: 12px 8px;
    }
    
    .badge {
        font-size: 12px;
        font-weight: 500;
    }
    
    .btn-sm {
        padding: 5px 12px;
        font-size: 12px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(13, 110, 253, 0.05);
        transition: all 0.2s ease;
    }
    
    /* استایل ردیف غیرفعال */
    .table-danger {
        background-color: #f8d7da !important;
        border-color: #f5c6cb !important;
    }
    
    .table-danger td {
        background-color: #f8d7da !important;
    }
    
    .table-danger:hover {
        background-color: #f5c6cb !important;
    }
    
    .table-danger:hover td {
        background-color: #f5c6cb !important;
    }
    
    @media (max-width: 768px) {
        .btn-sm {
            padding: 4px 8px;
            font-size: 11px;
        }
        
        .badge {
            font-size: 10px;
            padding: 4px 8px;
        }
    }
</style>