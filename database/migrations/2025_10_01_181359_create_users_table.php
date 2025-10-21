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
        Schema::create('users', function (Blueprint $table) {
        $table->id('user_id');              // Primary key
        $table->string('name');             // Nama user
        $table->string('email')->unique();  // Email unik
        $table->string('password');         // Password
        $table->string('role')->default('user'); // Role (default user)
        $table->timestamps();               // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
