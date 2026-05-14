@include('student.components.sidebar')

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">پروفایل من</h2>
                <p class="text-muted">مشاهده اطلاعات شخصی شما</p>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-person-badge text-primary"></i> اطلاعات شخصی
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            @php
                                // اطلاعات رو توی متغیر بریزیم برای دسترسی سریعتر
                                $info = [
                                    'نام' => $student->first_name,
                                    'نام خانوادگی' => $student->last_name,
                                    'شماره موبایل' => $student->phone,
                                    'کد ملی' => $student->national_code,
                                    'رشته تحصیلی' => $student->major,
                                    'پایه تحصیلی' => $student->grade,
                                    'وضعیت حساب' => $student->is_active == 1 ? '<span class="badge bg-success">فعال</span>' : '<span class="badge bg-danger">غیرفعال</span>',
                                    'تاریخ ثبت نام' => $student->created_at ? $student->created_at->format('Y/m/d') : '-'
                                ];
                            @endphp
                            
                            @foreach($info as $label => $value)
                            <tr>
                                <th style="width: 200px; background-color: #f8f9fa;">{{ $label }}</th>
                                <td>{!! $value !!}</td>
                            </tr>
                            @endforeach
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
    
    .table th {
        font-weight: 600;
        width: 200px;
    }
    
    .table td {
        font-weight: 500;
    }
</style>

