<?php

// Load the Laravel application
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

// Check if the table already exists
if (!Schema::hasTable('reseller_clients')) {
    echo "Creating reseller_clients table...\n";
    
    Schema::create('reseller_clients', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reseller_id')->constrained('users')->onDelete('cascade');
        $table->string('username')->unique();
        $table->string('password');
        $table->boolean('active')->default(true);
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    });
    
    echo "Table created successfully!\n";
} else {
    echo "The reseller_clients table already exists.\n";
}

echo "Done.\n"; 