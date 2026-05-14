<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // لیست تمام دانش‌آموزان تحت نظارت
    public function index()
    {
        $mentorId = session('mentor_id');
        
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
                'students.is_active',
                'internship_requests.company_name',
                'internship_requests.company_address',
                'internship_requests.company_phone',
                'mentor_student.status as assignment_status'
            )
            ->orderBy('students.last_name')
            ->paginate(15);
        
        return view('mentor.students.index', compact('students'));
    }
    
    // نمایش اطلاعات کامل یک دانش‌آموز
    public function show($id)
    {
        $mentorId = session('mentor_id');
        
        // بررسی دسترسی
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $id)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.students.index')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        // اطلاعات دانش‌آموز
        $student = Student::findOrFail($id);
        
        // اطلاعات کارآموزی
        $internship = \App\Models\InternshipRequest::where('student_id', $id)
            ->where('status', 'approved')
            ->first();
        
        // دفترچه حضور غیاب
        $attendance = Attendance::where('student_id', $id)->first();
        $days = $attendance ? $attendance->days : [];
        
        return view('mentor.students.show', compact('student', 'internship', 'days'));
    }
}