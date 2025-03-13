<?php

// Load the Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\ResellerClient;

// Find a reseller
$reseller = User::where('premium_type', 'Reseller')->first();

if ($reseller) {
    echo "Found reseller with ID: " . $reseller->id . PHP_EOL;
    
    try {
        // Create a test client
        $client = ResellerClient::create([
            'reseller_id' => $reseller->id,
            'username' => 'testclient_' . time(), // Add timestamp to make it unique
            'password' => 'password',
            'active' => true
        ]);
        
        echo "Client created successfully with ID: " . $client->id . PHP_EOL;
        
        // Count clients for this reseller
        $clientCount = ResellerClient::where('reseller_id', $reseller->id)->count();
        echo "Total clients for this reseller: " . $clientCount . PHP_EOL;
    } catch (\Exception $e) {
        echo "Error creating client: " . $e->getMessage() . PHP_EOL;
    }
} else {
    echo "No reseller found. Please make sure you have users with premium_type = 'Reseller'" . PHP_EOL;
}

echo "Done." . PHP_EOL; 