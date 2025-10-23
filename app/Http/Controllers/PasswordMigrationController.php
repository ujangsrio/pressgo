<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PasswordMigrationController extends Controller
{
    public function migratePasswords()
    {
        $participants = DB::table('participants')->get();

        $updated = 0;
        foreach ($participants as $participant) {
            // Jika password masih berupa NIM (plain text), hash passwordnya
            if ($participant->password === $participant->nim) {
                DB::table('participants')
                    ->where('id', $participant->id)
                    ->update([
                        'password' => Hash::make($participant->nim)
                    ]);
                $updated++;
            }
            // Jika password masih plain text lainnya, hash juga
            elseif (
                !password_verify($participant->nim, $participant->password) &&
                strlen($participant->password) < 60
            ) { // Password hashed biasanya 60 chars
                DB::table('participants')
                    ->where('id', $participant->id)
                    ->update([
                        'password' => Hash::make($participant->password)
                    ]);
                $updated++;
            }
        }

        return "Berhasil meng-update {$updated} password peserta.";
    }
}
