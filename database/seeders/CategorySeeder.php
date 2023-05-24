<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ["name" => "Penindasan", "slug" => "penindasan", "description" => "Tindakan yang merugikan seseorang atau kelompok dengan memaksa, mengintimidasi, atau membatasi kebebasannya."],
            ["name" => "Pelecehan Seksual", "slug" => "pelecehan-seksual", "description" => "Tindakan yang dilakukan oleh seseorang terhadap orang lain yang dianggap sebagai tindakan tidak senonoh atau tidak diinginkan secara seksual."],
            ["name" => "Bully", "slug" => "bully", "description" => "Intimidasi atau penganiayaan terhadap seseorang atau kelompok orang secara berulang dan sengaja."],
            ["name" => "Kekerasan", "slug" => "kekerasan", "description" => "Tindakan yang dilakukan oleh seseorang atau kelompok orang yang menyebabkan orang lain menderita atau merasa takut menderita, cedera, sakit, atau kematian."],
            ["name" => "Pencurian", "slug" => "pencurian", "description" => "Tindakan mengambil barang milik orang lain tanpa izin."],
            ["name" => "Pembakaran", "slug" => "pembakaran", "description" => "Tindakan membakar barang milik orang lain tanpa izin."],
            ["name" => "Pengrusakan", "slug" => "pengrusakan", "description" => "Tindakan merusak barang milik orang lain tanpa izin."],
            ["name" => "Pembuangan Sampah Sembarangan", "slug" => "pembuangan-sampah-sembarangan", "description" => "Tindakan membuang sampah di tempat yang tidak semestinya."],
            ["name" => "Pembuangan Air Kotor Sembarangan", "slug" => "pembuangan-air-kotor-sembarangan", "description" => "Tindakan membuang air kotor di tempat yang tidak semestinya."],
            ["name" => "Pemalakan", "slug" => "pemalakan", "description" => "Tindakan meminta uang atau barang secara paksa."],
            ["name" => "Obat-obatan", "slug" => "obat-obatan", "description" => "Tindakan mengonsumsi obat-obatan terlarang."],
        ]);
    }
}
