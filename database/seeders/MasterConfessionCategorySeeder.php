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
            ["id_confession_category" => 1, "category_name" => "Penindasan", "slug" => "penindasan", "description" => "mencakup laporan tentang segala bentuk penindasan, membatasi kebebasan, atau perlakuan tidak adil yang mungkin dialami seseorang atau kelompok individu.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 2, "category_name" => "Pelecehan Seksual", "slug" => "pelecehan-seksual", "description" => "Insiden pelecehan seksual atau perilaku tidak senonoh yang tidak diinginkan.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 3, "category_name" => "Bully", "slug" => "bully", "description" => "Intimidasi atau penganiayaan terhadap seseorang atau kelompok orang secara berulang dan sengaja.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 4, "category_name" => "Kekerasan", "slug" => "kekerasan", "description" => "Kejadian yang melibatkan kekerasan fisik atau ancaman serius terhadap keamanan seseorang.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 5, "category_name" => "Pencurian", "slug" => "pencurian", "description" => "Pencurian barang pribadi atau kejadian pencurian di luar atau dalam lingkungan sekolah.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 6, "category_name" => "Percintaan", "slug" => "percintaan", "description" => "Merepresentasikan polemik terhadap percintaan dalam suatu hubungan interpersonal.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 7, "category_name" => "Pembakaran", "slug" => "pembakaran", "description" => "Kejadian pembakaran atau upaya pembakaran.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 8, "category_name" => "Kerusakaan", "slug" => "kerusakan", "description" => "Kerusakan yang terjadi pada properti sekolah atau barang milik individu lainnya.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 9, "category_name" => "Sampah", "slug" => "sampah", "description" => "Keadaan atau tindakan yang melibatkan pembuangan sampah secara tidak teratur atau masalah lingkungan terkait kebersihan.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 10, "category_name" => "Lingkungan", "slug" => "lingkungan", "description" => "Terkait dengan masalah lingkungan di sekitar sekolah, seperti kerusakan alam, masalah sanitasi, atau dampak lingkungan lainnya.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 11, "category_name" => "Pemalakan", "slug" => "pemalakan", "description" => "Melibatkan situasi di mana seseorang atau sekelompok orang mendapatkan pemalakan atau tekanan secara berulang.", "created_at" => now(), "flag_active" => "Y"],
            ["id_confession_category" => 12, "category_name" => "Obat-obatan", "slug" => "obat-obatan", "description" => "Penggunaan atau distribusi obat-obatan terlarang baik di lingkungan sekolah maupun luar.", "created_at" => now(), "flag_active" => "Y"],
        ]);
    }
}
