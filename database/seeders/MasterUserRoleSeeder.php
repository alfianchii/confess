<?php

namespace Database\Seeders;

use App\Models\MasterUserRole;
use Illuminate\Database\Seeder;

class MasterUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MasterUserRole::insert([
            // Admins
            [
                "id_user" => 1,
                "id_role" => 1,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 2,
                "id_role" => 1,
                "flag_active" => "Y",
                "created_at" => now(),
            ],

            // Students
            [
                "id_user" => 3,
                "id_role" => 3,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 4,
                "id_role" => 3,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 5,
                "id_role" => 3,
                "flag_active" => "Y",
                "created_at" => now(),
            ],

            // Officers
            [
                "id_user" => 6,
                "id_role" => 2,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 7,
                "id_role" => 2,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 8,
                "id_role" => 2,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 9,
                "id_role" => 2,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 10,
                "id_role" => 2,
                "flag_active" => "Y",
                "created_at" => now(),
            ],
        ]);
    }
}