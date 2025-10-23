<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ParticipantAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.participant-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari peserta berdasarkan username
        $participant = Participant::where('username', $request->username)
            ->orWhere('nim', $request->username)
            ->first();

        if (!$participant) {
            return back()->withErrors([
                'username' => 'Username/NIM tidak ditemukan.',
            ])->withInput();
        }

        $passwordValid = false;


        // Verifikasi password menggunakan Hash
        if (!Hash::check($request->password, $participant->password)) {
            return back()->withErrors([
                'password' => 'Password yang dimasukkan salah.',
            ])->withInput();
        }

        if (!$participant->is_active) {
            return back()->withErrors([
                'username' => 'Akun Anda tidak aktif.',
            ])->withInput();
        }

        // Login peserta
        Auth::guard('participant')->login($participant, $request->boolean('remember'));

        return redirect()->intended('/participant/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('participant')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login peserta setelah logout
        return redirect()->route('participant.login')->with('success', 'Anda telah berhasil logout.');
    }
}
