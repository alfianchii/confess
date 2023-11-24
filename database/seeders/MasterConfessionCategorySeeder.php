<?php

namespace Database\Seeders;

use App\Models\MasterConfessionCategory;
use Illuminate\Database\Seeder;

class MasterConfessionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterConfessionCategory::insert([
            ["id_confession_category" => 1, "category_name" => "Penindasan", "slug" => "penindasan", "description" => "Tindakan yang merugikan seseorang atau kelompok dengan memaksa, mengintimidasi, atau membatasi kebebasannya.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 2, "category_name" => "Pelecehan Seksual", "slug" => "pelecehan-seksual", "description" => "Tindakan yang dilakukan oleh seseorang terhadap orang lain yang dianggap sebagai tindakan tidak senonoh atau tidak diinginkan secara seksual.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 3, "category_name" => "Bully", "slug" => "bully", "description" => "Intimidasi atau penganiayaan terhadap seseorang atau kelompok orang secara berulang dan sengaja.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 4, "category_name" => "Kekerasan", "slug" => "kekerasan", "description" => "Tindakan yang dilakukan oleh seseorang atau kelompok orang yang menyebabkan orang lain menderita atau merasa takut menderita, cedera, sakit, atau kematian.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 5, "category_name" => "Pencurian", "slug" => "pencurian", "description" => "Tindakan mengambil barang milik orang lain tanpa izin.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 6, "category_name" => "Percintaan", "slug" => "percintaan", "description" => "Merepresentasikan kejadian atau polemik suatu hubungan.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 7, "category_name" => "Pembakaran", "slug" => "pembakaran", "description" => "Tindakan membakar barang milik orang lain tanpa izin.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 8, "category_name" => "Pengrusakan", "slug" => "pengrusakan", "description" => "Tindakan merusak barang milik orang lain tanpa izin.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 9, "category_name" => "Pembuangan Sampah Sembarangan", "slug" => "pembuangan-sampah-sembarangan", "description" => "Tindakan membuang sampah di tempat yang tidak semestinya.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 10, "category_name" => "Pembuangan Air Kotor Sembarangan", "slug" => "pembuangan-air-kotor-sembarangan", "description" => "Tindakan membuang air kotor di tempat yang tidak semestinya.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 11, "category_name" => "Pemalakan", "slug" => "pemalakan", "description" => "Tindakan meminta uang atau barang secara paksa.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 12, "category_name" => "Obat-obatan", "slug" => "obat-obatan", "description" => "Tindakan mengonsumsi obat-obatan terlarang.", "created_at" => now(), "flag_active" => "Y"],
        ]);
    }
}
