<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@sample.com',
            'password' => bcrypt('admin@sample.com'), 
            'mobile' => '1234567890',
            'role' => 'admin',
            'show_notifications' => 1,
        ]);

        // Create 4 normal users
        User::factory()->count(4)->create();
    }
}
