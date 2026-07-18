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
            padding: 12px 20px;
            font-size: 0.95rem;
            transition: 0.2s;
            text-align: right;
            text-decoration: none;
            display: block;
            color: #ffffff !important;
            cursor: pointer;
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
        
        /* زیرمنو */
        .submenu {
            padding-right: 30px;
            display: none;
        }
        .submenu.show {
            display: block;
        }
        .submenu .sidebar-link {
            font-size: 0.85rem;
            padding: 8px 20px;
        }
        
        /* منوی اصلی با آیکون */
        .menu-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .dropdown-icon {
            transition: transform 0.3s;
        }
        .dropdown-icon.rotated {
            transform: rotate(180deg);
        }
        .menu-title {
            flex: 1;
        }

        @media (min-width: 992px) {
            #adminSidebar {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: 260px;
                transform: none !important;
                visibility: visible !important;
                background-color: #1a1a2e !important;
            }
            .content-wrapper {
                margin-right: 260px;
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
        
        .offcanvas-header {
            background-color: #1a1a2e;
        }
        .offcanvas-header h5 {
            color: #fff;
        }
        .offcanvas-header small {
            color: #aaa;
        }
        .btn-close-white {
            filter: brightness(0) invert(1);
        }
        .border-secondary {
            border-color: #2d2d4e !important;
        }
        .sidebar-link.text-danger {
            color: #ff6b6b !important;
        }
        .sidebar-link.text-danger:hover {
            background-color: #2d2d4e !important;
            color: #ff8888 !important;
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
     id="adminSidebar"
     style="background-color: #1a1a2e;">

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

            <!-- داشبورد -->
            <a href="{{ route('admin.dashboard') }}"
               class="nav-link sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>  داشبورد
            </a>

            <!-- ========== مدیریت دانش آموزان (با زیرمنو) ========== -->
            <div class="menu-item sidebar-link" onclick="toggleSubmenu('studentsSubmenu')">
                <span class="menu-title">
                    <i class="bi bi-people-fill"></i>  مدیریت دانش آموزان
                </span>
                <i class="bi bi-chevron-down dropdown-icon" id="studentsIcon"></i>
            </div>
            <div id="studentsSubmenu" class="submenu">
                <a href="{{ route('students.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('students.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>  لیست دانش آموزان
                </a>
                <a href="{{ route('students.create') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('students.create') ? 'active' : '' }}">
                    <i class="bi bi-person-plus-fill"></i>  افزودن دانش آموز
                </a>
            </div>

            <!-- مدیریت معاونین (فقط ادمین اصلی) -->
            @if(session('admin_role') == 'admin')
                <div class="menu-item sidebar-link" onclick="toggleSubmenu('viceSubmenu')">
                    <span class="menu-title">
                        <i class="bi bi-people"></i>  مدیریت معاونین
                    </span>
                    <i class="bi bi-chevron-down dropdown-icon" id="viceIcon"></i>
                </div>
                <div id="viceSubmenu" class="submenu">
                    <a href="{{ route('vice-principals.index') }}"
                       class="nav-link sidebar-link {{ request()->routeIs('vice-principals.*') ? 'active' : '' }}">
                        <i class="bi bi-list-ul"></i>  لیست معاونین
                    </a>
                    <a href="{{ route('vice-principals.create') }}"
                       class="nav-link sidebar-link">
                        <i class="bi bi-person-plus-fill"></i>  افزودن معاون
                    </a>
                </div>
            @endif

            <!-- ========== مدیریت مربیان (با زیرمنو) ========== -->
            @if(session('admin_role') == 'admin' || session('admin_role') == 'vice_principal')
                <div class="menu-item sidebar-link" onclick="toggleSubmenu('mentorSubmenu')">
                    <span class="menu-title">
                        <i class="bi bi-person-badge-fill"></i>  مدیریت مربیان
                    </span>
                    <i class="bi bi-chevron-down dropdown-icon" id="mentorIcon"></i>
                </div>
                <div id="mentorSubmenu" class="submenu">
                    <a href="{{ route('mentors.index') }}"
                       class="nav-link sidebar-link {{ request()->routeIs('mentors.index') ? 'active' : '' }}">
                        <i class="bi bi-list-ul"></i>  لیست مربیان
                    </a>
                    <a href="{{ route('mentors.create') }}"
                       class="nav-link sidebar-link">
                        <i class="bi bi-person-plus-fill"></i>  افزودن مربی
                    </a>
                    <a href="{{ route('mentors.assign.create') }}"
                       class="nav-link sidebar-link {{ request()->routeIs('mentors.assign.create') ? 'active' : '' }}">
                        <i class="bi bi-person-plus-fill"></i>  تخصیص مربی به دانش‌آموز
                    </a>
                    <a href="{{ route('mentors.assignments.index') }}"
                       class="nav-link sidebar-link {{ request()->routeIs('mentors.assignments.index') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i>  لیست تخصیص‌ها
                    </a>
                </div>
            @endif

            <!-- درخواست‌های کارآموزی -->
            @if(session('admin_role') == 'admin' || session('admin_role') == 'vice_principal')
                <a href="{{ route('admin.internship-requests.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('admin.internship-requests.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope-paper-fill"></i>  درخواست‌های کارآموزی
                </a>
            @endif

            <!-- حضور غیاب -->
            @if(session('admin_role') == 'admin' || session('admin_role') == 'vice_principal')
                <a href="{{ route('admin.attendance.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('admin.attendance.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i>  حضور غیاب
                </a>
            @endif

          

            <hr class="text-secondary mx-3 my-2">

            <!-- خروج -->
            <a href="{{ route('logout') }}"
               class="nav-link sidebar-link text-danger">
                <i class="bi bi-box-arrow-left"></i>  خروج
            </a>

        </nav>
    </div>
</div>

<script>
    function toggleSubmenu(id) {
        const submenu = document.getElementById(id);
        const icon = document.getElementById(id + 'Icon');
        
        if (submenu.classList.contains('show')) {
            submenu.classList.remove('show');
            icon.classList.remove('rotated');
        } else {
            submenu.classList.add('show');
            icon.classList.add('rotated');
        }
    }
    
    // باز نگه داشتن زیرمنوی فعال بر اساس مسیر فعلی
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        
        // چک کردن زیرمنوی دانش آموزان
        if (currentUrl.includes('/students')) {
            document.getElementById('studentsSubmenu')?.classList.add('show');
            document.getElementById('studentsIcon')?.classList.add('rotated');
        }
        
        // چک کردن زیرمنوی مربیان
        if (currentUrl.includes('/mentors') || currentUrl.includes('/mentor-assignments')) {
            document.getElementById('mentorSubmenu')?.classList.add('show');
            document.getElementById('mentorIcon')?.classList.add('rotated');
        }
        
        // چک کردن زیرمنوی معاونین
        if (currentUrl.includes('/vice-principals')) {
            document.getElementById('viceSubmenu')?.classList.add('show');
            document.getElementById('viceIcon')?.classList.add('rotated');
        }
    });
</script>

</body>
</html>