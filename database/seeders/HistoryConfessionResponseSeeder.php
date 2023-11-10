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
        HistoryConfessionResponse::factory(1000)->create();
    }
}
