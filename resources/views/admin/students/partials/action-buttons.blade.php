<div class="d-flex gap-2 justify-content-center">
    <a href="{{ route('students.edit', $student->id) }}" 
       class="btn btn-sm btn-warning" title="ویرایش">
        <i class="bi bi-pencil-square"></i> ویرایش
    </a>
    
    <button type="button" 
            class="btn btn-sm btn-danger" 
            data-bs-toggle="modal" 
            data-bs-target="#deleteModal"
            data-id="{{ $student->id }}"
            data-name="{{ $student->first_name }} {{ $student->last_name }}"
            title="حذف">
        <i class="bi bi-trash3"></i> حذف
    </button>
</div>