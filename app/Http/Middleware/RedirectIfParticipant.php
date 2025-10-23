<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfParticipant
{
    public function handle(Request $request, Closure $next, $guard = 'participant')
    {
        if (Auth::guard($guard)->check()) {
            return redirect('/participant/dashboard');
        }

        return $next($request);
    }
}
