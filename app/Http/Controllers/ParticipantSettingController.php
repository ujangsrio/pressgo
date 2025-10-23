<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ParticipantSettingController extends Controller
{
    public function index()
    {
        $participant = auth()->guard('participant')->user();
        return view('participant.settings.index', compact('participant'));
    }

    public function updateProfile(Request $request)
    {
        $participantId = auth()->guard('participant')->id();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,' . $participantId,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengupdate profil.');
        }

        DB::table('participants')
            ->where('id', $participantId)
            ->update($validator->validated());

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $participantId = auth()->guard('participant')->id();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengubah password.');
        }

        // Ambil data peserta
        $participant = DB::table('participants')->where('id', $participantId)->first();

        if (!$participant) {
            return redirect()->back()
                ->with('error', 'Peserta tidak ditemukan.');
        }

        // LOGIC VERIFIKASI PASSWORD YANG DIPERBAIKI:
        // 1. Cek jika password di database sudah di-hash
        if (password_verify($request->current_password, $participant->password)) {
            // Password sudah di-hash dan cocok
            $passwordValid = true;
        }
        // 2. Cek jika password masih berupa NIM (plain text)
        elseif ($request->current_password === $participant->nim) {
            $passwordValid = true;
        }
        // 3. Cek jika password di database masih plain text (NIM)
        elseif ($participant->password === $participant->nim) {
            $passwordValid = true;
        }
        // 4. Fallback: cek plain text
        elseif ($participant->password === $request->current_password) {
            $passwordValid = true;
        } else {
            $passwordValid = false;
        }

        if (!$passwordValid) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Password saat ini salah.'])
                ->withInput()
                ->with('error', 'Gagal mengubah password.');
        }

        // Update password baru (selalu hash)
        DB::table('participants')
            ->where('id', $participantId)
            ->update([
                'password' => Hash::make($request->new_password),
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Password berhasil diubah!');
    }

    public function updatePhoto(Request $request)
    {
        $participantId = auth()->guard('participant')->id();

        $validator = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Terjadi kesalahan dalam mengupload foto.');
        }

        if ($request->hasFile('photo')) {
            $participant = DB::table('participants')->where('id', $participantId)->first();

            if ($participant->gambar && Storage::disk('public')->exists($participant->gambar)) {
                Storage::disk('public')->delete($participant->gambar);
            }

            $imagePath = $request->file('photo')->store('participants', 'public');

            DB::table('participants')
                ->where('id', $participantId)
                ->update([
                    'gambar' => $imagePath,
                    'updated_at' => now()
                ]);
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diubah!');
    }
}
