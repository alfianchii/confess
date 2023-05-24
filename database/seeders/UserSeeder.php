<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            // Admins
            [
                "nik" => "1234567890123456",
                "name" => "Muhammad Alfian",
                "username" => "alfianchii",
                "gender" => "L",
                "email" => "alfianganteng@gmail.com",
                "password" => Hash::make("password"),
                "level" => 'admin',
                "created_at" => now()
            ],
            [
                "nik" => "1201234563456789",
                "name" => "Munaa Raudhatul",
                "username" => "nana",
                "gender" => "P",
                "email" => "nanaa@gmail.com",
                "password" => Hash::make("password"),
                "level" => 'admin',
                "created_at" => now()
            ],
            // Students
            [
                "nik" => "1234561234567890",
                "name" => "Surya Nata",
                "username" => "nata.ardhana",
                "gender" => "L",
                "email" => "surya.dev@gmail.com",
                "password" => Hash::make("password"),
                "level" => "student",
                "created_at" => now()
            ],
            [
                "nik" => "1234556789061234",
                "name" => "Novalika Yudistira",
                "username" => "valds",
                "gender" => "L",
                "email" => "noval.yudis@gmail.com",
                "password" => Hash::make("password"),
                "level" => "student",
                "created_at" => now()
            ],
            [
                "nik" => "5678901234561234",
                "name" => "Muhammad Pasya",
                "username" => "pasyaa",
                "gender" => "L",
                "email" => "pasyaa@gmail.com",
                "password" => Hash::make("password"),
                "level" => "student",
                "created_at" => now()
            ],
            // Officers
            [
                "nik" => "1234512345667890",
                "name" => "Fauzi Abdullah",
                "username" => "fauzy",
                "gender" => "L",
                "email" => "fauzyabdullah@gmail.com",
                "password" => Hash::make("password"),
                "level" => "officer",
                "created_at" => now()
            ],
            [
                "nik" => "1234516678902345",
                "name" => "Shandy Fakhri",
                "username" => "shandi.fakhri",
                "gender" => "L",
                "email" => "shandi@gmail.com",
                "password" => Hash::make("password"),
                "level" => "officer",
                "created_at" => now()
            ],
            [
                "nik" => "1238902345451667",
                "name" => "Arif Rahmaanul",
                "username" => "arif.rahmaanul",
                "gender" => "L",
                "email" => "arif@gmail.com",
                "password" => Hash::make("password"),
                "level" => "officer",
                "created_at" => now()
            ]
        ]);
    }
}