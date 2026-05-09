@extends('admin.layout')

@section('title', 'داشبورد مدیریت')
@section('page_title', 'داشبورد')

@section('content')
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted mb-2">تعداد دانش‌آموزان</h6>
                    <h3 class="mb-0">0 نفر</h3>
                </div>
            </div>
        </div>  

        {{-- بعداً کارت‌های بیشتر اضافه می‌کنیم --}}
    </div>
@endsection


