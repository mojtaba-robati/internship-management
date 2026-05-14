<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    // نمایش لیست دانش‌آموزانی که درخواست تایید شده دارند
    public function index()
    {
        $students = InternshipRequest::where('status', 'approved')
            ->with('student')
            ->get()
            ->pluck('student')
            ->unique('id');
        
        return view('admin.attendance.index', compact('students'));
    }
    
    // نمایش 40 روز یک دانش‌آموز خاص
    public function show($studentId)
    {
        $student = \App\Models\Student::findOrFail($studentId);
        
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        if (!$internshipRequest) {
            return redirect()->route('admin.attendance.index')
                ->with('error', 'این دانش‌آموز درخواست تایید شده ندارد.');
        }
        
        $attendance = Attendance::where('student_id', $studentId)
            ->where('internship_request_id', $internshipRequest->id)
            ->first();
        
        $days = $attendance ? $attendance->days : [];
        
        return view('admin.attendance.show', compact('student', 'days', 'attendance', 'internshipRequest'));
    }
    
    public function approve($id, $row)
    {
        $attendance = Attendance::findOrFail($id);
        $days = $attendance->days;
        
        if (!isset($days[$row])) {
            return back()->with('error', 'ردیف مورد نظر یافت نشد.');
        }
        
        if ($days[$row]['status'] == 'approved') {
            return back()->with('error', "روز {$row} قبلاً تایید شده است.");
        }
        
        $days[$row]['status'] = 'approved';
        $days[$row]['approved_at'] = now()->toDateTimeString();
        
        $attendance->days = $days;
        $attendance->save();
        
        return back()->with('success', "روز {$row} با موفقیت تایید شد.");
    }
    
    public function reject(Request $request, $id, $row)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ], [
            'reason.required' => 'لطفاً دلیل رد را وارد کنید.',
            'reason.min' => 'دلیل رد باید حداقل 10 کاراکتر باشد.',
        ]);
        
        $attendance = Attendance::findOrFail($id);
        $days = $attendance->days;
        
        if (!isset($days[$row])) {
            return back()->with('error', 'ردیف مورد نظر یافت نشد.');
        }
        
        if ($days[$row]['status'] == 'rejected') {
            return back()->with('error', "روز {$row} قبلاً رد شده است.");
        }
        
        $days[$row]['status'] = 'rejected';
        $days[$row]['mentor_note'] = $request->reason;
        
        $attendance->days = $days;
        $attendance->save();
        
        return back()->with('error', "روز {$row} با موفقیت رد شد.");
    }
}