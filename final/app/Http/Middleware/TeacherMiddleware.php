<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    
        if (auth()->check() && auth()->user()->user_type === 'teacher') {
            return $next($request);
        }


        return redirect('/dashboard')->with('error', 'Access denied. Only teachers are allowed to perform this action.');
    }
}
