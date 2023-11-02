<?php

namespace Database\Seeders;

use App\Models\DTStudent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DTStudentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define an array of data to be updated or inserted
        $records = [
            // Students
            [
                "id_user" => 3,
                "nisn" => '1234567890',
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 4,
                "nisn" => '0987654321',
                "flag_active" => "Y",
                "created_at" => now(),
            ],
            [
                "id_user" => 5,
                "nisn" => '6789012345',
                "flag_active" => "Y",
                "created_at" => now(),
            ],
        ];

        // Loop through the data and update or insert as needed
        foreach ($records as $record) {
            DTStudent::updateOrInsert(
                ['id_user' => $record["id_user"]], // Condition for updating
                $record, // Data to be updated or inserted
            );
        }
    }
}
