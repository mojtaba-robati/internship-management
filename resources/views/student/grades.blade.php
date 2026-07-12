@include('student.components.sidebar')

@php
    use Morilog\Jalali\Jalalian;
@endphp

<div class="student-content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="row mb-4">
            <div class="col">
                <h2 class="fw-bold">نمرات من</h2>
                <p class="text-muted">مشاهده نمرات کارآموزی شما</p>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card border-0 bg-light p-4 text-center">
                            @if($finalGrade && $finalGrade->grade !== null)
                                <h5 class="text-muted mb-3">نمره نهایی کارآموزی</h5>
                                <h2 class="fw-bold text-primary" style="font-size: 4rem;">
                                    {{ number_format($finalGrade->grade, 1) }}
                                </h2>
                                <span class="badge bg-success fs-6">از 15 نمره</span>
                                
                                @if($finalGrade->mentor_note)
                                    <div class="mt-4">
                                        <p class="text-muted">یادداشت مربی:</p>
                                        <p class="fw-bold">{{ $finalGrade->mentor_note }}</p>
                                    </div>
                                @endif
                                
                                <div class="mt-3">
                                    @php
                                        $jalaliDate = Jalalian::fromDateTime($finalGrade->created_at)->format('Y/m/d');
                                    @endphp
                                    <small class="text-muted">تاریخ ثبت: {{ $jalaliDate }}</small>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    <h6>هنوز نمره‌ای برای شما ثبت نشده است.</h6>
                                    <p class="mb-0">پس از پایان دوره کارآموزی، نمره شما توسط مربی ناظر ثبت خواهد شد.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                
                {{-- اطلاعات دانش‌آموز --}}
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card border-0">
                            <div class="card-body">
                                <h6 class="fw-bold">اطلاعات کارآموزی</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>نام:</strong> {{ $student->first_name }} {{ $student->last_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>رشته:</strong> {{ $student->major }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>پایه:</strong> {{ $student->grade }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>کد ملی:</strong> {{ $student->national_code }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    .card {
        border-radius: 15px;
    }
    .bg-light {
        background-color: #f8f9fa !important;
    }
</style>