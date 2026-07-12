<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\FinalGrade;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;

class GradingController extends Controller
{
    // لیست دانش‌آموزان برای نمره‌دهی
    public function index()
    {
        $mentorId = session('mentor_id');
        
        $students = \DB::table('mentor_student')
            ->where('mentor_student.mentor_id', $mentorId)
            ->join('students', 'mentor_student.student_id', '=', 'students.id')
            ->join('internship_requests', 'mentor_student.internship_request_id', '=', 'internship_requests.id')
            ->leftJoin('final_grades', function($join) {
                $join->on('final_grades.student_id', '=', 'students.id')
                     ->on('final_grades.internship_request_id', '=', 'internship_requests.id');
            })
            ->select(
                'students.id',
                'students.first_name',
                'students.last_name',
                'students.national_code',
                'students.major',
                'students.grade as student_grade',
                'internship_requests.company_name',
                'final_grades.grade as final_grade',
                'final_grades.mentor_note',
                'final_grades.id as final_grade_id'
            )
            ->get();
        
        return view('mentor.grading.index', compact('students'));
    }
    
    // فرم نمره‌دهی یک دانش‌آموز
    public function show($studentId)
    {
        $mentorId = session('mentor_id');
        
        $hasAccess = \DB::table('mentor_student')
            ->where('mentor_id', $mentorId)
            ->where('student_id', $studentId)
            ->exists();
        
        if (!$hasAccess) {
            return redirect()->route('mentor.grading.index')
                ->with('error', 'شما به این دانش‌آموز دسترسی ندارید.');
        }
        
        $student = Student::findOrFail($studentId);
        
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        $finalGrade = FinalGrade::where('student_id', $studentId)
            ->where('internship_request_id', $internshipRequest->id ?? 0)
            ->first();
        
        return view('mentor.grading.show', compact('student', 'internshipRequest', 'finalGrade'));
    }
    
    // ذخیره نمره نهایی
    public function store(Request $request, $studentId)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:15',
            'mentor_note' => 'nullable|string',
        ]);
        
        $mentorId = session('mentor_id');
        
        $internshipRequest = InternshipRequest::where('student_id', $studentId)
            ->where('status', 'approved')
            ->first();
        
        if (!$internshipRequest) {
            return back()->with('error', 'این دانش‌آموز درخواست کارآموزی تایید شده ندارد.');
        }
        
        FinalGrade::updateOrCreate(
            [
                'student_id' => $studentId,
                'internship_request_id' => $internshipRequest->id,
            ],
            [
                'mentor_id' => $mentorId,
                'grade' => $request->grade,
                'mentor_note' => $request->mentor_note,
            ]
        );
        
        return redirect()->route('mentor.grading.index')
            ->with('success', "نمره نهایی {$request->grade} با موفقیت ثبت شد.");
    }
}