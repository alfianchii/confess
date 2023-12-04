<?php

namespace Database\Seeders;

use App\Models\HistoryConfessionLike;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HistoryConfessionLikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        HistoryConfessionLike::insert([
            ["id_user" => 1, "id_confession" => 1, "created_at" => now()],
            ["id_user" => 2, "id_confession" => 1, "created_at" => now()],
            ["id_user" => 3, "id_confession" => 1, "created_at" => now()],
            ["id_user" => 4, "id_confession" => 2, "created_at" => now()],
            ["id_user" => 5, "id_confession" => 2, "created_at" => now()],
            ["id_user" => 6, "id_confession" => 2, "created_at" => now()],
            ["id_user" => 7, "id_confession" => 3, "created_at" => now()],
            ["id_user" => 8, "id_confession" => 3, "created_at" => now()],
            ["id_user" => 9, "id_confession" => 3, "created_at" => now()],
            ["id_user" => 10, "id_confession" => 4, "created_at" => now()],
            ["id_user" => 1, "id_confession" => 4, "created_at" => now()],
            ["id_user" => 2, "id_confession" => 4, "created_at" => now()],
            ["id_user" => 3, "id_confession" => 5, "created_at" => now()],
            ["id_user" => 4, "id_confession" => 5, "created_at" => now()],
            ["id_user" => 5, "id_confession" => 5, "created_at" => now()],
            ["id_user" => 6, "id_confession" => 6, "created_at" => now()],
            ["id_user" => 7, "id_confession" => 6, "created_at" => now()],
            ["id_user" => 8, "id_confession" => 6, "created_at" => now()],
            ["id_user" => 9, "id_confession" => 7, "created_at" => now()],
            ["id_user" => 10, "id_confession" => 7, "created_at" => now()],
            ["id_user" => 1, "id_confession" => 7, "created_at" => now()],
            ["id_user" => 2, "id_confession" => 9, "created_at" => now()],
            ["id_user" => 3, "id_confession" => 9, "created_at" => now()],
            ["id_user" => 4, "id_confession" => 9, "created_at" => now()],
            ["id_user" => 5, "id_confession" => 10, "created_at" => now()],
            ["id_user" => 6, "id_confession" => 10, "created_at" => now()],
            ["id_user" => 7, "id_confession" => 10, "created_at" => now()],
        ]);
    }
}
