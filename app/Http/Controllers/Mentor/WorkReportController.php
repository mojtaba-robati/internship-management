<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\WorkReport;
use App\Models\Student;
use Illuminate\Http\Request;

class WorkReportController extends Controller
{
    // لیست دانش‌آموزانی که گزارش کار دارند
    public function index()
    {
        $mentorId = session('mentor_id');
        
        // گرفتن دانش‌آموزانی که به این مربی تخصیص داده شده‌اند و گزارش کار دارند
        $students = \DB::table('mentor_student')
            ->where('mentor_student.mentor_id', $mentorId)
            ->join('students', 'mentor_student.student_id', '=', 'students.id')
            ->join('internship_requests', 'mentor_student.internship_request_id', '=', 'internship_requests.id')
            ->select(
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.national_code',
                'internship_requests.company_name',
                \DB::raw('(SELECT COUNT(*) FROM work_reports WHERE work_reports.student_id = students.id AND work_reports.status = "pending") as pending_count'),
                \DB::raw('(SELECT COUNT(*) FROM work_reports WHERE work_reports.student_id = students.id) as total_count')
            )
            ->get();
        
        return view('mentor.work-reports.index', compact('students'));
    }
    
    // نمایش گزارش‌های یک دانش‌آموز
    public function show($studentId)
    {
        $mentorId = session('mentor_id');
        
        // بررسی دسترسی مربی به این دانش‌آموز
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $studentId)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.work-reports.index')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $student = Student::findOrFail($studentId);
        
        $reports = WorkReport::where('student_id', $studentId)
            ->orderBy('row_number')
            ->get();
        
        $internshipRequest = \App\Models\InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        return view('mentor.work-reports.show', compact('student', 'reports', 'internshipRequest'));
    }
    
    // تایید گزارش با نمره
    public function approve(Request $request, $id)
    {
        $request->validate([
            'grade' => 'nullable|numeric|min:0|max:100',
            'mentor_feedback' => 'nullable|string',
        ]);
        
        $report = WorkReport::findOrFail($id);
        
        // بررسی دسترسی مربی
        $mentorId = session('mentor_id');
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $report->student_id)
            ->exists();
        
        if (!$hasAccess) {
            return back()->with('error', 'شما به این گزارش دسترسی ندارید.');
        }
        
        if ($report->status != 'pending') {
            return back()->with('error', 'این گزارش قبلاً بررسی شده است.');
        }
        
        $report->update([
            'status' => 'approved',
            'grade' => $request->grade,
            'mentor_feedback' => $request->mentor_feedback,
            'reviewed_at' => now(),
        ]);
        
        return back()->with('success', 'گزارش کار با موفقیت تایید شد.');
    }
    
    // رد گزارش
    public function reject(Request $request, $id)
    {
        $request->validate([
            'mentor_feedback' => 'required|string|min:10',
        ], [
            'mentor_feedback.required' => 'لطفاً دلیل رد را وارد کنید.',
            'mentor_feedback.min' => 'دلیل رد باید حداقل 10 کاراکتر باشد.',
        ]);
        
        $report = WorkReport::findOrFail($id);
        
        // بررسی دسترسی مربی
        $mentorId = session('mentor_id');
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $report->student_id)
            ->exists();
        
        if (!$hasAccess) {
            return back()->with('error', 'شما به این گزارش دسترسی ندارید.');
        }
        
        if ($report->status != 'pending') {
            return back()->with('error', 'این گزارش قبلاً بررسی شده است.');
        }
        
        $report->update([
            'status' => 'rejected',
            'mentor_feedback' => $request->mentor_feedback,
            'reviewed_at' => now(),
        ]);
        
        return back()->with('error', 'گزارش کار رد شد.');
    }
}