<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_logged_in')) {
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }
        
        if (session('user_type') !== 'admin') {
            return redirect()->route('student.dashboard')->with('error', 'شما به این بخش دسترسی ندارید.');
        }
        
        return $next($request);
    }
}