<?php
// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->withErrors([
                'message' => 'Silakan login sebagai admin untuk mengakses halaman ini.'
            ]);
        }

        return $next($request);
    }
}
