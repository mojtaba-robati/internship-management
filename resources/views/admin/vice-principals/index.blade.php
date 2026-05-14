<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ========== فایل‌های محلی (اولویت اول) ========== -->
    <!-- فونت شبنم محلی -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap محلی -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- Bootstrap Icons محلی -->
    @if(file_exists(public_path('assets/css/bootstrap-icons.min.css')))
        <link href="{{ asset('assets/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    @endif
    
    

    
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Shabnam', 'Vazirmatn', 'IRANSans', 'Tahoma', sans-serif;
            direction: rtl;
            text-align: right;
        }
        
        .content-wrapper {
            margin-right: 240px;
        }
        
        @media (min-width: 992px) {
            .content-wrapper {
                margin-right: 240px;
                padding: 25px;
            }
        }
        
        @media (max-width: 991px) {
            .content-wrapper {
                margin-right: 0;
                padding: 15px;
            }
        }
        
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        
        .btn-sm {
            padding: 5px 12px;
        }
        
        .alert {
            border-radius: 12px;
        }
        
        .card {
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
    </style>
</head>
<body>

@include('admin.components.sidebar')

<div class="content-wrapper">
    <div class="container-fluid p-4">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold">مدیریت معاونین آموزشی</h2>
                <p class="text-muted">لیست تمام معاونین آموزشی</p>
            </div>
            <a href="{{ route('vice-principals.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> افزودن معاون جدید
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>شماره موبایل</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vicePrincipals as $index => $vp)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $vp->first_name }}</td>
                                    <td>{{ $vp->last_name }}</td>
                                    <td dir="ltr">{{ $vp->phone }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ route('vice-principals.edit', $vp->id) }}" 
                                               class="btn btn-sm btn-warning" 
                                               title="ویرایش">
                                                <i class="bi bi-pencil-square"></i> ویرایش
                                            </a>
                                            <form action="{{ route('vice-principals.destroy', $vp->id) }}" 
                                                  method="POST"
                                                  onsubmit="return confirm('آیا از حذف معاون {{ $vp->first_name }} {{ $vp->last_name }} مطمئن هستید؟')"
                                                  style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                                    <i class="bi bi-trash3"></i> حذف
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-people fs-1 d-block mb-2"></i>
                                        هیچ معاونی ثبت نشده است
                                        <br>
                                        <small>برای افزودن معاون جدید، روی دکمه "افزودن معاون جدید" کلیک کنید.</small>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // برای active کردن خودکار منوها
    document.querySelectorAll('.sidebar-link').forEach(link => {
        if (link.href === window.location.href) {
            link.classList.add('active');
        }
    });
</script>

</body>
</html>