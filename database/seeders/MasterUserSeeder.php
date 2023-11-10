<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
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
                "id_user" => 1,
                "nik" => "1234567890123456",
                "full_name" => "Muhammad Alfian",
                "username" => "alfianchii",
                "gender" => "L",
                "email" => "alfianganteng@gmail.com",
                "profile_picture" => "user-images/muhammad-alfian.jpg",
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 2,
                "nik" => "1565234890124637",
                "full_name" => "Munaa Raudhatul Jannah",
                "username" => "nana",
                "gender" => "P",
                "email" => "nanamuna@gmail.com",
                "profile_picture" => "user-images/munaa-raudhatul-jannah.jpg",
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            // Students
            [
                "id_user" => 3,
                "nik" => "1234561234567890",
                "full_name" => "Surya Nata",
                "username" => "nata.ardhana",
                "gender" => "L",
                "email" => "surya.dev@gmail.com",
                "profile_picture" => "user-images/surya-nata.jpg",
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 4,
                "nik" => "1234556789061234",
                "full_name" => "Novalika Yudistira",
                "username" => "valds",
                "gender" => "L",
                "email" => "noval.yudis@gmail.com",
                "profile_picture" => null,
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 5,
                "nik" => "5678901234561234",
                "full_name" => "Muhammad Pasya Abinaya Wildan",
                "username" => "pasyaa",
                "gender" => "L",
                "email" => "pasyaa@gmail.com",
                "profile_picture" => null,
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            // Officers
            [
                "id_user" => 6,
                "nik" => "1234512345667890",
                "full_name" => "Fauzi Abdullah",
                "username" => "fauzy",
                "gender" => "L",
                "email" => "fauzyabdullah@gmail.com",
                "profile_picture" => "user-images/fauzi-abdullah.jpg",
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 7,
                "nik" => "1234516678902345",
                "full_name" => "Shandy Fakhri",
                "username" => "shandi.fakhri",
                "gender" => "L",
                "email" => "shandi@gmail.com",
                "profile_picture" => null,
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 8,
                "nik" => "1238902345451667",
                "full_name" => "Arif Rahmaanul",
                "username" => "arif.rahmaanul",
                "gender" => "L",
                "email" => "arif@gmail.com",
                "profile_picture" => null,
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 9,
                "nik" => "1201234563456789",
                "full_name" => "Moepoi",
                "username" => "moepoi",
                "gender" => "L",
                "email" => "moepoi@moe.dev",
                "profile_picture" => "user-images/moepoi.jpg",
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
            [
                "id_user" => 10,
                "nik" => "7892345634561201",
                "full_name" => "Fadli Hizfiansyah",
                "username" => "fadli.890",
                "gender" => "L",
                "email" => "fadli.cool@gmail.com",
                "profile_picture" => "user-images/fadli-hizfiansyah.jpg",
                "password" => Hash::make("password"),
                "flag_active" => "Y",
                "created_at" => now(),
                // "last_login_at" => now(),
            ],
        ]);
    }
}
