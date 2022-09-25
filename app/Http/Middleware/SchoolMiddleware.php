<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SchoolMiddleware
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
        // $this->middleware('boardingSchool');
        if(Auth::check()){
            // dd(getSchoolPid());
            if(getSchoolPid()){
                return $next($request);
            }
            return redirect()->route('users.dashboard')->with('error',"You're Cought Up For Now, follow the right channel");
        }
        return redirect()->route('login')->with('error','Loging in is the first step for now');
       
    }
}
