<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- ========== فایل‌های محلی ========== -->
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    <style>
        body {
            font-family: 'Shabnam', 'Vazirmatn', 'IRANSans', 'Tahoma', sans-serif;
            direction: rtl;
            text-align: right;
            background: #f5f6fa;
        }
        
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

        .sidebar-link.active {
            background-color: transparent;
            color: #fff !important;
            border-right: 2px solid #ffffff;
            font-weight: 500;
        }

        @media (min-width: 992px) {
            #studentSidebar {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: 240px;
                transform: none !important;
                visibility: visible !important;
            }
            .student-content-wrapper {
                margin-right: 240px;
            }
            .btn[data-bs-target="#studentSidebar"] {
                display: none;
            }
        }
        
        @media (max-width: 991px) {
            .student-content-wrapper {
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
        data-bs-target="#studentSidebar">
    <i class="bi bi-list"></i> منو
</button>

{{-- سایدبار سمت راست --}}
<div class="offcanvas offcanvas-end offcanvas-lg text-bg-dark"
     tabindex="-1"
     id="studentSidebar">

    <div class="offcanvas-header border-bottom border-secondary text-end w-100">
        <div class="w-100 text-end">
            <h5 class="mb-0">
                <i class="bi bi-mortarboard-fill"></i> پنل دانش آموز
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

            <a href="{{ route('student.dashboard') }}"
               class="nav-link sidebar-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>  داشبورد
            </a>

            <a href="{{ route('student.profile') }}"
               class="nav-link sidebar-link {{ request()->routeIs('student.profile') ? 'active' : '' }}">
                <i class="bi bi-person-circle"></i>  پروفایل من
            </a>

            <a href="{{ route('student.internship-requests.index') }}"
               class="nav-link sidebar-link {{ request()->routeIs('student.internship-requests.*') ? 'active' : '' }}">
                <i class="bi bi-envelope-paper-fill"></i>  درخواست کارآموزی
            </a>

            <a href="{{ route('student.attendance.index') }}"
               class="nav-link sidebar-link {{ request()->routeIs('student.attendance.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill"></i>  دفترچه حضور غیاب
            </a>

            <a href="{{ route('student.work-reports.index') }}"
               class="nav-link sidebar-link {{ request()->routeIs('student.work-reports.*') ? 'active' : '' }}">
                <i class="bi bi-file-text-fill"></i>  گزارش کار
            </a>

            {{-- ========== نمرات من (اضافه شد) ========== --}}
            <a href="{{ route('student.grades.index') }}"
               class="nav-link sidebar-link {{ request()->routeIs('student.grades.*') ? 'active' : '' }}">
                <i class="bi bi-star-fill"></i>  نمرات من
            </a>

            <a href="#" class="nav-link sidebar-link">
                <i class="bi bi-book-fill"></i>  دوره های من
            </a>

            <hr class="text-secondary mx-3 my-2">

            <a href="{{ route('student.logout') }}"
               class="nav-link sidebar-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i>  خروج
            </a>

            <form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

        </nav>

    </div>
</div>

<script>
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