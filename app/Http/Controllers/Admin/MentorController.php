<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mentor;
use Illuminate\Http\Request;

class MentorController extends Controller
{
    // نمایش لیست مربیان
    public function index()
    {
        $mentors = Mentor::latest()->get();
        return view('admin.mentors.index', compact('mentors'));
    }
    
    // نمایش فرم ایجاد مربی
    public function create()
    {
        return view('admin.mentors.create');
    }
    
    // ذخیره مربی جدید
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'national_code' => 'required|digits:10|unique:mentors',
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:mentors',
            'password' => 'required|min:4',
        ], [
            'first_name.required' => 'وارد کردن نام الزامی است',
            'last_name.required' => 'وارد کردن نام خانوادگی الزامی است',
            'national_code.required' => 'وارد کردن کد ملی الزامی است',
            'national_code.digits' => 'کد ملی باید 10 رقم باشد',
            'national_code.unique' => 'این کد ملی قبلاً ثبت شده است',
            'phone.required' => 'وارد کردن شماره موبایل الزامی است',
            'phone.regex' => 'شماره موبایل باید 11 رقم و با 09 شروع شود',
            'phone.unique' => 'این شماره موبایل قبلاً ثبت شده است',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد',
        ]);
        
        Mentor::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'phone' => $request->phone,
            'password' => $request->password,
            'status' => 'active',
        ]);
        
        return redirect()->route('mentors.index')
            ->with('success', 'مربی با موفقیت اضافه شد.');
    }
    
    // نمایش فرم ویرایش مربی
    public function edit($id)
    {
        $mentor = Mentor::findOrFail($id);
        return view('admin.mentors.edit', compact('mentor'));
    }
    
    // بروزرسانی مربی
    public function update(Request $request, $id)
    {
        $mentor = Mentor::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'national_code' => 'required|digits:10|unique:mentors,national_code,' . $id,
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:mentors,phone,' . $id,
            'password' => 'nullable|min:4',
        ], [
            'first_name.required' => 'وارد کردن نام الزامی است',
            'last_name.required' => 'وارد کردن نام خانوادگی الزامی است',
            'national_code.required' => 'وارد کردن کد ملی الزامی است',
            'national_code.digits' => 'کد ملی باید 10 رقم باشد',
            'national_code.unique' => 'این کد ملی قبلاً ثبت شده است',
            'phone.required' => 'وارد کردن شماره موبایل الزامی است',
            'phone.regex' => 'شماره موبایل باید 11 رقم و با 09 شروع شود',
            'phone.unique' => 'این شماره موبایل قبلاً ثبت شده است',
            'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد',
        ]);
        
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'phone' => $request->phone,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        
        $mentor->update($data);
        
        return redirect()->route('mentors.index')
            ->with('success', 'مربی با موفقیت ویرایش شد.');
    }
    
    // حذف مربی
    public function destroy($id)
    {
        $mentor = Mentor::findOrFail($id);
        $mentor->delete();
        
        return redirect()->route('mentors.index')
            ->with('success', 'مربی با موفقیت حذف شد.');
    }
}