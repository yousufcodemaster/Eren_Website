<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateOthersTestUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-others-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a test user with the "Others" role';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Create a user with the "Others" role
        $user = User::create([
            'name' => 'Test Others User',
            'email' => 'others@example.com',
            'password' => Hash::make('password'),
            'role' => 'others',
            'email_verified_at' => now(),
        ]);

        $this->info('Others test user created successfully!');
        $this->info('Email: others@example.com');
        $this->info('Password: password');
        
        return Command::SUCCESS;
    }
} 