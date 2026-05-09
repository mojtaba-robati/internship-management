<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StudentAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('student_logged_in')) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }
        
        if (session('user_type') !== 'student') {
            return redirect()->route('admin.dashboard')->with('error', 'شما به این بخش دسترسی ندارید.');
        }
        
        return $next($request);
    }
}