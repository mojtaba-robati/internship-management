<p class="text-muted mb-3">
    تعداد دانش آموزان: <strong>{{ $count }}</strong>
    @if($selectedGrade)
        <span class="text-primary">(پایه {{ $selectedGrade }})</span>
    @endif
    @if($searchTerm ?? '')
        <span class="text-info">(جستجو: {{ $searchTerm }})</span>
    @endif
</p>

<div class="table-responsive">
    <table class="table table-hover table-bordered align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>نام</th>
                <th>نام خانوادگی</th>
                <th>تلفن</th>
                <th>کد ملی</th>
                <th>رشته</th>
                <th>پایه</th>
                <th>عملیات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->last_name }}</td>
                    <td>{{ $student->phone }}</td>
                    <td>{{ $student->national_code }}</td>
                    <td><span class="badge bg-info">{{ $student->major }}</span></td>
                    <td><span class="badge bg-success">{{ $student->grade }}</span></td>
                    <td class="text-center">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('students.edit', $student->id) }}" 
                               class="btn btn-sm btn-warning" title="ویرایش">
                                <i class="bi bi-pencil-square"></i> ویرایش
                            </a>
                            
                            <form action="{{ route('students.destroy', $student->id) }}" 
                                  method="POST" 
                                  style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-danger" 
                                        title="حذف"
                                        onclick="return confirm('آیا از حذف دانش‌آموز {{ $student->first_name }} {{ $student->last_name }} مطمئن هستید؟')">
                                    <i class="bi bi-trash3"></i> حذف
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        @if($searchTerm ?? '')
                            نتیجه‌ای برای جستجوی "{{ $searchTerm }}" یافت نشد
                        @elseif($selectedGrade)
                            دانش آموزی برای پایه {{ $selectedGrade }} یافت نشد
                        @else
                            هیچ دانش آموزی ثبت نشده است
                        @endif
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>