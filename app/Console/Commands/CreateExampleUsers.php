<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateExampleUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-examples';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create example users with different roles and premium types';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating example users...');
        
        // Create Admin user
        $this->createUser(
            'Admin User',
            'admin@example.com',
            'admin',
            null,
            false
        );
        $this->info('✅ Admin user created');
        
        // Create Normal user (no premium)
        $this->createUser(
            'Normal User',
            'normal@example.com',
            'user',
            null,
            false
        );
        $this->info('✅ Normal user created');
        
        // Create Premium "All" user
        $this->createUser(
            'Premium All User',
            'premium.all@example.com',
            'user',
            'All',
            false
        );
        $this->info('✅ Premium All user created');
        
        // Create Premium "External" user
        $this->createUser(
            'Premium External User',
            'premium.external@example.com',
            'user',
            'External',
            false
        );
        $this->info('✅ Premium External user created');
        
        // Create Premium "Streamer" user
        $this->createUser(
            'Premium Streamer User',
            'premium.streamer@example.com',
            'user',
            'Streamer',
            false
        );
        $this->info('✅ Premium Streamer user created');
        
        // Create Premium "Bypass" user
        $this->createUser(
            'Premium Bypass User',
            'premium.bypass@example.com',
            'user',
            'Bypass',
            false
        );
        $this->info('✅ Premium Bypass user created');
        
        // Create Reseller user
        $this->createUser(
            'Reseller User',
            'reseller@example.com',
            'user',
            'Reseller',
            true,
            10 // max_clients
        );
        $this->info('✅ Reseller user created');
        
        // Create Admin + Reseller user (combined role)
        $this->createUser(
            'Admin Reseller User',
            'admin.reseller@example.com',
            'admin',
            'Reseller',
            true,
            20 // max_clients
        );
        $this->info('✅ Admin Reseller user created');
        
        $this->info('All example users created successfully!');
        $this->info('Use password "password" to log in as any of these users.');
        
        return Command::SUCCESS;
    }
    
    /**
     * Create a user with the given attributes.
     */
    private function createUser($name, $email, $role, $premiumType, $isReseller, $maxClients = 5)
    {
        // Check if user already exists
        if (User::where('email', $email)->exists()) {
            $this->warn("User with email {$email} already exists. Skipping.");
            return;
        }
        
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make('password'),
            'panel_password' => Hash::make('password'),
            'role' => $role,
            'premium_type' => $premiumType,
            'is_reseller' => $isReseller,
            'max_clients' => $maxClients,
            'email_verified_at' => now(),
        ]);
    }
}
