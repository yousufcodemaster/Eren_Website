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
        Schema::create('reseller_panel_credentials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reseller_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('username');
            $table->string('pass', 18)->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reseller_panel_credentials');
    }
};
