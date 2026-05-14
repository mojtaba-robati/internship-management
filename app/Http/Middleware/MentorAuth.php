<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MentorAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('mentor_logged_in')) {
            // هدایت به صفحه لاگین اصلی (نه mentor.login)
            return redirect()->route('login')->with('error', 'لطفاً ابتدا وارد شوید.');
        }
        
        return $next($request);
    }
}