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
            #mentorSidebar {
                position: fixed;
                top: 0;
                right: 0;
                bottom: 0;
                width: 260px;
                transform: none !important;
                visibility: visible !important;
                background-color: #1a1a2e !important;
            }
            .mentor-content-wrapper {
                margin-right: 260px;
            }
            .btn[data-bs-target="#mentorSidebar"] {
                display: none;
            }
        }
        
        @media (max-width: 991px) {
            .mentor-content-wrapper {
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
        data-bs-target="#mentorSidebar">
    <i class="bi bi-list"></i> منو
</button>

{{-- سایدبار سمت راست --}}
<div class="offcanvas offcanvas-end offcanvas-lg text-bg-dark"
     tabindex="-1"
     id="mentorSidebar"
     style="background-color: #1a1a2e;">

    <div class="offcanvas-header border-bottom border-secondary text-end w-100">
        <div class="w-100 text-end">
            <h5 class="mb-0">
                <i class="bi bi-person-badge-fill"></i> پنل مربی ناظر
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
            <a href="{{ route('mentor.dashboard') }}"
               class="nav-link sidebar-link {{ request()->routeIs('mentor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>  داشبورد
            </a>

            <!-- ========== دانش آموزان ========== -->
            <div class="menu-item sidebar-link" onclick="toggleSubmenu('studentsSubmenu')">
                <span class="menu-title">
                    <i class="bi bi-people-fill"></i>  دانش آموزان
                </span>
                <i class="bi bi-chevron-down dropdown-icon" id="studentsIcon"></i>
            </div>
            <div id="studentsSubmenu" class="submenu">
                <a href="{{ route('mentor.students.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('mentor.students.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>  لیست دانش آموزان
                </a>
            </div>

            <!-- ========== گزارش کار ========== -->
            <div class="menu-item sidebar-link" onclick="toggleSubmenu('workReportsSubmenu')">
                <span class="menu-title">
                    <i class="bi bi-file-text-fill"></i>  گزارش کار
                </span>
                <i class="bi bi-chevron-down dropdown-icon" id="workReportsIcon"></i>
            </div>
            <div id="workReportsSubmenu" class="submenu">
                <a href="{{ route('mentor.work-reports.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('mentor.work-reports.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>  لیست گزارش‌ها
                </a>
            </div>

            <!-- ========== نمره‌دهی ========== -->
            <div class="menu-item sidebar-link" onclick="toggleSubmenu('gradingSubmenu')">
                <span class="menu-title">
                    <i class="bi bi-star-fill"></i>  نمره‌دهی
                </span>
                <i class="bi bi-chevron-down dropdown-icon" id="gradingIcon"></i>
            </div>
            <div id="gradingSubmenu" class="submenu">
                <a href="{{ route('mentor.grading.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('mentor.grading.*') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>  لیست دانش‌آموزان
                </a>
            </div>

            <!-- ========== حضور غیاب ========== -->
            <div class="menu-item sidebar-link" onclick="toggleSubmenu('attendanceSubmenu')">
                <span class="menu-title">
                    <i class="bi bi-calendar-check-fill"></i>  حضور غیاب
                </span>
                <i class="bi bi-chevron-down dropdown-icon" id="attendanceIcon"></i>
            </div>
            <div id="attendanceSubmenu" class="submenu">
                <a href="{{ route('mentor.attendance.index') }}"
                   class="nav-link sidebar-link {{ request()->routeIs('mentor.attendance.index') ? 'active' : '' }}">
                    <i class="bi bi-list-ul"></i>  لیست حضور غیاب
                </a>
            </div>

          
            <hr class="text-secondary mx-3 my-2">

            <!-- خروج -->
            <a href="{{ route('logout') }}"
               class="nav-link sidebar-link text-danger"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-left"></i>  خروج
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;"></form>

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
    
    document.addEventListener('DOMContentLoaded', function() {
        const currentUrl = window.location.pathname;
        
        if (currentUrl.includes('/mentor/students')) {
            document.getElementById('studentsSubmenu')?.classList.add('show');
            document.getElementById('studentsIcon')?.classList.add('rotated');
        }
        
        if (currentUrl.includes('/mentor/work-reports')) {
            document.getElementById('workReportsSubmenu')?.classList.add('show');
            document.getElementById('workReportsIcon')?.classList.add('rotated');
        }
        
        if (currentUrl.includes('/mentor/grading')) {
            document.getElementById('gradingSubmenu')?.classList.add('show');
            document.getElementById('gradingIcon')?.classList.add('rotated');
        }
        
        if (currentUrl.includes('/mentor/attendance')) {
            document.getElementById('attendanceSubmenu')?.classList.add('show');
            document.getElementById('attendanceIcon')?.classList.add('rotated');
        }
        
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