<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\InternshipRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;

class InternshipRequestController extends Controller
{
    public function index()
    {
        $requests = InternshipRequest::where('student_id', session('student_id'))
            ->orderBy('created_at', 'desc')
            ->get();
        
        // بررسی اینکه آیا درخواست تایید شده دارد
        $hasApprovedRequest = $requests->contains('status', 'approved');
        
        // بررسی اینکه آیا درخواست pending دارد
        $hasPendingRequest = $requests->contains('status', 'pending');
        
        return view('student.internship-requests.index', compact('requests', 'hasApprovedRequest', 'hasPendingRequest'));
    }

    public function create()
    {
        // بررسی کنید که دانش آموز قبلاً درخواست تایید شده دارد
        $hasApprovedRequest = InternshipRequest::where('student_id', session('student_id'))
            ->where('status', 'approved')
            ->exists();
        
        // بررسی کنید که دانش آموز درخواست pending دارد
        $hasPendingRequest = InternshipRequest::where('student_id', session('student_id'))
            ->where('status', 'pending')
            ->exists();
        
        // اگر درخواست تایید شده یا pending دارد، نذار درخواست جدید بده
        if ($hasApprovedRequest || $hasPendingRequest) {
            return redirect()->route('student.internship-requests.index')
                ->with('error', 'شما قبلاً یک درخواست فعال دارید. تا زمانی که درخواست فعلی شما بررسی نشود، نمی‌توانید درخواست جدید ثبت کنید.');
        }
        
        return view('student.internship-requests.create');
    }

    public function store(Request $request)
    {
        // دوباره چک کن قبل از ذخیره
        $hasApprovedRequest = InternshipRequest::where('student_id', session('student_id'))
            ->where('status', 'approved')
            ->exists();
        
        $hasPendingRequest = InternshipRequest::where('student_id', session('student_id'))
            ->where('status', 'pending')
            ->exists();
        
        if ($hasApprovedRequest || $hasPendingRequest) {
            return redirect()->route('student.internship-requests.index')
                ->with('error', 'شما قبلاً یک درخواست فعال دارید.');
        }
        
        // اعتبارسنجی اصلاح شده
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'required|string',
            'company_phone' => 'nullable|string',  // اختیاری و بدون محدودیت
            'supervisor_name' => 'required|string|max:255',
            'supervisor_phone' => 'required|string',  // اجباری ولی بدون محدودیت
            'description' => 'required|string',
            'skills' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        InternshipRequest::create([
            'student_id' => session('student_id'),
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'company_phone' => $request->company_phone,
            'supervisor_name' => $request->supervisor_name,
            'supervisor_phone' => $request->supervisor_phone,
            'description' => $request->description,
            'skills' => $request->skills,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'status' => 'pending',
        ]);

        return redirect()->route('student.internship-requests.index')
            ->with('success', 'درخواست کارآموزی شما با موفقیت ثبت شد.');
    }

    public function show($id)
    {
        $internshipRequest = InternshipRequest::where('student_id', session('student_id'))
            ->where('id', $id)
            ->firstOrFail();
        
        return view('student.internship-requests.show', compact('internshipRequest'));
    }
}