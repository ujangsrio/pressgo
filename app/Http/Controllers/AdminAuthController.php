<?php
// app/Http/Controllers/AdminAuthController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke attendance
        if (Auth::check()) {
            return redirect()->route('dashboard.index');
        }

        return view('auth.admin-login');
    }

    // Process login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari admin by username
        $admin = Admin::where('username', $credentials['username'])->first();

        // Check password dan login
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            // Login menggunakan Auth facade biasa
            Auth::login($admin, $request->boolean('remember'));

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
