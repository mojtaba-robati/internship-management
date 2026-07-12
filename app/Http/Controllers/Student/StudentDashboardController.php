<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\InternshipRequest;
use App\Models\FinalGrade; // اضافه کن
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentDashboardController extends Controller
{
    // نمایش داشبورد دانش آموز
    public function dashboard()
    {
        $studentId = session('student_id');
        
        if (!$studentId) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }
        
        $student = Student::find($studentId);
        
        if (!$student) {
            session()->flush();
            return redirect()->route('login')->with('error', 'اطلاعات شما یافت نشد.');
        }
        
        // آمار درخواست‌های کارآموزی
        $pendingRequests = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'pending')
            ->count();
            
        $approvedRequests = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->count();
            
        $rejectedRequests = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'rejected')
            ->count();
        
        return view('student.dashboard', compact('student', 'pendingRequests', 'approvedRequests', 'rejectedRequests'));
    }

    // نمایش پروفایل دانش آموز
    public function profile()
    {
        $studentId = session('student_id');
        
        if (!$studentId) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }
        
        $student = Student::find($studentId);
        
        if (!$student) {
            session()->flush();
            return redirect()->route('login')->with('error', 'اطلاعات شما یافت نشد.');
        }
        
        return view('student.profile', compact('student'));
    }

    // نمایش نمرات دانش آموز
    public function grades()
    {
        $studentId = session('student_id');
        
        if (!$studentId) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }
        
        $student = Student::find($studentId);
        
        if (!$student) {
            session()->flush();
            return redirect()->route('login')->with('error', 'اطلاعات شما یافت نشد.');
        }
        
        // گرفتن نمره نهایی
        $finalGrade = FinalGrade::where('student_id', $studentId)->first();
        
        return view('student.grades', compact('student', 'finalGrade'));
    }

    // تغییر رمز عبور
    public function updatePassword(Request $request)
    {
        $studentId = session('student_id');
        
        if (!$studentId) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }

        $student = Student::find($studentId);

        if (!$student) {
            session()->flush();
            return redirect()->route('login')->with('error', 'اطلاعات شما یافت نشد.');
        }

        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) use ($student) {
                    if (!Hash::check($value, $student->password)) {
                        $fail('رمز عبور فعلی شما اشتباه است.');
                    }
                }
            ],
            'new_password' => 'required|min:4|confirmed',
        ], [
            'current_password.required' => 'وارد کردن رمز عبور فعلی الزامی است.',
            'new_password.required' => 'وارد کردن رمز عبور جدید الزامی است.',
            'new_password.min' => 'رمز عبور جدید باید حداقل 4 کاراکتر باشد.',
            'new_password.confirmed' => 'رمز عبور جدید با تکرار آن مطابقت ندارد.',
        ]);

        $student->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', 'رمز عبور شما با موفقیت تغییر کرد.');
    }

    // خروج از سیستم
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'خروج با موفقیت انجام شد.');
    }
}