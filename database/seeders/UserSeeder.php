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
     */
    public function run(): void
    {
        // Create admin user
        // Email: admin@example.com
        // Password: admin123
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        // Create sample user 1
        // Email: user@example.com
        // Password: user123
        User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('user123'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );

        // Create sample user 2
        // Email: peserta@example.com
        // Password: peserta123
        User::firstOrCreate(
            ['email' => 'peserta@example.com'],
            [
                'name' => 'Jane Smith',
                'password' => Hash::make('peserta123'),
                'is_admin' => false,
                'email_verified_at' => now(),
            ]
        );
    }
}
