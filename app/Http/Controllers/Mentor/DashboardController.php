<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $mentorId = session('mentor_id');
        
        // گرفتن دانش‌آموزانی که به این مربی تخصیص داده شده‌اند
        $students = \DB::table('mentor_student')
            ->where('mentor_student.mentor_id', $mentorId)
            ->join('students', 'mentor_student.student_id', '=', 'students.id')
            ->join('internship_requests', 'mentor_student.internship_request_id', '=', 'internship_requests.id')
            ->select(
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.national_code',
                'students.phone',
                'students.major',
                'students.grade',
                'internship_requests.company_name',
                'internship_requests.company_address',
                'internship_requests.company_phone',
                'internship_requests.supervisor_name',
                'internship_requests.supervisor_phone',
                'mentor_student.status as assignment_status',
                'mentor_student.created_at as assigned_at'
            )
            ->orderBy('students.last_name')
            ->get();
        
        // آمار
        $totalStudents = $students->count();
        $activeStudents = $students->where('assignment_status', 'active')->count();
        
        return view('mentor.dashboard', compact('students', 'totalStudents', 'activeStudents'));
    }
    
    public function showAttendance($studentId)
    {
        $mentorId = session('mentor_id');
        
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $studentId)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.dashboard')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $student = Student::findOrFail($studentId);
        
        $internshipRequest = \App\Models\InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        $attendance = Attendance::where('student_id', $studentId)->first();
        $days = $attendance ? $attendance->days : [];
        
        return view('mentor.attendance', compact('student', 'days', 'internshipRequest'));
    }
    
    // ========== متد نمایش اطلاعات کامل دانش‌آموز (اضافه کن) ==========
    public function showStudent($id)
    {
        $mentorId = session('mentor_id');
        
        // بررسی دسترسی مربی به این دانش‌آموز
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $id)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.dashboard')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $student = Student::findOrFail($id);
        
        // گرفتن اطلاعات کارآموزی
        $internshipRequest = \App\Models\InternshipRequest::where('student_id', $id)
            ->where('status', 'approved')
            ->first();
        
        return view('mentor.student-details', compact('student', 'internshipRequest'));
    }
}