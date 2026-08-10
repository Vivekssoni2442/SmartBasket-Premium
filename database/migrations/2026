<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // order, low_stock, message, offer, login
            $table->string('title');
            $table->text('message')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('seller_id')->nullable();
            $table->string('role')->default('seller'); // seller or user
            $table->boolean('is_read')->default(false);
            $table->json('data')->nullable();
            $table->timestamps();
        });

        // Add seller_id to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->after('user_id');
        });

        // Add weight to products table
        Schema::table('products', function (Blueprint $table) {
            $table->string('weight')->nullable()->after('color');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('weight');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('seller_id');
        });

        Schema::dropIfExists('notifications');
    }
};