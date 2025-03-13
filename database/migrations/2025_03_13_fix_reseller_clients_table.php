<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only create the table if it doesn't exist
        if (!Schema::hasTable('reseller_clients')) {
            Schema::create('reseller_clients', function (Blueprint $table) {
                $table->id();
                $table->foreignId('reseller_id')->constrained('users')->onDelete('cascade');
                $table->string('username')->unique();
                $table->string('password');
                $table->boolean('active')->default(true);
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Don't drop the table in down() to prevent data loss
    }
}; 