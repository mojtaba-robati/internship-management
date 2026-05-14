@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">تخصیص مربی به دانش‌آموزان</h2>
                <p class="text-muted">یک مربی را به چندین دانش‌آموز تخصیص دهید</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('mentors.assign.store') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">انتخاب مربی <span class="text-danger">*</span></label>
                            <select name="mentor_id" class="form-select" required>
                                <option value="">انتخاب کنید</option>
                                @foreach($mentors as $mentor)
                                    <option value="{{ $mentor->id }}">
                                        {{ $mentor->first_name }} {{ $mentor->last_name }} - {{ $mentor->phone }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i>
                                دانش‌آموزان زیر را انتخاب کنید
                            </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-4">
                        <table class="table table-hover table-bordered align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th style="width: 40px;">
                                        <input type="checkbox" id="selectAll">
                                    </th>
                                    <th>نام</th>
                                    <th>نام خانوادگی</th>
                                    <th>کد ملی</th>
                                    <th>شرکت</th>
                                    <th>پایه</th>
                                    <th>رشته</th>
                                    <th>وضعیت تخصیص</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($students as $student)
                                    @php
                                        $assigned = isset($existingAssignments[$student->id]);
                                        $assignedMentor = $assigned ? $existingAssignments[$student->id] : null;
                                    @endphp
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="student_ids[]" value="{{ $student->id }}" 
                                               class="student-checkbox"
                                               {{ $assigned ? 'disabled' : '' }}>
                                    </td>
                                    <td class="fw-bold">{{ $student->first_name }}</td>
                                    <td class="fw-bold">{{ $student->last_name }}</td>
                                    <td dir="ltr">{{ $student->national_code }}</td>
                                    <td>{{ $student->company_name ?? '-' }}</td>
                                    <td>{{ $student->grade }}</td>
                                    <td>{{ $student->major }}</td>
                                    <td class="text-center">
                                        @if($assigned)
                                            <span class="badge bg-success">
                                                <i class="bi bi-check-circle-fill"></i>
                                                {{ $assignedMentor->first_name }} {{ $assignedMentor->last_name }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">
                                                <i class="bi bi-clock-history"></i> تخصیص داده نشده
                                            </span>
                                        @endif
                                    </td
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="bi bi-save"></i> تخصیص
                        </button>
                    </div>
                </form>
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
    table td, table th {
        vertical-align: middle;
        text-align: center;
    }
    .student-checkbox:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<script>
    document.getElementById('selectAll').addEventListener('change', function() {
        document.querySelectorAll('.student-checkbox:not(:disabled)').forEach(cb => cb.checked = this.checked);
    });
</script>