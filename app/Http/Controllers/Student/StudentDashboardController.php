<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\InternshipRequest;

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

    // خروج از سیستم
    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'خروج با موفقیت انجام شد.');
    }
}   