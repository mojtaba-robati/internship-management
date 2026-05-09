<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- ========== فایل‌های محلی (اولویت اول) ========== -->
    <!-- فونت شبنم محلی -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    <!-- Bootstrap محلی -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    
    <!-- ========== فایل‌های CDN (پشتیبان) ========== -->
    <!-- Bootstrap RTL از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    
    <!-- فونت وزیرمتن از CDN -->
    <link href="https://cdn.jsdelivr.net/npm/vazirmatn@33.0.1/Vazirmatn-font-face.css" rel="stylesheet">
    
    <!-- Bootstrap JS از CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            font-family: 'Shabnam', 'Vazirmatn', 'IRANSans', 'Tahoma', sans-serif;
            direction: rtl;
            text-align: right;
            background: #f5f6fa;
        }
        
        /* لینک‌ها */
        .sidebar-link {
            color: #ccc;
            padding: 12px 20px;
            font-size: 0.95rem;
            transition: 0.2s;
            text-align: right;
            text-decoration: none;
            display: block;
            color: #ffffff !important;
        }

        .sidebar-link:hover {
            background-color: #2c3034;
            color: #fff;
        }

        /* فقط یک خط نازک در سمت راست آیتم فعال */
        .sidebar-link.active {
            background-color: transparent;
            color: #fff !important;
            border-right: 2px solid #ffffff;
            font-weight: 500;
        }

        /* در دسکتاپ ثابت باشد */
        @media (min-width: 992px) {
            #adminSidebar {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: 240px;
                transform: none !important;
                visibility: visible !important;
            }

            .content-wrapper {
                margin-right: 240px;
            }

            .btn[data-bs-target="#adminSidebar"] {
                display: none;
            }
        }
        
        @media (max-width: 991px) {
            .content-wrapper {
                margin-right: 0;
            }
        }
    </style>
</head>
<body>

{{-- دکمه منوی موبایل --}}
<button class="btn btn-dark d-lg-none m-3"
        type="button"
        data-bs-toggle="offcanvas"
        data-bs-target="#adminSidebar">
    <i class="bi bi-list"></i> منو
</button>

{{-- سایدبار سمت راست --}}
<div class="offcanvas offcanvas-end offcanvas-lg text-bg-dark"
     tabindex="-1"
     id="adminSidebar">

    <div class="offcanvas-header border-bottom border-secondary text-end w-100">
        <div class="w-100 text-end">
            <h5 class="mb-0">
                <i class="bi bi-shield-lock-fill"></i> پنل مدیریت
            </h5>
            <small>سیستم کارآموزی</small>
        </div>

        <button type="button"
                class="btn-close btn-close-white d-lg-none"
                data-bs-dismiss="offcanvas">
        </button>
    </div>

    <div class="offcanvas-body p-0 text-end">

        <nav class="nav flex-column">

            <a href="{{ route('admin.dashboard') }}"
               class="nav-link sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>  داشبورد
            </a>

            <a href="{{ route('students.index') }}"
               class="nav-link sidebar-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>  مدیریت دانش آموزان
            </a>

            <a href="{{ route('students.create') }}"
               class="nav-link sidebar-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
                <i class="bi bi-person-plus-fill"></i>  افزودن دانش آموز
            </a>

            {{-- فقط ادمین اصلی میتونه مدیریت معاونین رو ببینه --}}
            @if(session('admin_role') == 'admin')
                <a href="{{ route('vice-principals.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('vice-principals.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i>  مدیریت معاونین
                </a>
            @endif

            {{-- لینک درخواست‌های کارآموزی برای ادمین و معاون --}}
            @if(session('admin_role') == 'admin' || session('admin_role') == 'vice_principal')
                <a href="{{ route('admin.internship-requests.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('admin.internship-requests.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope-paper-fill"></i> درخواست‌های کارآموزی
                </a>
            @endif

            <a href="#" class="nav-link sidebar-link">
                <i class="bi bi-graph-up"></i>  گزارش ها
            </a>

            <hr class="text-secondary mx-3 my-2">

            <a href="{{ route('logout') }}"
               class="nav-link sidebar-link text-danger">
                <i class="bi bi-box-arrow-left"></i>  خروج
            </a>

        </nav>

    </div>
</div>

<!-- Bootstrap Icons از CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script>
    // فعال کردن خودکار آیتم فعال در منو
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        const links = document.querySelectorAll('.sidebar-link');
        
        links.forEach(link => {
            const href = link.getAttribute('href');
            if (href && href !== '#' && currentUrl.includes(href)) {
                link.classList.add('active');
            }
        });
    });
</script>

</body>
</html>