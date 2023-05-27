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
            ['key' => 'WEB_LOCATION', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.5768925963066!2d106.63556391455468!3d-6.187333395520691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f929162547c7%3A0xbbf35137362e584d!2sSMK%20Negeri%204%20Kota%20Tangerang!5e0!3m2!1sid!2sid!4v1677921080826!5m2!1sid!2sid" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'],
            ['key' => 'WEB_LOGO_WHITE', 'value' => 'logoT.png'],
            ['key' => 'WEB_LOGO', 'value' => 'logoT.png'],
            ['key' => 'WEB_FAVICON', 'value' => 'logo.png'],
            ['key' => 'HERO_TEXT_HEADER', 'value' => 'Sistem Pengaduan Online SMKN 4 Kota Tangerang'],
            ['key' => 'HERO_TEXT_DESCRIPTION', 'value' => 'Sampaikan laporan, kritik, atau saran kamu di website ini~'],
            ['key' => 'FOOTER_IMAGE', 'value' => 'logo-smk-4.png'],
            ['key' => 'FOOTER_TEXT_DASHBOARD', 'value' => 'SMK Negeri 4 Tangerang'],
            ['key' => 'FOOTER_IMAGE_DASHBOARD', 'value' => 'smk.png'],
        ]);
    }
}
