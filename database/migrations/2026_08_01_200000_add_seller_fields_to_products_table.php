<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds seller tracking + e-commerce fields to the products table.
     * All columns are nullable to preserve existing products.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->after('id');
            $table->string('brand')->nullable()->after('category');
            $table->decimal('discount_price', 10, 2)->nullable()->after('price');
            $table->string('size')->nullable()->after('stock');
            $table->string('color')->nullable()->after('size');
            $table->enum('status', ['active', 'inactive'])->default('active')->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['seller_id', 'brand', 'discount_price', 'size', 'color', 'status']);
        });
    }
};