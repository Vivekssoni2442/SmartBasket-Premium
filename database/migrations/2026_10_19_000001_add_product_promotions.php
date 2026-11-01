<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'sale_title' => fn () => $table->string('sale_title')->nullable(),
                'sale_offer' => fn () => $table->string('sale_offer', 500)->nullable(),
                'sale_price' => fn () => $table->decimal('sale_price', 10, 2)->nullable(),
                'sale_starts_at' => fn () => $table->dateTime('sale_starts_at')->nullable(),
                'sale_ends_at' => fn () => $table->dateTime('sale_ends_at')->nullable(),
                'coupon_title' => fn () => $table->string('coupon_title')->nullable(),
                'coupon_code' => fn () => $table->string('coupon_code', 80)->nullable(),
                'coupon_description' => fn () => $table->string('coupon_description', 500)->nullable(),
                'coupon_discount_type' => fn () => $table->string('coupon_discount_type', 20)->nullable(),
                'coupon_discount_value' => fn () => $table->decimal('coupon_discount_value', 10, 2)->nullable(),
                'coupon_starts_at' => fn () => $table->dateTime('coupon_starts_at')->nullable(),
                'coupon_ends_at' => fn () => $table->dateTime('coupon_ends_at')->nullable(),
                'coupon_design' => fn () => $table->string('coupon_design', 30)->nullable(),
            ];

            foreach ($columns as $column => $definition) {
                if (! Schema::hasColumn('products', $column)) {
                    $definition();
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $columns = [
                'sale_title', 'sale_offer', 'sale_price', 'sale_starts_at', 'sale_ends_at',
                'coupon_title', 'coupon_code', 'coupon_description', 'coupon_discount_type',
                'coupon_discount_value', 'coupon_starts_at', 'coupon_ends_at', 'coupon_design',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('products', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
