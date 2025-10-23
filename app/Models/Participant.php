<?php
// app/Models/Participant.php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'nim',
        'institution',
        'program_type',
        'gambar',
        'barcode_id',
        'username',
        'tanggal_lahir',
        'tanggal_bergabung',
        'phone',
        'department',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $appends = ['qr_code_url', 'umur', 'tanggal_lahir_formatted', 'tanggal_bergabung_formatted'];

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    // Method untuk mendapatkan URL gambar
    public function getGambarUrlAttribute()
    {
        if ($this->gambar) {
            // Cek jika gambar sudah berupa URL lengkap (untuk kompatibilitas)
            if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
                return $this->gambar;
            }

            // Cek jika gambar disimpan di storage
            if (strpos($this->gambar, 'participants/') === 0) {
                return asset('storage/' . $this->gambar);
            }

            // Default: gambar di public/images/participants
            return asset('images/participants/' . $this->gambar);
        }

        return asset('images/default-avatar.png');
    }

    // Method untuk mendapatkan URL QR Code
    public function getQrCodeUrlAttribute()
    {
        return route('participants.qr-code', $this->barcode_id);
    }

    // Method untuk generate QR Code data (digunakan di view)
    public function getQrCodeDataAttribute()
    {
        return [
            'participant_id' => $this->barcode_id,
            'name' => $this->name,
            'nim' => $this->nim,
            'program_type' => $this->program_type
        ];
    }

    public function getUmurAttribute()
    {
        if ($this->tanggal_lahir) {
            return Carbon::parse($this->tanggal_lahir)->age;
        }
        return null;
    }

    public function getTanggalLahirFormattedAttribute()
    {
        if ($this->tanggal_lahir) {
            return Carbon::parse($this->tanggal_lahir)->format('d/m/Y');
        }
        return '-';
    }

    // Method untuk format tanggal bergabung
    public function getTanggalBergabungFormattedAttribute()
    {
        if ($this->tanggal_bergabung) {
            return Carbon::parse($this->tanggal_bergabung)->format('d/m/Y');
        }
        return '-';
    }

    // Boot method untuk generate username otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($participant) {
            // Generate username otomatis jika kosong
            if (empty($participant->username) && $participant->name && $participant->tanggal_lahir) {
                $namaPart = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $participant->name), 0, 2));
                $tanggalPart = Carbon::parse($participant->tanggal_lahir)->format('dmY');
                $participant->username = $namaPart . $tanggalPart;
            }
        });

        static::updating(function ($participant) {
            // Regenerate username jika nama atau tanggal lahir berubah
            if (($participant->isDirty('name') || $participant->isDirty('tanggal_lahir')) &&
                $participant->name && $participant->tanggal_lahir
            ) {
                $namaPart = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $participant->name), 0, 2));
                $tanggalPart = Carbon::parse($participant->tanggal_lahir)->format('dmY');
                $participant->username = $namaPart . $tanggalPart;
            }
        });
    }
}
