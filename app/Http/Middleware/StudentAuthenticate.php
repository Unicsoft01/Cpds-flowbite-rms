<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StudentAuthenticate
{
      public function handle($request, Closure $next)
      {
            if (Auth::guard('student')->check()) {
                  // dd('stuent');
                  return $next($request);
            } else {
                  return redirect()->route('student.logins');
                  // return redirect()->To('student/login');
            }
      }
}