<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{User, Complaint, Category, Response};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Admins
        User::create([
            "nik" => "1234567890123456",
            "name" => "Muhammad Alfian",
            "username" => "alfianchii",
            "gender" => "L",
            "email" => "alfianganteng@gmail.com",
            "password" => Hash::make("password"),
            "level" => 'admin',
        ]);
        User::create([
            "nik" => "1201234563456789",
            "name" => "Munaa Raudhatul",
            "username" => "nana",
            "gender" => "P",
            "email" => "nanaa@gmail.com",
            "password" => Hash::make("password"),
            "level" => 'admin',
        ]);
        // Students
        User::create([
            "nik" => "1234561234567890",
            "name" => "Surya Nata",
            "username" => "nata.ardhana",
            "gender" => "L",
            "email" => "surya.dev@gmail.com",
            "password" => Hash::make("password"),
            "level" => "student",
        ]);
        User::create([
            "nik" => "1234556789061234",
            "name" => "Novalika Yudistira",
            "username" => "valds",
            "gender" => "L",
            "email" => "noval.yudis@gmail.com",
            "password" => Hash::make("password"),
            "level" => "student",
        ]);
        User::create([
            "nik" => "5678901234561234",
            "name" => "Muhammad Pasya",
            "username" => "pasyaa",
            "gender" => "L",
            "email" => "pasyaa@gmail.com",
            "password" => Hash::make("password"),
            "level" => "student",
        ]);
        // Officers
        User::create([
            "nik" => "1234512345667890",
            "name" => "Fauzi Abdullah",
            "username" => "fauzy",
            "gender" => "L",
            "email" => "fauzyabdullah@gmail.com",
            "password" => Hash::make("password"),
            "level" => "officer",
        ]);
        User::create([
            "nik" => "1234516678902345",
            "name" => "Shandy Fakhri",
            "username" => "shandi.fakhri",
            "gender" => "L",
            "email" => "shandi@gmail.com",
            "password" => Hash::make("password"),
            "level" => "officer",
        ]);
        User::create([
            "nik" => "1238902345451667",
            "name" => "Arif Rahmaanul",
            "username" => "arif.rahmaanul",
            "gender" => "L",
            "email" => "arif@gmail.com",
            "password" => Hash::make("password"),
            "level" => "officer",
        ]);

        Category::create([
            "name" => "Oppression",
            "slug" => "oppression",
        ]);
        Category::create([
            "name" => "Sexual Harassment",
            "slug" => "sexual-harassment",
        ]);
        Category::create([
            "name" => "Bully",
            "slug" => "bully",
        ]);

        Complaint::factory(100)->create();
        Response::factory(100)->create();
    }
}