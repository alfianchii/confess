<?php

namespace Database\Seeders;

use App\Models\HistoryConfessionResponse;
use Illuminate\Database\Seeder;

class HistoryConfessionResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistoryConfessionResponse::insert([
            [
                "id_confession_response" => 1,
                "id_confession" => 1,
                "id_user" => 9,
                "response" => "Halo, maaf ya kamu ngalamin kejadian serem gitu.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 2,
                "id_confession" => 1,
                "id_user" => 9,
                "response" => "Saya bakal coba bantu selidiki, tapi informasi yang bisa saya dapet masih terbatas. Coba kamu kasih tau saya lebih detail, misalnya ciri-ciri orangnya atau ada yang bisa mengidentifikasinya nggak?",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 3,
                "id_confession" => 5,
                "id_user" => 10,
                "response" => "Saya ngerasa banget gimana rasanya jadi situasi kayak gitu.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 4,
                "id_confession" => 5,
                "id_user" => 10,
                "response" => "Cobain aja teriakin atau tegur langsung cowoknya, kasih tau kalo perilakunya nggak bener. Kalo masih berlanjut, langsung lapor aja ke pengemudi atau ke polisi, biar ditangani dengan serius OK.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 5,
                "id_confession" => 7,
                "id_user" => 6,
                "response" => "Kalo emang beneran guru itu kesel terus, mungkin bisa coba ngumpulin bukti kalo dia suka nge-bully murid.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 6,
                "id_confession" => 7,
                "id_user" => 6,
                "response" => "Misalnya, catet waktu dan kejadian. Kalo udah cukup, bisa lapor ke kepsek atau pihak sekolah. Kadang, mereka baru nyadar kalo udah ada bukti konkret.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 7,
                "id_confession" => 7,
                "id_user" => 6,
                "response" => "Atau kamu bisa langsung sebut nama saja di sini, ya.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
            [
                "id_confession_response" => 8,
                "id_confession" => 9,
                "id_user" => 9,
                "response" => "Unik dan kreatif! Kalo temen-temen kamu ngejek, coba kamu santai aja. Gak usah terlalu diambil pusing sama komentar orang. Kalo kamu enjoy sama hobi kamu, itu yang penting.",
                "confession_status" => "process",
                "system_response" => "N",
                "created_at" => now(),
            ],
        ]);
    }
}