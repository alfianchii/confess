<?php

namespace Database\Seeders;

use App\Models\RecConfessionComment;
use Illuminate\Database\Seeder;

class RecConfessionCommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RecConfessionComment::factory(1000)->create();
    }
}
