<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // لیست دانش‌آموزان تحت نظارت
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
                'students.phone',
                'students.major',
                'students.grade',
                'internship_requests.company_name'
            )
            ->orderBy('students.last_name')
            ->get();
        
        return view('mentor.attendance.index', compact('students'));
    }
    
    // نمایش دفترچه حضور غیاب یک دانش‌آموز
    public function show($studentId)
    {
        $mentorId = session('mentor_id');
        
        // بررسی دسترسی
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $studentId)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.attendance.index')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $student = Student::findOrFail($studentId);
        
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        $attendance = Attendance::where('student_id', $studentId)->first();
        $days = $attendance ? $attendance->days : [];
        
        return view('mentor.attendance.show', compact('student', 'days', 'internshipRequest', 'attendance'));
    }
    
    // تایید یک روز
    public function approve($attendanceId, $row)
    {
        $attendance = Attendance::findOrFail($attendanceId);
        
        // بررسی دسترسی مربی به این دانش‌آموز
        $mentorId = session('mentor_id');
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $attendance->student_id)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.attendance.index')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $days = $attendance->days;
        
        if (!isset($days[$row])) {
            return back()->with('error', 'ردیف مورد نظر یافت نشد.');
        }
        
        if ($days[$row]['status'] != 'pending') {
            return back()->with('error', 'این روز قبلاً تایید یا رد شده است.');
        }
        
        $days[$row]['status'] = 'approved';
        $days[$row]['approved_at'] = now()->toDateTimeString();
        $days[$row]['mentor_note'] = request('mentor_note');
        
        $attendance->days = $days;
        $attendance->save();
        
        return back()->with('success', "روز {$row} با موفقیت تایید شد.");
    }
    
    // رد یک روز
    public function reject(Request $request, $attendanceId, $row)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'لطفاً دلیل رد را وارد کنید.',
            'reason.min' => 'دلیل رد باید حداقل 10 کاراکتر باشد.',
        ]);
        
        $attendance = Attendance::findOrFail($attendanceId);
        
        // بررسی دسترسی مربی به این دانش‌آموز
        $mentorId = session('mentor_id');
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $attendance->student_id)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.attendance.index')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $days = $attendance->days;
        
        if (!isset($days[$row])) {
            return back()->with('error', 'ردیف مورد نظر یافت نشد.');
        }
        
        if ($days[$row]['status'] != 'pending') {
            return back()->with('error', 'این روز قبلاً تایید یا رد شده است.');
        }
        
        $days[$row]['status'] = 'rejected';
        $days[$row]['mentor_note'] = $request->reason;
        
        $attendance->days = $days;
        $attendance->save();
        
        return back()->with('error', "روز {$row} با موفقیت رد شد.");
    }
}