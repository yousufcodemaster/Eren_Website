<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user for login testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $email = 'admin@example.com';
            $name = 'Admin User';
            $password = 'password';

            $user = User::where('email', $email)->first();

            if ($user) {
                $this->info("User with email {$email} already exists.");
                return 0;
            }

            // Create an admin user
            $admin = User::create([
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_reseller' => false,
                'email_verified_at' => now(),
            ]);

            $this->info('Admin user created successfully!');
            $this->info('Email: admin@example.com');
            $this->info('Password: password');

            // Create a reseller user
            $reseller = User::create([
                'name' => 'Reseller User',
                'email' => 'reseller@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'is_reseller' => true,
                'max_clients' => 10,
                'email_verified_at' => now(),
            ]);

            $this->info('Reseller user created successfully!');
            $this->info('Email: reseller@example.com');
            $this->info('Password: password');

            return 0;
        } catch (\Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
            return 1;
        }
    }
}
