<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            // dd(getSchoolPid());
            if (schoolAdmin()) {
                return $next($request);
            }
            return redirect()->route('my.school.dashboard')->with('error', "You do not have admin right");
        }
        return redirect()->route('login')->with('error', 'Loging in is the first step for now');
        return $next($request);
    }
}
