<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\InternshipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{

    public function index(Request $request)
    {
        $query = Student::query();
        
        // فیلتر بر اساس پایه
        if ($request->has('grade') && $request->grade != '') {
            $query->where('grade', $request->grade);
        }
        
        // فیلتر بر اساس رشته
        if ($request->has('major') && $request->major != '') {
            $query->where('major', $request->major);
        }
        
        // جستجوی عمومی
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('national_code', 'like', "%{$search}%");
            });
        }
        
        $students = $query->latest()->get();
        $count = $students->count();
        
        $selectedGrade = $request->grade;
        $selectedMajor = $request->major;
        $searchTerm = $request->search;
        
        return view('admin.students.index', compact('students', 'count', 'selectedGrade', 'selectedMajor', 'searchTerm'));
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required|regex:/^09[0-9]{9}$/|unique:students',
            'national_code' => 'required|digits:10|unique:students', 
            'major'      => 'required',
            'grade'      => 'required',
        ]);

        Student::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'national_code' => $request->national_code,
            'major'      => $request->major,
            'grade'      => $request->grade,
            'password'   => Hash::make($request->national_code),
            'is_active'  => 1,
            'must_change_password' => 1,
        ]);

        return redirect()->route('students.index')->with('success', 'دانش‌آموز با موفقیت اضافه شد.');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'phone'      => 'required|regex:/^09[0-9]{9}$/|unique:students,phone,' . $id,
            'national_code' => 'required|digits:10|unique:students,national_code,' . $id,
            'major'      => 'required',
            'grade'      => 'required',
        ]);

        $student->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'national_code' => $request->national_code,
            'major'      => $request->major,
            'grade'      => $request->grade,
        ]);

        return redirect()->route('students.index')->with('success', 'دانش‌آموز با موفقیت ویرایش شد.');
    }

    // حذف تکی دانش‌آموز (به همراه درخواست‌های کارآموزی)
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        // حذف تمام درخواست‌های کارآموزی این دانش‌آموز
        InternshipRequest::where('student_id', $id)->delete();
        
        // حذف خود دانش‌آموز
        $student->delete();
        
        return redirect()->route('students.index')
            ->with('success', 'دانش‌آموز و تمام درخواست‌های کارآموزی او با موفقیت حذف شدند.');
    }

    // حذف گروهی بر اساس پایه (به همراه درخواست‌های کارآموزی)
    public function deleteByGrade($grade)
    {
        // پیدا کردن همه دانش‌آموزان این پایه
        $students = Student::where('grade', $grade)->get();
        
        // حذف درخواست‌های کارآموزی هر دانش‌آموز
        foreach($students as $student) {
            InternshipRequest::where('student_id', $student->id)->delete();
        }
        
        // حذف خود دانش‌آموزان
        $count = Student::where('grade', $grade)->delete();
        
        return redirect()->route('students.index')
            ->with('success', $count . ' دانش‌آموز پایه ' . $grade . ' و تمام درخواست‌های کارآموزی آنها با موفقیت حذف شدند.');
    }
    
    // حذف همه دانش‌آموزان (به همراه درخواست‌های کارآموزی)
    public function deleteAll()
    {
        // حذف همه درخواست‌های کارآموزی
        InternshipRequest::truncate();
        
        // حذف همه دانش‌آموزان
        $count = Student::count();
        Student::truncate();
        
        return redirect()->route('students.index')
            ->with('success', 'همه دانش‌آموزان (' . $count . ' نفر) و تمام درخواست‌های کارآموزی آنها با موفقیت حذف شدند.');
    }
}