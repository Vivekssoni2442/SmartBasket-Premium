<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('admin_audit_logs', function (Blueprint $table) {
            $table->id();

            // Admin who performed the action
            $table->string('admin_id')->nullable();
            $table->foreign('admin_id')
                ->references('id')
                ->on('admins')
                ->nullOnDelete();

            // Action details
            $table->string('action'); // login, logout, approve_seller, reject_seller, etc.
            $table->string('entity_type')->nullable(); // seller, customer, product, order, etc.
            $table->string('entity_id')->nullable(); // ID of the affected entity

            // Description
            $table->text('description')->nullable();

            // Before/after values
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();

            // Network information
            $table->string('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Status
            $table->enum('status', ['success', 'failure', 'warning'])->default('success');

            // Timestamps
            $table->timestamps();

            // Indexes for efficient querying
            $table->index('admin_id');
            $table->index('action');
            $table->index('entity_type');
            $table->index('entity_id');
            $table->index('created_at');
            $table->index(['admin_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_audit_logs');
    }
};
