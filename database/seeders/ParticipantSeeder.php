<?php
// database/seeders/ParticipantSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Participant;

class ParticipantSeeder extends Seeder
{
    public function run()
    {
        $participants = [
            [
                'name' => 'Ahmad Rizki',
                'email' => 'ahmad@example.com',
                'nim' => '20210001',
                'institution' => 'Universitas Indonesia',
                'program_type' => 'Magang',
                'barcode_id' => 'MAGANG001'
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'nim' => '20210002',
                'institution' => 'Universitas Gadjah Mada',
                'program_type' => 'PKL',
                'barcode_id' => 'PKL001'
            ],
            // Tambahkan data lain sesuai kebutuhan
        ];

        foreach ($participants as $participant) {
            Participant::create($participant);
        }
    }
}
