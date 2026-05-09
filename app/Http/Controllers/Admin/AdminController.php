<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // تابع تبدیل تاریخ میلادی به شمسی
    private function toJalali($date)
    {
        if (!$date) return '-';
        
        $timestamp = strtotime($date);
        $year = date('Y', $timestamp);
        $month = date('m', $timestamp);
        $day = date('d', $timestamp);
        
        // تبدیل ساده (برای استفاده دقیق بهتره از پکیج استفاده کنی)
        $jalaliMonths = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        
        return $year . '/' . $month . '/' . $day;
    }
    
    public function dashboard()
    {
        // آمار کلی
        $totalStudents = Student::count();
        $activeStudents = Student::where('is_active', 1)->count();
        $inactiveStudents = Student::where('is_active', 0)->count();
        
        // تعداد رشته‌های منحصر به فرد
        $totalMajors = Student::distinct('major')->count('major');
        
        // آمار بر اساس پایه
        $gradeStats = Student::select('grade', \DB::raw('count(*) as total'))
            ->groupBy('grade')
            ->pluck('total', 'grade')
            ->toArray();
        
        // آمار بر اساس رشته
        $majorStats = Student::select('major', \DB::raw('count(*) as total'))
            ->groupBy('major')
            ->pluck('total', 'major')
            ->toArray();
        
        // آخرین 10 دانش آموز
        $recentStudents = Student::latest()->take(10)->get();
        
        return view('admin.dashboard', compact(
            'totalStudents',
            'activeStudents', 
            'inactiveStudents',
            'totalMajors',
            'gradeStats',
            'majorStats',
            'recentStudents'
        ));
    }
}