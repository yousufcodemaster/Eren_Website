<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users first
        User::truncate();
        
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'premium_type' => null,
            'is_reseller' => false,
            'max_clients' => 0,
            'email_verified_at' => now(),
        ]);

        // Create Regular User
        User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'premium_type' => null,
            'is_reseller' => false,
            'max_clients' => 0,
            'email_verified_at' => now(),
        ]);

        // Create Discord User
        User::create([
            'name' => 'Discord User',
            'email' => 'discord@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'premium_type' => null,
            'is_reseller' => false,
            'max_clients' => 0,
            'discord_id' => '123456789',
            'discord_username' => 'discord_user#1234',
            'discord_avatar' => 'https://cdn.discordapp.com/avatars/123456789/default_avatar.png',
            'email_verified_at' => now(),
        ]);
        
        // Create Premium Users with different premium types
        $premiumTypes = ['All', 'External', 'Streamer', 'Bypass', 'Reseller'];
        
        foreach ($premiumTypes as $index => $type) {
            $isReseller = $type === 'Reseller';
            $maxClients = $isReseller ? 10 : 0;
            
            User::create([
                'name' => $type . ' Premium User',
                'email' => strtolower($type) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'premium_type' => $type,
                'is_reseller' => $isReseller,
                'max_clients' => $maxClients,
                'email_verified_at' => now(),
            ]);
        }
        
        // Create a few more Reseller users with different client limits
        $resellerLimits = [5, 15, 25];
        foreach ($resellerLimits as $index => $limit) {
            User::create([
                'name' => 'Reseller User ' . ($index + 1),
                'email' => 'reseller' . ($index + 1) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'premium_type' => 'Reseller',
                'is_reseller' => true,
                'max_clients' => $limit,
                'email_verified_at' => now(),
            ]);
        }
    }
} 