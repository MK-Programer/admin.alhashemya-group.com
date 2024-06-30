<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ActiveUserMiddleware
{
    public function handle($request, Closure $next)
    {
        $authUser = Auth::user();
        // Check if the user is active
        if ($authUser->is_active == true) {
            return $next($request);
        } else {
            // User is not active, logout the user and redirect to login page
            Auth::logout();
            return redirect()->route('login')->with('danger', 'Your account is not active :)');
        }
    }
}
