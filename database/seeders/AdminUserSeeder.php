<?php
// database/seeders/AdminUserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada data admin
        if (Admin::count() === 0) {
            Admin::create([
                'name' => 'Administrator',
                'email' => 'admin@absensi.com',
                'username' => 'admin',
                'password' => Hash::make('password123'),
            ]);

            Admin::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@absensi.com',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin123'),
            ]);

            $this->command->info('Admin users created successfully!');
        } else {
            $this->command->info('Admin users already exist.');
        }
    }
}
