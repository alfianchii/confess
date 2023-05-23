<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::insert([
            ['key' => 'WEB_TITLE', 'value' => 'Confess'],
            ['key' => 'WEB_LOGO_WHITE', 'value' => 'logoT.png'],
            ['key' => 'WEB_LOGO', 'value' => 'logoT.png'],
            ['key' => 'WEB_FAVICON', 'value' => 'logo.png'],
            ['key' => 'HERO_TEXT_HEADER', 'value' => 'Sistem Pengaduan Online SMKN 4 Kota Tangerang'],
            ['key' => 'HERO_TEXT_DESCRIPTION', 'value' => 'Sampaikan laporan, kritik, atau saran kamu di website ini~'],
        ]);
    }
}
