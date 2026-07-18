<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.internship-requests.index') }}" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">فیلتر بر اساس وضعیت</label>
                <select name="status" class="form-select">
                    <option value="">همه</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>در انتظار بررسی</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>تایید شده</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>رد شده</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">فیلتر بر اساس رشته</label>
                <select name="major" class="form-select">
                    <option value="">همه رشته‌ها</option>
                    <option value="شبکه و نرم افزار" {{ request('major') == 'شبکه و نرم افزار' ? 'selected' : '' }}>شبکه و نرم افزار</option>
                    <option value="تاسیسات" {{ request('major') == 'تاسیسات' ? 'selected' : '' }}>تاسیسات</option>
                    <option value="مکانیک خودرو" {{ request('major') == 'مکانیک خودرو' ? 'selected' : '' }}>مکانیک خودرو</option>
                    <option value="الکتروتکنیک" {{ request('major') == 'الکتروتکنیک' ? 'selected' : '' }}>الکتروتکنیک</option>
                    <option value="تاسیسات مکانیکی" {{ request('major') == 'تاسیسات مکانیکی' ? 'selected' : '' }}>تاسیسات مکانیکی</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">فیلتر بر اساس پایه</label>
                <select name="grade" class="form-select">
                    <option value="">همه پایه‌ها</option>
                    <option value="دهم" {{ request('grade') == 'دهم' ? 'selected' : '' }}>پایه دهم</option>
                    <option value="یازدهم" {{ request('grade') == 'یازدهم' ? 'selected' : '' }}>پایه یازدهم</option>
                    <option value="دوازدهم" {{ request('grade') == 'دوازدهم' ? 'selected' : '' }}>پایه دوازدهم</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label class="form-label">جستجو در نام</label>
                <input type="text" name="search" class="form-control" placeholder="نام دانش‌آموز..." value="{{ request('search') }}">
            </div>
            
            <div class="col-md-3">
                <label class="form-label">جستجو در کد ملی</label>
                <input type="text" name="national_code" class="form-control" placeholder="کد ملی..." value="{{ request('national_code') }}">
            </div>
            
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-search"></i> فیلتر
                </button>
                <a href="{{ route('admin.internship-requests.index') }}" class="btn btn-secondary flex-grow-1">
                    <i class="bi bi-eraser"></i> پاک کردن
                </a>
            </div>
        </form>
        
        {{-- نمایش فیلترهای فعال --}}
        @php
            $hasFilters = request('status') || request('major') || request('grade') || request('search') || request('national_code');
        @endphp
        
        @if($hasFilters)
            <div class="mt-3 pt-2 border-top">
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <span class="text-muted small">فیلترهای فعال:</span>
                    
                    @if(request('status'))
                        <span class="badge bg-primary">
                            وضعیت: 
                            @if(request('status') == 'pending')در انتظار
                            @elseif(request('status') == 'approved')تایید شده
                            @elseرد شده@endif
                            <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" class="text-white ms-1 text-decoration-none">✕</a>
                        </span>
                    @endif
                    
                    @if(request('major'))
                        <span class="badge bg-info">
                            رشته: {{ request('major') }}
                            <a href="{{ request()->fullUrlWithQuery(['major' => null]) }}" class="text-white ms-1 text-decoration-none">✕</a>
                        </span>
                    @endif
                    
                    @if(request('grade'))
                        <span class="badge bg-success">
                            پایه: {{ request('grade') }}
                            <a href="{{ request()->fullUrlWithQuery(['grade' => null]) }}" class="text-white ms-1 text-decoration-none">✕</a>
                        </span>
                    @endif
                    
                    @if(request('search'))
                        <span class="badge bg-secondary">
                            نام: {{ request('search') }}
                            <a href="{{ request()->fullUrlWithQuery(['search' => null]) }}" class="text-white ms-1 text-decoration-none">✕</a>
                        </span>
                    @endif
                    
                    @if(request('national_code'))
                        <span class="badge bg-dark">
                            کد ملی: {{ request('national_code') }}
                            <a href="{{ request()->fullUrlWithQuery(['national_code' => null]) }}" class="text-white ms-1 text-decoration-none">✕</a>
                        </span>
                    @endif
                    
                    <a href="{{ route('admin.internship-requests.index') }}" class="btn btn-sm btn-link text-danger p-0">
                        <i class="bi bi-trash3"></i> حذف همه
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>