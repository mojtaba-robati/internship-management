<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use App\Models\Student;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;

class MentorAssignmentController extends Controller
{
    public function create()
    {
        $mentors = Mentor::where('status', 'active')->get();
        $students = Student::whereHas('internshipRequests', function($q) {
            $q->where('status', 'approved');
        })->get();
        
        // گرفتن تخصیص‌های موجود برای نمایش وضعیت (بدون color)
        $existingAssignments = \DB::table('mentor_student')
            ->join('mentors', 'mentor_student.mentor_id', '=', 'mentors.id')
            ->select('mentor_student.student_id', 'mentors.first_name', 'mentors.last_name')
            ->get()
            ->keyBy('student_id');
        
        return view('admin.mentors.assign', compact('mentors', 'students', 'existingAssignments'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'mentor_id' => 'required|exists:mentors,id',
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);
        
        $mentorId = $request->mentor_id;
        $studentIds = $request->student_ids;
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($studentIds as $studentId) {
            $internshipRequest = InternshipRequest::where('student_id', $studentId)
                ->where('status', 'approved')
                ->first();
            
            if (!$internshipRequest) {
                $errorCount++;
                continue;
            }
            
            $exists = \DB::table('mentor_student')
                ->where('student_id', $studentId)
                ->where('internship_request_id', $internshipRequest->id)
                ->exists();
            
            if ($exists) {
                $errorCount++;
                continue;
            }
            
            \DB::table('mentor_student')->insert([
                'mentor_id' => $mentorId,
                'student_id' => $studentId,
                'internship_request_id' => $internshipRequest->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $successCount++;
        }
        
        return redirect()->route('mentors.assign.create')
            ->with('success', "{$successCount} دانش‌آموز با موفقیت تخصیص داده شد. {$errorCount} مورد خطا داشت.");
    }
    
    public function index()
    {
        $assignments = \DB::table('mentor_student')
            ->join('mentors', 'mentor_student.mentor_id', '=', 'mentors.id')
            ->join('students', 'mentor_student.student_id', '=', 'students.id')
            ->join('internship_requests', 'mentor_student.internship_request_id', '=', 'internship_requests.id')
            ->select(
                'mentor_student.*',
                'mentors.first_name as mentor_name',
                'mentors.last_name as mentor_lastname',
                'mentors.phone as mentor_phone',
                'students.first_name as student_name',
                'students.last_name as student_lastname',
                'students.national_code',
                'internship_requests.company_name'
            )
            ->orderBy('mentor_student.created_at', 'desc')
            ->get();
        
        return view('admin.mentors.assignments', compact('assignments'));
    }
    
    public function destroy($id)
    {
        \DB::table('mentor_student')->where('id', $id)->delete();
        
        return redirect()->route('mentors.assignments.index')
            ->with('success', 'تخصیص با موفقیت حذف شد.');
    }
}