<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActiveUserMiddleware
{
    public function handle($request, Closure $next)
    {
        // Check if user is authenticated
        if (Auth::check()) {
            // Check if the user is active
            if (Auth::user()->is_active == true) {
                return $next($request);
            } else {
                // User is not active, logout the user and redirect to login page
                Auth::logout();
                return redirect()->route('login')->with('danger', 'Your account is not active :)');
            }
        }

        // User is not authenticated, redirect to login
        return redirect()->route('login');
    }
}
