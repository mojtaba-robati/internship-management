<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipRequest;
use App\Models\Attendance;
use Illuminate\Http\Request;

class InternshipRequestController extends Controller
{
    public function index(Request $request)
    {
        // پاک کردن خودکار درخواست‌های بدون دانش‌آموز (ارواح)
        InternshipRequest::whereDoesntHave('student')->delete();
        
        $query = InternshipRequest::with('student');
        
        // فیلتر بر اساس وضعیت
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        // فیلتر بر اساس رشته
        if ($request->has('major') && $request->major != '') {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('major', $request->major);
            });
        }
        
        // فیلتر بر اساس پایه
        if ($request->has('grade') && $request->grade != '') {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('grade', $request->grade);
            });
        }
        
        // جستجو در نام دانش‌آموز
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('student', function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        // جستجو در کد ملی
        if ($request->has('national_code') && $request->national_code != '') {
            $query->whereHas('student', function($q) use ($request) {
                $q->where('national_code', 'like', "%{$request->national_code}%");
            });
        }
        
        $requests = $query->orderBy('created_at', 'desc')->paginate(15);
        
        $totalCount = InternshipRequest::count();
        $pendingCount = InternshipRequest::where('status', 'pending')->count();
        $approvedCount = InternshipRequest::where('status', 'approved')->count();
        $rejectedCount = InternshipRequest::where('status', 'rejected')->count();
        
        return view('admin.internship-requests.index', compact('requests', 'totalCount', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function show($id)
    {
        $internshipRequest = InternshipRequest::with('student')->findOrFail($id);
        return view('admin.internship-requests.show', compact('internshipRequest'));
    }

    public function approve(Request $request, $id)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);
        
        $internshipRequest->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);
        
        // ========== ساخت 40 روز به صورت JSON ==========
        $days = [];
        $startDate = now();
        
        for ($i = 1; $i <= 40; $i++) {
            $days[$i] = [
                'row_number' => $i,
                'date' => $startDate->copy()->addDays($i - 1)->format('Y-m-d'),
                'check_in' => null,
                'check_out' => null,
                'status' => 'pending',
                'mentor_note' => null,
                'approved_at' => null,
            ];
        }
        
        Attendance::create([
            'student_id' => $internshipRequest->student_id,
            'internship_request_id' => $internshipRequest->id,
            'days' => $days,
        ]);

        return redirect()->route('admin.internship-requests.index')
            ->with('success', 'درخواست کارآموزی دانش‌آموز ' . $internshipRequest->student->first_name . ' ' . $internshipRequest->student->last_name . ' تایید شد و دفترچه حضور غیاب 40 روزه ساخته شد.');
    }

    public function reject(Request $request, $id)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'nullable|string',
        ]);
        
        $internshipRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.internship-requests.index')
            ->with('success', 'درخواست کارآموزی دانش‌آموز ' . $internshipRequest->student->first_name . ' ' . $internshipRequest->student->last_name . ' رد شد.');
    }

    public function reset($id)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);
        
        $internshipRequest->update([
            'status' => 'pending',
            'admin_notes' => null,
            'reviewed_at' => null,
        ]);
        
        return redirect()->route('admin.internship-requests.show', $id)
            ->with('success', 'درخواست به حالت "در انتظار بررسی" بازنشانی شد.');
    }

    public function destroy($id)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);
        $studentName = $internshipRequest->student->first_name . ' ' . $internshipRequest->student->last_name;
        
        // حذف ردیف‌های حضور غیاب مربوطه
        Attendance::where('internship_request_id', $id)->delete();
        
        // حذف درخواست
        $internshipRequest->delete();
        
        return redirect()->route('admin.internship-requests.index')
            ->with('success', 'درخواست کارآموزی ' . $studentName . ' و دفترچه حضور غیاب او حذف شد.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        
        if (empty($ids)) {
            return redirect()->route('admin.internship-requests.index')
                ->with('error', 'هیچ درخواستی انتخاب نشده است.');
        }
        
        // حذف ردیف‌های حضور غیاب مربوطه
        Attendance::whereIn('internship_request_id', $ids)->delete();
        
        // حذف درخواست‌ها
        $count = InternshipRequest::whereIn('id', $ids)->delete();
        
        return redirect()->route('admin.internship-requests.index')
            ->with('success', $count . ' درخواست و دفترچه حضور غیاب آنها با موفقیت حذف شد.');
    }
}