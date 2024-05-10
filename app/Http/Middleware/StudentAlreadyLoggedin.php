<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class StudentAlreadyLoggedIn
{
    public function handle($request, Closure $next)
    {
        if (Auth::guard('student')->check()) {
            if (in_array(Route::currentRouteName(), ['student_signup'])) {
                return redirect()->route('studentDashboard');
            }
        }

        return $next($request);
    }
}
