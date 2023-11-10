<?php

namespace Database\Seeders;

use App\Models\MasterRole;
use Illuminate\Database\Seeder;

class MasterRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterRole::insert([
            [
                "id_role" => 1,
                "role_name" => "admin",
                "description" => "Administrator",
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_role" => 2,
                "role_name" => "officer",
                "description" => "Officer",
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_role" => 3,
                "role_name" => "student",
                "description" => "Student",
                "flag_active" => "Y",
                "created_at" => now(),
            ],
        ]);
    }
}