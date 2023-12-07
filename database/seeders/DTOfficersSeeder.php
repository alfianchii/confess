<?php

namespace Database\Seeders;

use App\Models\DTOfficer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DTOfficersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $records = [
            // Admins
            [
                "id_user" => 1,
                "nip" => '123456789012345678',
                "flag_active" => "Y",
            ],
            [
                "id_user" => 2,
                "nip" => '567816789012342345',
                "flag_active" => "Y",
            ],
            // Officers
            [
                "id_user" => 6,
                "nip" => '876543210987654321',
                "flag_active" => "Y",
            ],
            [
                "id_user" => 7,
                "nip" => '012345678123456789',
                "flag_active" => "Y",
            ],
            [
                "id_user" => 8,
                "nip" => '987654321876543210',
                "flag_active" => "Y",
            ],
            [
                "id_user" => 9,
                "nip" => '215432109876587643',
                "flag_active" => "Y",
            ],
            [
                "id_user" => 10,
                "nip" => '321541092876764358',
                "flag_active" => "Y",
            ],
        ];

        foreach ($records as $record) {
            DTOfficer::updateOrInsert(
                ['id_user' => $record['id_user']],
                $record,
            );
        }
    }
}
