<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(MasterUserSeeder::class);
        $this->call(MasterRoleSeeder::class);
        $this->call(MasterUserRoleSeeder::class);
        $this->call(DTStudentsSeeder::class);
        $this->call(DTOfficersSeeder::class);
        $this->call(MasterConfessionCategorySeeder::class);
        $this->call(RecConfessionSeeder::class);
        $this->call(HistoryConfessionResponseSeeder::class);
        $this->call(RecConfessionCommentSeeder::class);
        $this->call(HistoryLoginSeeder::class);
        $this->call(SettingWebsiteSeeder::class);
    }
}