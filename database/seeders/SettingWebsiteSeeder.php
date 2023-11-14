<?php

namespace Database\Seeders;

use App\Models\SettingWebsite;
use Illuminate\Database\Seeder;

class SettingWebsiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SettingWebsite::insert([
            ['key' => 'TEXT_WEB_TITLE', 'value' => 'Confess', "flag_active" => "Y"],
            ['key' => 'TEXT_WEB_LOCATION', 'value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.5768925963066!2d106.63556391455468!3d-6.187333395520691!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f929162547c7%3A0xbbf35137362e584d!2sSMK%20Negeri%204%20Kota%20Tangerang!5e0!3m2!1sid!2sid!4v1677921080826!5m2!1sid!2sid" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>', "flag_active" => "Y"],
            ['key' => 'IMAGE_WEB_LOGO_WHITE', 'value' => 'logoT.png', "flag_active" => "Y"],
            ['key' => 'IMAGE_WEB_LOGO', 'value' => 'logo-dashboard.png', "flag_active" => "Y"],
            ['key' => 'IMAGE_WEB_FAVICON', 'value' => 'logo.png', "flag_active" => "Y"],
            ['key' => 'TEXT_HERO_HEADER', 'value' => 'Sistem Pengakuan Online SMKN 4 Kota Tangerang', "flag_active" => "Y"],
            ['key' => 'TEXT_HERO_DESCRIPTION', 'value' => 'Sampaikan pengakuan, laporan, kritik, atau saran kamu di sini~', "flag_active" => "Y"],
            ['key' => 'IMAGE_FOOTER', 'value' => 'logo-smkn-4.png', "flag_active" => "Y"],
            ['key' => 'TEXT_FOOTER', 'value' => 'SMK Negeri 4 Tangerang', "flag_active" => "Y"],
            ['key' => 'IMAGE_FOOTER_DASHBOARD', 'value' => 'logo-smkn-4.png', "flag_active" => "Y"],
            ['key' => 'LINK_SOCMED_INSTAGRAM', 'value' => 'https://instagram.com/smkn4kotatangerang', "flag_active" => "Y"],
        ]);
    }
}
