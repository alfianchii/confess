<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\{User, Complaint, Category};
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
        User::create([
            "nik" => "1234567890123456",
            "name" => "Muhammad Alfian",
            "username" => "alfianchii",
            "email" => "alfianganteng@gmail.com",
            "password" => Hash::make("password"),
            "level" => 'admin',
        ]);
        User::create([
            "nik" => "1234561234567890",
            "name" => "Surya Nata",
            "username" => "nata.ardhana",
            "email" => "surya.dev@gmail.com",
            "password" => Hash::make("password"),
            "level" => "student",
        ]);
        User::create([
            "nik" => "1234512345667890",
            "name" => "Fauzi Abdullah",
            "username" => "fauzy",
            "email" => "fauzyabdullah@gmail.com",
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

        Complaint::factory(12)->create();
    }
}
