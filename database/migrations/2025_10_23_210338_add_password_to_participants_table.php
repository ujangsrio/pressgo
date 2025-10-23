<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\Participant;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->string('password')->nullable()->after('username');
        });

        // Set password default untuk peserta yang sudah ada (password = NIM)
        $participants = Participant::all();
        foreach ($participants as $participant) {
            if (empty($participant->password) && !empty($participant->nim)) {
                $participant->password = Hash::make($participant->nim);
                $participant->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participants', function (Blueprint $table) {
            $table->dropColumn('password');
        });
    }
};
