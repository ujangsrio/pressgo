<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Brand Settings
            [
                'key' => 'brand_name',
                'value' => 'BRAND NAME',
                'type' => 'text',
                'group' => 'brand',
                'description' => 'Nama brand yang ditampilkan di ID Card'
            ],
            [
                'key' => 'brand_subtitle',
                'value' => 'INTERNSHIP PROGRAM',
                'type' => 'text',
                'group' => 'brand',
                'description' => 'Subtitle brand di bawah nama brand'
            ],
            [
                'key' => 'company_name',
                'value' => 'Company Name Inc.',
                'type' => 'text',
                'group' => 'brand',
                'description' => 'Nama perusahaan lengkap'
            ],

            // Contact Settings
            [
                'key' => 'contact_phone',
                'value' => '+62 812-3456-7890',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Nomor telepon perusahaan'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@brandname.com',
                'type' => 'email',
                'group' => 'contact',
                'description' => 'Email perusahaan'
            ],
            [
                'key' => 'contact_website',
                'value' => 'www.brandname.com',
                'type' => 'text',
                'group' => 'contact',
                'description' => 'Website perusahaan'
            ],
            [
                'key' => 'contact_address',
                'value' => 'Jl. Contoh Alamat No. 123, Jakarta, Indonesia',
                'type' => 'textarea',
                'group' => 'contact',
                'description' => 'Alamat perusahaan'
            ],

            // ID Card Design Settings
            [
                'key' => 'id_card_validity_months',
                'value' => '12',
                'type' => 'number',
                'group' => 'design',
                'description' => 'Masa berlaku ID Card dalam bulan'
            ],
            [
                'key' => 'front_background',
                'value' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                'type' => 'text',
                'group' => 'design',
                'description' => 'Background depan ID Card (CSS gradient/color)'
            ],
            [
                'key' => 'back_background',
                'value' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)',
                'type' => 'text',
                'group' => 'design',
                'description' => 'Background belakang ID Card (CSS gradient/color)'
            ],
            [
                'key' => 'terms_conditions',
                'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis elit sapien, convallis vell enim sit amet. This card is property of Brand Name and must be returned upon termination of program. Loss or theft must be reported immediately.',
                'type' => 'textarea',
                'group' => 'design',
                'description' => 'Syarat dan ketentuan yang ditampilkan di belakang ID Card'
            ],
            [
                'key' => 'show_barcode_front',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'design',
                'description' => 'Tampilkan barcode di sisi depan ID Card'
            ],
            [
                'key' => 'show_barcode_back',
                'value' => '1',
                'type' => 'checkbox',
                'group' => 'design',
                'description' => 'Tampilkan barcode di sisi belakang ID Card'
            ],

            // System Settings
            [
                'key' => 'auto_print_id_card',
                'value' => '0',
                'type' => 'checkbox',
                'group' => 'system',
                'description' => 'Otomatis print ID Card setelah generate'
            ],
            [
                'key' => 'id_card_size_width',
                'value' => '350',
                'type' => 'number',
                'group' => 'system',
                'description' => 'Lebar ID Card dalam pixel'
            ],
            [
                'key' => 'id_card_size_height',
                'value' => '500',
                'type' => 'number',
                'group' => 'system',
                'description' => 'Tinggi ID Card dalam pixel'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
