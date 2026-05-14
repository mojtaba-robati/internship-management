<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Mentor;  // 👈 اضافه کن

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {

        $request->validate([
            'phone' => 'required',
            'password' => 'required'
        ]);

        // 1️⃣ اول بررسی کن ادمین هست؟
        $admin = Admin::where('phone', $request->phone)
                      ->where('password', $request->password)
                      ->first();

        if ($admin) {
            session([
                'admin_logged_in' => true,
                'admin_id' => $admin->id,
                'admin_name' => $admin->first_name . ' ' . $admin->last_name,
                'admin_role' => $admin->role,
                'user_type' => 'admin'
            ]);
            return redirect()->route('admin.dashboard');
        }

        // 2️⃣ بررسی کن مربی ناظر هست؟
        $mentor = Mentor::where('phone', $request->phone)
                        ->where('password', $request->password)
                        ->first();

        if ($mentor) {
            session([
                'mentor_logged_in' => true,
                'mentor_id' => $mentor->id,
                'mentor_name' => $mentor->first_name . ' ' . $mentor->last_name,
                'user_type' => 'mentor'
            ]);
            return redirect()->route('mentor.dashboard');
        }

        // 3️⃣ بررسی کن دانش آموز هست؟
        $student = Student::where('phone', $request->phone)
                          ->where('national_code', $request->password)
                          ->first();

        if ($student) {
            if ($student->is_active == 0) {
                return back()->with('error', 'حساب کاربری شما غیرفعال است. با مدیر تماس بگیرید.');
            }

            session([
                'student_logged_in' => true,
                'student_id' => $student->id,
                'student_name' => $student->first_name . ' ' . $student->last_name,
                'student_phone' => $student->phone,
                'user_type' => 'student'
            ]);
            return redirect()->route('student.dashboard');
        }

        return back()->with('error', 'شماره تماس یا رمز عبور اشتباه است.');
    }

    public function logout() {
        session()->forget([
            'admin_logged_in', 'admin_id', 'admin_name', 'admin_role',
            'student_logged_in', 'student_id', 'student_name', 'student_phone',
            'mentor_logged_in', 'mentor_id', 'mentor_name',
            'user_type'
        ]);
        return redirect()->route('login')->with('success', 'خروج با موفقیت انجام شد.');
    }
}