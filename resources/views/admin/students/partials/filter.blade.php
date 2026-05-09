{{-- باکس جستجو و فیلتر --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('students.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="text" 
                               name="search" 
                               class="form-control form-control-lg" 
                               placeholder="جستجو بر اساس نام، نام خانوادگی، تلفن، کد ملی..."
                               value="{{ $searchTerm ?? '' }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> جستجو
                        </button>
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="grade" class="form-select form-select-lg">
                        <option value="">همه پایه‌ها</option>
                        <option value="دهم" {{ request('grade') == 'دهم' ? 'selected' : '' }}>پایه دهم</option>
                        <option value="یازدهم" {{ request('grade') == 'یازدهم' ? 'selected' : '' }}>پایه یازدهم</option>
                        <option value="دوازدهم" {{ request('grade') == 'دوازدهم' ? 'selected' : '' }}>پایه دوازدهم</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="major" class="form-select form-select-lg">
                        <option value="">همه رشته‌ها</option>
                        <option value="کامپیوتر" {{ request('major') == 'کامپیوتر' ? 'selected' : '' }}>کامپیوتر</option>
                        <option value="تاسیسات" {{ request('major') == 'تاسیسات' ? 'selected' : '' }}>تاسیسات</option>
                        <option value="مکانیک" {{ request('major') == 'مکانیک' ? 'selected' : '' }}>مکانیک</option>
                        <option value="برق" {{ request('major') == 'برق' ? 'selected' : '' }}>برق</option>
                        <option value="معماری" {{ request('major') == 'معماری' ? 'selected' : '' }}>معماری</option>
                        <option value="گرافیک" {{ request('major') == 'گرافیک' ? 'selected' : '' }}>گرافیک</option>
                        <option value="حسابداری" {{ request('major') == 'حسابداری' ? 'selected' : '' }}>حسابداری</option>
                    </select>
                </div>
                <div class="col-md-2">
                    @if(request()->has('search') || request()->has('grade') || request()->has('major'))
                        <a href="{{ route('students.index') }}" class="btn btn-outline-danger w-100 btn-lg">
                            <i class="bi bi-eraser"></i> پاک کردن
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

{{-- نمایش فیلترهای فعال --}}
@if(request()->has('search') || request()->has('grade') || request()->has('major'))
<div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
    <i class="bi bi-funnel-fill"></i> <strong>فیلترهای فعال:</strong>
    @if(request('search'))
        <span class="badge bg-primary ms-1">جستجو: {{ request('search') }}</span>
    @endif
    @if(request('grade'))
        <span class="badge bg-success ms-1">پایه: {{ request('grade') }}</span>
    @endif
    @if(request('major'))
        <span class="badge bg-warning ms-1">رشته: {{ request('major') }}</span>
    @endif
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif