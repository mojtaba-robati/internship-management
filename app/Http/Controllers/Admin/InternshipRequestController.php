<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;

class InternshipRequestController extends Controller
{
    public function index(Request $request)
    {
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

        return redirect()->route('admin.internship-requests.index')
            ->with('success', 'درخواست کارآموزی دانش‌آموز ' . $internshipRequest->student->first_name . ' ' . $internshipRequest->student->last_name . ' تایید شد.');
    }

    public function reject(Request $request, $id)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);
        
        $request->validate([
            'admin_notes' => 'required|string|min:10',
        ], [
            'admin_notes.required' => 'لطفاً دلیل رد درخواست را وارد کنید.',
            'admin_notes.min' => 'دلیل رد درخواست باید حداقل 10 کاراکتر باشد.',
        ]);
        
        $internshipRequest->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
            'reviewed_at' => now(),
        ]);

        return redirect()->route('admin.internship-requests.index')
            ->with('success', 'درخواست کارآموزی دانش‌آموز ' . $internshipRequest->student->first_name . ' ' . $internshipRequest->student->last_name . ' رد شد.');
    }

    public function destroy($id)
    {
        $internshipRequest = InternshipRequest::findOrFail($id);
        $studentName = $internshipRequest->student->first_name . ' ' . $internshipRequest->student->last_name;
        $internshipRequest->delete();
        
        return redirect()->route('admin.internship-requests.index')
            ->with('success', 'درخواست کارآموزی ' . $studentName . ' حذف شد.');
    }

    // ========== متد حذف گروهی (جدید) ==========
    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        
        if (empty($ids)) {
            return redirect()->route('admin.internship-requests.index')
                ->with('error', 'هیچ درخواستی انتخاب نشده است.');
        }
        
        $count = InternshipRequest::whereIn('id', $ids)->delete();
        
        return redirect()->route('admin.internship-requests.index')
            ->with('success', $count . ' درخواست با موفقیت حذف شد.');
    }
}