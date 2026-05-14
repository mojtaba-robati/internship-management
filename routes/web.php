<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Admin\VicePrincipalController;
use App\Http\Controllers\Student\InternshipRequestController;
use App\Http\Controllers\Admin\InternshipRequestController as AdminInternshipRequestController;
use App\Http\Controllers\Student\AttendanceController;
use App\Http\Controllers\Admin\AttendanceController as AdminAttendanceController;
use App\Http\Controllers\Admin\MentorController;
use App\Http\Controllers\Admin\MentorAssignmentController;
use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
use App\Http\Controllers\Mentor\StudentController as MentorStudentController;
use App\Http\Controllers\Mentor\AttendanceController as MentorAttendanceController;

Route::get('/', function () {
    return view('welcome');
});

// نمایش فرم لاگین
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// پردازش فرم لاگین
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');

// خروج
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// ========== مسیرهای ادمین ==========
Route::prefix('admin')->middleware('admin.auth')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // مدیریت دانش‌آموزان
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students/store', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    
    // حذف گروهی دانش آموزان
    Route::delete('/students/delete-by-grade/{grade}', [StudentController::class, 'deleteByGrade'])->name('students.deleteByGrade');
    Route::delete('/students/delete-all', [StudentController::class, 'deleteAll'])->name('students.deleteAll');

    // مدیریت حضور غیاب (ادمین)
    Route::prefix('attendance')->name('admin.attendance.')->group(function () {
        Route::get('/', [AdminAttendanceController::class, 'index'])->name('index');
        Route::get('/{studentId}', [AdminAttendanceController::class, 'show'])->name('show');
        Route::put('/{id}/{row}/approve', [AdminAttendanceController::class, 'approve'])->name('approve');
        Route::put('/{id}/{row}/reject', [AdminAttendanceController::class, 'reject'])->name('reject');
    });
    
    // مدیریت معاونین
    Route::resource('vice-principals', VicePrincipalController::class);
    
    // مدیریت درخواست‌های کارآموزی
    Route::prefix('internship-requests')->name('admin.internship-requests.')->group(function () {
        Route::get('/', [AdminInternshipRequestController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminInternshipRequestController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [AdminInternshipRequestController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminInternshipRequestController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminInternshipRequestController::class, 'destroy'])->name('destroy');
        Route::delete('/bulk-delete', [AdminInternshipRequestController::class, 'bulkDelete'])->name('bulk-delete');
    });
    
    // مدیریت مربیان
    Route::resource('mentors', MentorController::class);
    
    // تخصیص مربی به دانش‌آموز
    Route::prefix('mentor-assignments')->name('mentors.')->group(function () {
        Route::get('/assign', [MentorAssignmentController::class, 'create'])->name('assign.create');
        Route::post('/assign', [MentorAssignmentController::class, 'store'])->name('assign.store');
        Route::get('/list', [MentorAssignmentController::class, 'index'])->name('assignments.index');
        Route::delete('/{id}', [MentorAssignmentController::class, 'destroy'])->name('assignment.destroy');
    });
});

// ========== مسیرهای مربی ناظر ==========
Route::prefix('mentor')->middleware('mentor.auth')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
    
    // لیست دانش‌آموزان
    Route::get('/students', [MentorStudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [MentorStudentController::class, 'show'])->name('students.show');
    
    // حضور غیاب با قابلیت تایید/رد
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [MentorAttendanceController::class, 'index'])->name('index');
        Route::get('/{studentId}', [MentorAttendanceController::class, 'show'])->name('show');
        Route::put('/{attendanceId}/{row}/approve', [MentorAttendanceController::class, 'approve'])->name('approve');
        Route::put('/{attendanceId}/{row}/reject', [MentorAttendanceController::class, 'reject'])->name('reject');
    });
});

// ========== مسیرهای دانش آموز ==========
Route::prefix('student')->middleware('student.auth')->name('student.')->group(function () {
    
    Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
    Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');
    Route::get('/grades', [StudentDashboardController::class, 'grades'])->name('grades');

    // دفترچه حضور غیاب (دانش آموز)
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('index');
        Route::post('/{id}/checkin', [AttendanceController::class, 'checkIn'])->name('checkin');
        Route::post('/{id}/checkout', [AttendanceController::class, 'checkOut'])->name('checkout');
        Route::put('/{id}', [AttendanceController::class, 'update'])->name('update');
    });
    
    // درخواست‌های کارآموزی دانش آموز
    Route::resource('internship-requests', InternshipRequestController::class);
    
    Route::post('/logout', [StudentDashboardController::class, 'logout'])->name('logout');
});