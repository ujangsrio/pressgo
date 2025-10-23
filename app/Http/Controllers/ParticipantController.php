<?php
// app/Http/Controllers/ParticipantController.php

namespace App\Http\Controllers;

use App\Models\Participant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ParticipantController extends Controller
{
    // Menampilkan daftar peserta
    public function index()
    {
        $participants = Participant::orderBy('created_at', 'desc')
            ->paginate(15);

        $stats = [
            'total' => Participant::count(),
            'magang' => Participant::where('program_type', 'Magang')->count(),
            'pkl' => Participant::where('program_type', 'PKL')->count(),
        ];

        return view('participants.index', compact('participants', 'stats'));
    }

    // Menampilkan form tambah peserta
    public function create()
    {
        return view('participants.create');
    }

    // Menyimpan peserta baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants',
            'nim' => 'required|string|unique:participants',
            'institution' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
            'program_type' => 'required|in:Magang,PKL',
            'password' => 'nullable|string|min:6', // Tambahkan validasi password
            'gambar' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Handle upload gambar
        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageName = time() . '_' . $validated['nim'] . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/participants'), $imageName);
            $validated['gambar'] = $imageName;
        }

        // Generate username otomatis
        $validated['username'] = $this->generateUsername($validated['name'], $validated['tanggal_lahir']);

        // Generate barcode_id unik (sekarang untuk QR Code)
        $validated['barcode_id'] = $this->generateQrCodeId($validated['program_type']);

        // Set password default dari NIM jika tidak diisi
        if (empty($validated['password']) && !empty($validated['nim'])) {
            $validated['password'] = Hash::make($validated['nim']);
        } else if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        // Handle upload gambar
        // if ($request->hasFile('gambar')) {
        //     $imagePath = $request->file('gambar')->store('participants', 'public');
        //     $validated['gambar'] = $imagePath;
        // }

        // Handle password update
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']); // Jangan update password jika kosong
        }

        Participant::create($validated);

        return redirect()->route('participants.index')
            ->with('success', 'Peserta berhasil ditambahkan!');
    }

    // Menampilkan form edit peserta
    public function edit(Participant $participant)
    {
        return view('participants.edit', compact('participant'));
    }

    // Update peserta
    public function update(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'nim' => 'required|string|max:50|unique:participants,nim,' . $id,
            'institution' => 'required|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_bergabung' => 'nullable|date',
            'username' => 'nullable|string|max:255|unique:participants,username,' . $id,
            'program_type' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_active' => 'boolean',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($participant->gambar && file_exists(public_path('images/participants/' . $participant->gambar))) {
                unlink(public_path('images/participants/' . $participant->gambar));
            }

            $image = $request->file('gambar');
            $imageName = time() . '_' . $validated['nim'] . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/participants'), $imageName);
            $validated['gambar'] = $imageName;
        }

        // Handle remove image
        if ($request->remove_image) {
            if ($participant->gambar && file_exists(public_path('images/participants/' . $participant->gambar))) {
                unlink(public_path('images/participants/' . $participant->gambar));
            }
            $validated['gambar'] = null;
        }

        // Generate username otomatis jika kosong atau jika nama/tanggal lahir berubah
        if (
            empty($validated['username']) ||
            $validated['name'] !== $participant->name ||
            $validated['tanggal_lahir'] !== $participant->tanggal_lahir
        ) {

            $validated['username'] = $this->generateUsername(
                $validated['name'],
                $validated['tanggal_lahir'],
                $id // exclude current participant
            );
        }

        $participant->update($validated);

        return redirect()->route('participants.index')
            ->with('success', 'Data peserta berhasil diperbarui!');
    }

    // Method untuk generate username otomatis
    private function generateUsername($name, $tanggalLahir, $excludeParticipantId = null)
    {
        // Ambil 2 huruf pertama dari nama (uppercase, hanya huruf)
        $namaPart = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $name), 0, 2));

        // Format tanggal lahir: DDMMYYYY
        $tanggalPart = Carbon::parse($tanggalLahir)->format('dmY');

        $username = $namaPart . $tanggalPart;

        // Cek jika username sudah ada, tambahkan angka
        $counter = 1;
        $originalUsername = $username;

        $query = Participant::where('username', $username);

        // Exclude participant tertentu (untuk update)
        if ($excludeParticipantId) {
            $query->where('id', '!=', $excludeParticipantId);
        }

        while ($query->exists()) {
            $username = $originalUsername . $counter;
            $counter++;

            $query = Participant::where('username', $username);
            if ($excludeParticipantId) {
                $query->where('id', '!=', $excludeParticipantId);
            }
        }

        return $username;
    }

    // Hapus peserta
    public function destroy(Participant $participant)
    {
        // Hapus gambar jika ada
        if ($participant->gambar && file_exists(public_path('images/participants/' . $participant->gambar))) {
            unlink(public_path('images/participants/' . $participant->gambar));
        }

        $participant->delete();

        return redirect()->route('participants.index')
            ->with('success', 'Peserta berhasil dihapus!');
    }

    // Generate QR Code ID unik
    private function generateQrCodeId($programType)
    {
        $prefix = $programType === 'Magang' ? 'MAG' : 'PKL';
        $random = Str::upper(Str::random(6));

        return $prefix . $random;
    }

    // Generate QR Code untuk peserta
    // Di ParticipantController - method untuk generate QR code
    public function qrCode($barcodeId)
    {
        $participant = Participant::where('barcode_id', $barcodeId)->first();

        if (!$participant) {
            abort(404);
        }

        // Generate QR code dengan barcode_id
        $qrCode = QrCode::format('png')
            ->size(200)
            ->generate($participant->barcode_id);

        return response($qrCode)->header('Content-Type', 'image/png');
    }

    // Print QR Code
    public function qrCodePrint(Participant $participant)
    {
        return view('participants.qr-code-print', compact('participant'));
    }

    // ID Card dengan QR Code
    public function idCard(Participant $participant)
    {
        return view('participants.id-card', compact('participant'));
    }

    // Print ID Card dengan QR Code
    public function idCardPrint(Participant $participant)
    {
        return view('participants.id-card-print', compact('participant'));
    }

    // Generate semua ID Cards dengan QR Code
    public function generateAllIdCards()
    {
        $participants = Participant::all();
        return view('participants.id-cards-all', compact('participants'));
    }
}
