<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin Users
        $adminUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@admin.com',
                'password' => 'admin123',
            ],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@admin.com',
                'password' => 'admin123',
            ]
        ];

        foreach ($adminUsers as $admin) {
            User::create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => Hash::make($admin['password']),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]);
        }

        // Create Premium Users with different types
        $premiumTypes = ['All', 'External', 'Streamer', 'Bypass', 'Reseller'];
        
        foreach ($premiumTypes as $type) {
            User::create([
                'name' => "$type User",
                'email' => strtolower($type) . '@example.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'premium_type' => $type,
                'email_verified_at' => now(),
            ]);
        }

        // Create a regular user
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password123'),
            'role' => 'user',
            'email_verified_at' => now(),
        ]);
    }
} 