@include('mentor.components.sidebar')

<div class="mentor-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold"> ثبت نمره نهایی</h2>
                        <p class="text-muted">
                            دانش‌آموز: {{ $student->first_name }} {{ $student->last_name }} |
                            محل کارآموزی: {{ $internshipRequest->company_name ?? '-' }}
                        </p>
                    </div>
                    <a href="{{ route('mentor.grading.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت
                    </a>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <form action="{{ route('mentor.grading.store', $student->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label">نمره نهایی کارآموزی <span class="text-danger">*</span></label>
                        <input type="number" name="grade" class="form-control" step="0.5" min="0" max="15" 
                               value="{{ $finalGrade->grade ?? '' }}" required placeholder="0 تا 15">
                        <small class="text-muted">حداکثر 15</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">یادداشت مربی (اختیاری)</label>
                        <textarea name="mentor_note" class="form-control" rows="4" placeholder="یادداشت خود را وارد کنید...">{{ $finalGrade->mentor_note ?? '' }}</textarea>
                    </div>
                    
                    <div class="text-end">
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save"></i> ثبت نمره نهایی
                        </button>
                        <a href="{{ route('mentor.grading.index') }}" class="btn btn-secondary px-4">
                            <i class="bi bi-x-circle"></i> انصراف
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<style>
    @media (min-width: 992px) {
        .mentor-content-wrapper { margin-right: 260px; min-height: 100vh; }
    }
    @media (max-width: 991px) { .mentor-content-wrapper { margin-right: 0; } }
</style>