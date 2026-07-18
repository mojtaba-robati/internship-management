<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\WorkReport;
use App\Models\InternshipRequest;
use App\Models\Attendance;
use App\Models\FinalGrade;  // 👈 اضافه کن
use Illuminate\Http\Request;
use Morilog\Jalali\Jalalian;

class WorkReportController extends Controller
{
    // لیست گزارش‌ها
    public function index()
    {
        $studentId = session('student_id');
        
        // پیدا کردن درخواست تایید شده
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        if (!$internshipRequest) {
            return redirect()->route('student.dashboard')
                ->with('error', 'هنوز درخواست کارآموزی شما تایید نشده است.');
        }
        
        // گرفتن گزارش‌های موجود
        $reports = WorkReport::where('student_id', $studentId)
            ->where('internship_request_id', $internshipRequest->id)
            ->orderBy('row_number')
            ->get()
            ->keyBy('row_number');
        
        // گرفتن حضور غیاب برای تاریخ‌ها
        $attendance = Attendance::where('student_id', $studentId)->first();
        $days = $attendance ? $attendance->days : [];
        
        return view('student.work-reports.index', compact('reports', 'internshipRequest', 'days'));
    }
    
    // صفحه ثبت گزارش جدید
    public function create($row)
    {
        $studentId = session('student_id');
        
        // 👈 بررسی اینکه آیا کارآموزی تکمیل شده است
        $isCompleted = FinalGrade::where('student_id', $studentId)
            ->where('is_completed', true)
            ->exists();
        
        if ($isCompleted) {
            return redirect()->route('student.work-reports.index')
                ->with('error', 'دوره کارآموزی شما تکمیل شده است و نمی‌توانید گزارش جدید ثبت کنید.');
        }
        
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        if (!$internshipRequest) {
            return redirect()->route('student.dashboard')
                ->with('error', 'هنوز درخواست کارآموزی شما تایید نشده است.');
        }
        
        // بررسی اینکه قبلاً برای این ردیف گزارش ثبت نشده باشد
        $exists = WorkReport::where('student_id', $studentId)
            ->where('row_number', $row)
            ->exists();
        
        if ($exists) {
            return redirect()->route('student.work-reports.index')
                ->with('error', 'برای این روز قبلاً گزارش کار ثبت شده است.');
        }
        
        return view('student.work-reports.create', compact('row', 'internshipRequest'));
    }
    
    // ذخیره گزارش جدید
    public function store(Request $request)
    {
        $studentId = session('student_id');
        
        // 👈 بررسی اینکه آیا کارآموزی تکمیل شده است
        $isCompleted = FinalGrade::where('student_id', $studentId)
            ->where('is_completed', true)
            ->exists();
        
        if ($isCompleted) {
            return redirect()->route('student.work-reports.index')
                ->with('error', 'دوره کارآموزی شما تکمیل شده است و نمی‌توانید گزارش جدید ثبت کنید.');
        }
        
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        if (!$internshipRequest) {
            return redirect()->route('student.work-reports.index')
                ->with('error', 'درخواست کارآموزی شما تایید نشده است.');
        }
        
        $request->validate([
            'row' => 'required|integer|between:1,40',
            'report_date' => 'required|date',
            'report_text' => 'required|string',
        ], [
            'report_date.required' => 'تاریخ گزارش الزامی است',
            'report_text.required' => 'متن گزارش الزامی است',
        ]);
        
        // بررسی اینکه قبلاً ثبت نشده باشد
        $exists = WorkReport::where('student_id', $studentId)
            ->where('row_number', $request->row)
            ->exists();
        
        if ($exists) {
            return redirect()->route('student.work-reports.index')
                ->with('error', 'این روز قبلاً گزارش کار ثبت شده است.');
        }
        
        // پیدا کردن مربی تخصیص داده شده
        $mentorAssignment = \DB::table('mentor_student')
            ->where('student_id', $studentId)
            ->where('internship_request_id', $internshipRequest->id)
            ->first();
        
        WorkReport::create([
            'student_id' => $studentId,
            'internship_request_id' => $internshipRequest->id,
            'mentor_id' => $mentorAssignment ? $mentorAssignment->mentor_id : null,
            'row_number' => $request->row,
            'report_date' => $request->report_date,
            'report_text' => $request->report_text,
            'status' => 'pending',
            'submitted_at' => now(),
        ]);
        
        return redirect()->route('student.work-reports.index')
            ->with('success', 'گزارش کار روز ' . $request->row . ' با موفقیت ثبت شد.');
    }
}