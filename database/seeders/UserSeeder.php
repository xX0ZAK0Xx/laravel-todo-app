<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            "name"=> "Md. Zayed",
            "email"=> "mdzayed@gmail.com",
            "password"=> "password",
            "is_admin"=> true,
        ]);

        // Create 10 regular users
        User::factory(10)->create();
    }
}
