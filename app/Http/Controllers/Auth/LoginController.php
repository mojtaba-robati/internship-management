<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Student;

class LoginController extends Controller
{
    // نمایش فرم لاگین
    public function showLoginForm() {
        return view('auth.login');
    }

    // پردازش فرم لاگین
    public function login(Request $request) {

        // اعتبارسنجی فیلدها
        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        // ابتدا بررسی کن ادمین هست؟
        $admin = Admin::where('phone', $request->phone)
                      ->where('password', $request->password)
                      ->first();

        if ($admin) {
            // ذخیره وضعیت ورود ادمین در سشن
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->first_name . ' ' . $admin->last_name,
                'admin_role' => $admin->role,  // 👈 این خط رو اضافه کن
                'user_type' => 'admin'
            ]);

            return redirect()->route('admin.dashboard');
        }

        // اگر ادمین نبود، بررسی کن دانش آموز هست؟
        $student = Student::where('phone', $request->phone)
                          ->where('national_code', $request->password)
                          ->first();

        if ($student) {
            // بررسی فعال بودن حساب دانش آموز
            if ($student->is_active == 0) {
                return back()->with('error', 'حساب کاربری شما غیرفعال است. با مدیر تماس بگیرید.');
            }

            // ذخیره وضعیت ورود دانش آموز در سشن
            session([
                'student_logged_in' => true,
                'student_id' => $student->id,
                'student_name' => $student->first_name . ' ' . $student->last_name,
                'student_phone' => $student->phone,
                'user_type' => 'student'
            ]);

            return redirect()->route('student.dashboard');
        }

        // اگر هیچکدام نبود
        return back()->with('error', 'شماره تماس یا رمز عبور اشتباه است.');
    }

    // خروج از سیستم
    public function logout() {
        session()->forget([
            'admin_logged_in', 
            'admin_id', 
            'admin_name', 
            'admin_role',  
            'student_logged_in', 
            'student_id', 
            'student_name', 
            'student_phone', 
            'user_type'
        ]);
        return redirect()->route('login')->with('success', 'خروج با موفقیت انجام شد.');
    }
}