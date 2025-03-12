<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\PanelCredential;
use App\Models\ResellerPanelCredential;
use Illuminate\Support\Facades\Hash;

class CreateTestUsers extends Command
{
    protected $signature = 'users:create-test-all';
    protected $description = 'Create test users of all types with password P@ss123';

    public function handle()
    {
        $this->info('Creating test users...');

        // Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'admin',
            'is_reseller' => false,
            'email_verified_at' => now(),
        ]);
        $admin->panelCredential()->create([
            'username' => 'admin',
            'pass' => '1'
        ]);
        $this->info('Admin user created: admin@example.com / P@ss123');

        // Reseller User
        $reseller = User::create([
            'name' => 'Reseller User',
            'email' => 'reseller@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'user',
            'is_reseller' => true,
            'max_clients' => 10,
            'email_verified_at' => now(),
        ]);
        $reseller->panelCredential()->create([
            'username' => 'reseller',
            'pass' => '1'
        ]);
        $this->info('Reseller user created: reseller@example.com / P@ss123');

        // Regular User
        $regular = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'user',
            'is_reseller' => false,
            'email_verified_at' => now(),
        ]);
        $regular->panelCredential()->create([
            'username' => 'user',
            'pass' => '1'
        ]);
        $this->info('Regular user created: user@example.com / P@ss123');

        // Premium User (All type)
        $premiumAll = User::create([
            'name' => 'Premium All User',
            'email' => 'premium_all@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'user',
            'is_reseller' => false,
            'premium_type' => 'All',
            'email_verified_at' => now(),
        ]);
        $premiumAll->panelCredential()->create([
            'username' => 'premium_all',
            'pass' => '1'
        ]);
        $this->info('Premium All user created: premium_all@example.com / P@ss123');

        // Premium User (External type)
        $premiumExternal = User::create([
            'name' => 'Premium External User',
            'email' => 'premium_external@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'user',
            'is_reseller' => false,
            'premium_type' => 'External',
            'email_verified_at' => now(),
        ]);
        $premiumExternal->panelCredential()->create([
            'username' => 'premium_external',
            'pass' => '1'
        ]);
        $this->info('Premium External user created: premium_external@example.com / P@ss123');

        // Premium User (Streamer type)
        $premiumStreamer = User::create([
            'name' => 'Premium Streamer User',
            'email' => 'premium_streamer@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'user',
            'is_reseller' => false,
            'premium_type' => 'Streamer',
            'email_verified_at' => now(),
        ]);
        $premiumStreamer->panelCredential()->create([
            'username' => 'premium_streamer',
            'pass' => '1'
        ]);
        $this->info('Premium Streamer user created: premium_streamer@example.com / P@ss123');

        // Premium User (Bypass type)
        $premiumBypass = User::create([
            'name' => 'Premium Bypass User',
            'email' => 'premium_bypass@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'user',
            'is_reseller' => false,
            'premium_type' => 'Bypass',
            'email_verified_at' => now(),
        ]);
        $premiumBypass->panelCredential()->create([
            'username' => 'premium_bypass',
            'pass' => '1'
        ]);
        $this->info('Premium Bypass user created: premium_bypass@example.com / P@ss123');

        // Others Role User
        $othersUser = User::create([
            'name' => 'Others Role User',
            'email' => 'others@example.com',
            'password' => Hash::make('P@ss123'),
            'role' => 'others',
            'is_reseller' => false,
            'email_verified_at' => now(),
        ]);
        $othersUser->panelCredential()->create([
            'username' => 'others',
            'pass' => '1'
        ]);
        $this->info('Others role user created: others@example.com / P@ss123');

        $this->info('All test users created successfully!');
        return Command::SUCCESS;
    }
} 