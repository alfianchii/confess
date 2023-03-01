<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
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
            "name" => "Muhammad Alfian",
            "email" => "alfianganteng@gmail.com",
            "password" => Hash::make("password"),
        ]);

        User::create([
            "name" => "Surya Nata",
            "email" => "surya.dev@gmail.com",
            "password" => Hash::make("password"),
        ]);
    }
}
