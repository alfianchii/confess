<?php

namespace Database\Seeders;

use App\Models\RecConfession;
use Illuminate\Database\Seeder;

class RecConfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecConfession::factory(1000)->create();
    }
}
