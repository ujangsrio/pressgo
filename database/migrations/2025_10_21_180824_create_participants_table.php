<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_participants_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('participants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('nim')->unique(); // NIM atau ID peserta
            $table->string('institution'); // Universitas/Sekolah
            $table->string('program_type'); // Magang/PKL
            $table->string('barcode_id')->unique(); // ID barcode unik
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participants');
    }
};
