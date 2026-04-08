<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Test User 1
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Jan Kowalski',
                'password' => Hash::make('password123'),
            ]
        );

        // Test User 2
        User::firstOrCreate(
            ['email' => 'demo@example.com'],
            [
                'name' => 'Maria Nowak',
                'password' => Hash::make('password123'),
            ]
        );

        // Test User 3
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
            ]
        );
    }
}

