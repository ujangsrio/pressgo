<?php
// database/migrations/xxxx_xx_xx_xxxxxx_ensure_location_settings_exist.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        $locationSettings = [
            [
                'key' => 'attendance_location_latitude',
                'value' => '-8.224409',
                'type' => 'text',
                'group' => 'location',
                'description' => 'Latitude lokasi absensi'
            ],
            [
                'key' => 'attendance_location_longitude',
                'value' => '114.372973',
                'type' => 'text',
                'group' => 'location',
                'description' => 'Longitude lokasi absensi'
            ],
            [
                'key' => 'attendance_radius_meters',
                'value' => '100',
                'type' => 'number',
                'group' => 'location',
                'description' => 'Radius absensi dalam meter'
            ],
            [
                'key' => 'enable_location_restriction',
                'value' => '1',
                'type' => 'checkbox',
                'group' => 'location',
                'description' => 'Aktifkan pembatasan lokasi absensi'
            ],
            [
                'key' => 'location_name',
                'value' => 'MISNTV | Mav Entertainment Corporation',
                'type' => 'text',
                'group' => 'location',
                'description' => 'Nama lokasi absensi'
            ]
        ];

        foreach ($locationSettings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                array_merge($setting, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }

    public function down()
    {
        // Optional: Hapus settings jika rollback
        // DB::table('settings')->where('group', 'location')->delete();
    }
};
