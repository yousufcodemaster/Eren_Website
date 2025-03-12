<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateResellerDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reseller:create-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the reseller clients database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dbName = config('database.connections.reseller.database');
        $connection = config('database.connections.reseller.driver');
        
        $this->info("Creating database: {$dbName}");
        
        try {
            if ($connection === 'pgsql') {
                // For PostgreSQL, we need to connect to the 'postgres' database first
                DB::connection('pgsql')
                    ->statement("CREATE DATABASE {$dbName}");
            } elseif ($connection === 'mysql') {
                // For MySQL
                DB::connection('mysql')
                    ->statement("CREATE DATABASE IF NOT EXISTS {$dbName}");
            } else {
                $this->error("Unsupported database driver: {$connection}");
                return 1;
            }
            
            $this->info("Database {$dbName} created successfully.");
            return 0;
        } catch (\Exception $e) {
            $this->error("Failed to create database: " . $e->getMessage());
            return 1;
        }
    }
}
