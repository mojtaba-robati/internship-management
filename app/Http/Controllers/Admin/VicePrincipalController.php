<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class VicePrincipalController extends Controller
{
    public function index()
    {
        $vicePrincipals = Admin::where('role', 'vice_principal')->get();
        return view('admin.vice-principals.index', compact('vicePrincipals'));
    }

    public function create()
    {
        return view('admin.vice-principals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:admins,phone',
            'national_code' => 'required|digits:10|unique:admins,national_code',
            'password' => 'required|min:4',
        ], [
            'first_name.required' => 'وارد کردن نام الزامی است',
            'last_name.required' => 'وارد کردن نام خانوادگی الزامی است',
            'phone.required' => 'وارد کردن شماره موبایل الزامی است',
            'phone.regex' => 'شماره موبایل باید 11 رقم و با 09 شروع شود',
            'phone.unique' => 'این شماره موبایل قبلاً ثبت شده است',
            'national_code.required' => 'وارد کردن کد ملی الزامی است',
            'national_code.digits' => 'کد ملی باید دقیقاً 10 رقم باشد',
            'national_code.unique' => 'این کد ملی قبلاً ثبت شده است',
            'password.required' => 'وارد کردن رمز عبور الزامی است',
            'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد',
        ]);

        Admin::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'national_code' => $request->national_code,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'vice_principal',
        ]);

        return redirect()->route('vice-principals.index')
            ->with('success', 'معاون آموزشی با موفقیت اضافه شد.');
    }

    // نمایش فرم ویرایش معاون
    public function edit($id)
    {
        $vicePrincipal = Admin::findOrFail($id);
        
        // جلوگیری از ویرایش ادمین اصلی
        if ($vicePrincipal->role == 'admin') {
            return redirect()->route('vice-principals.index')
                ->with('error', 'نمی‌توانید مدیر اصلی را ویرایش کنید.');
        }
        
        return view('admin.vice-principals.edit', compact('vicePrincipal'));
    }

    // بروزرسانی اطلاعات معاون
    public function update(Request $request, $id)
    {
        $vicePrincipal = Admin::findOrFail($id);
        
        // جلوگیری از ویرایش ادمین اصلی
        if ($vicePrincipal->role == 'admin') {
            return redirect()->route('vice-principals.index')
                ->with('error', 'نمی‌توانید مدیر اصلی را ویرایش کنید.');
        }
        
        $request->validate([
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'phone' => 'required|regex:/^09[0-9]{9}$/|unique:admins,phone,' . $id,
            'national_code' => 'required|digits:10|unique:admins,national_code,' . $id,
            'password' => 'nullable|min:4',
        ], [
            'first_name.required' => 'وارد کردن نام الزامی است',
            'last_name.required' => 'وارد کردن نام خانوادگی الزامی است',
            'phone.required' => 'وارد کردن شماره موبایل الزامی است',
            'phone.regex' => 'شماره موبایل باید 11 رقم و با 09 شروع شود',
            'phone.unique' => 'این شماره موبایل قبلاً ثبت شده است',
            'national_code.required' => 'وارد کردن کد ملی الزامی است',
            'national_code.digits' => 'کد ملی باید دقیقاً 10 رقم باشد',
            'national_code.unique' => 'این کد ملی قبلاً ثبت شده است',
            'password.min' => 'رمز عبور باید حداقل 4 کاراکتر باشد',
        ]);

        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'national_code' => $request->national_code,
        ];
        
        // اگر رمز عبور وارد شده بود، اون رو هم آپدیت کن
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        
        $vicePrincipal->update($data);

        return redirect()->route('vice-principals.index')
            ->with('success', 'اطلاعات معاون آموزشی با موفقیت ویرایش شد.');
    }

    public function destroy($id)
    {
        $vicePrincipal = Admin::findOrFail($id);
        
        if ($vicePrincipal->role == 'admin') {
            return redirect()->route('vice-principals.index')
                ->with('error', 'نمی‌توانید مدیر اصلی را حذف کنید.');
        }
        
        $vicePrincipal->delete();

        return redirect()->route('vice-principals.index')
            ->with('success', 'معاون آموزشی حذف شد.');
    }
}