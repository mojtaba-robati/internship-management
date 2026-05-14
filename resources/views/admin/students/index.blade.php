<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مدیریت دانش آموزان</title>
    
    <!-- فقط فایل‌هایی که واقعاً داری -->
    @if(file_exists(public_path('css/fonts.css')))
        <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    @endif
    
    @if(file_exists(public_path('assets/css/bootstrap.min.css')))
        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    @endif
    
    <style>
        body {
            background: #f5f6fa;
            font-family: 'Shabnam', 'Tahoma', 'Arial', sans-serif;
            direction: rtl;
            text-align: right;
        }
        
        .content-area {
            margin-right: 240px;
            padding: 25px;
        }
        
        @media (max-width: 991px) {
            .content-area {
                margin-right: 0;
                padding: 15px;
            }
        }
        
        table td {
            vertical-align: middle;
        }
        
        .btn-outline-primary.active {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }
        
        .btn-outline-secondary.active {
            background-color: #6c757d;
            color: white;
            border-color: #6c757d;
        }
        
        .card {
            border-radius: 15px;
            transition: transform 0.2s;
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .card:hover {
            transform: translateY(-3px);
        }
        
        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        /* آیکون‌های ساده بدون نیاز به Bootstrap Icons */
        .icon-plus:before {
            content: "+";
            margin-left: 5px;
            font-weight: bold;
        }
    </style>
</head>
<body>

@include('admin.components.sidebar')

<div class="content-area">
    <div class="container-fluid">
        
        {{-- هدر --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">همه دانش آموزان</h3>
            <a href="{{ route('students.create') }}" class="btn btn-primary">
                <span class="icon-plus"></span> افزودن دانش آموز
            </a>
        </div>
        
        {{-- بخش فیلتر --}}
        @include('admin.students.partials.filter')
        
        {{-- بخش جدول --}}
        <div class="card shadow-sm border-0">
            <div class="card-body">
                @include('admin.students.partials.table')
            </div>
        </div>
        
    </div>
</div>

{{-- مودال حذف --}}
@include('admin.students.partials.delete-modal')

<script>
    // بررسی وجود المان‌ها قبل از استفاده
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteModal');
        if (deleteModal) {
            deleteModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                if (button) {
                    const studentId = button.getAttribute('data-id');
                    const studentName = button.getAttribute('data-name');
                    const studentNameSpan = document.getElementById('studentName');
                    const deleteForm = document.getElementById('deleteForm');
                    
                    if (studentNameSpan && studentName) {
                        studentNameSpan.textContent = studentName;
                    }
                    if (deleteForm && studentId) {
                        deleteForm.action = `/admin/students/${studentId}`;
                    }
                }
            });
        }
    });
</script>

<!-- فقط اگه Bootstrap JS رو داری، لودش کن -->
@if(file_exists(public_path('assets/js/bootstrap.bundle.min.js')))
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
@endif

</body>
</html>