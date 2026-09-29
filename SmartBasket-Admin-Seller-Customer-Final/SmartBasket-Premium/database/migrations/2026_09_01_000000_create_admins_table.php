<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            // Primary key - custom string ID
            $table->string('id')->primary();

            // Admin information
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable();

            // Admin role and status
            $table->enum('role', ['super_admin', 'admin', 'moderator'])->default('admin');
            $table->enum('status', ['active', 'inactive', 'suspended'])->default('active');

            // Profile
            $table->string('avatar')->nullable();
            $table->text('bio')->nullable();
            $table->string('timezone')->default('UTC');
            $table->string('language')->default('en');
            $table->boolean('dark_mode')->default(false);

            // 2FA / MFA
            $table->boolean('mfa_enabled')->default(false);
            $table->string('mfa_secret')->nullable();
            $table->json('mfa_recovery_codes')->nullable();

            // Login tracking and security
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->integer('login_attempts')->default(0);
            $table->timestamp('locked_until')->nullable();

            // Timestamps
            $table->timestamps();

            // Indexes
            $table->index('email');
            $table->index('status');
            $table->index('role');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
