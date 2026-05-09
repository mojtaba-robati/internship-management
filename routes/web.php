<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Admin\VicePrincipalController;
use App\Http\Controllers\Student\InternshipRequestController;
use App\Http\Controllers\Admin\InternshipRequestController as AdminInternshipRequestController;

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
    
    // مدیریت معاونین (Resource Route)
    Route::resource('vice-principals', VicePrincipalController::class);
    
    // مدیریت درخواست‌های کارآموزی (برای ادمین و معاون)
    Route::prefix('internship-requests')->name('admin.internship-requests.')->group(function () {
        Route::get('/', [AdminInternshipRequestController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminInternshipRequestController::class, 'show'])->name('show');
        Route::post('/{id}/approve', [AdminInternshipRequestController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminInternshipRequestController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminInternshipRequestController::class, 'destroy'])->name('destroy');
        
        // ========== این خط رو اضافه کن (حذف گروهی) ==========
        Route::delete('/bulk-delete', [AdminInternshipRequestController::class, 'bulkDelete'])->name('bulk-delete');
    });
});

// ========== مسیرهای دانش آموز ==========
Route::prefix('student')->middleware('student.auth')->name('student.')->group(function () {
    
    Route::get('/dashboard', [StudentDashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [StudentDashboardController::class, 'profile'])->name('profile');
    Route::get('/courses', [StudentDashboardController::class, 'courses'])->name('courses');
    Route::get('/grades', [StudentDashboardController::class, 'grades'])->name('grades');
    
    // درخواست‌های کارآموزی دانش آموز
    Route::resource('internship-requests', InternshipRequestController::class);
    
    Route::post('/logout', [StudentDashboardController::class, 'logout'])->name('logout');
});