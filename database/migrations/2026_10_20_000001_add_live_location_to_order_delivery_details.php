<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_delivery_details', function (Blueprint $table) {
            $table->string('tracking_token', 64)->nullable()->unique();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();
            $table->timestamp('location_updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('order_delivery_details', function (Blueprint $table) {
            $table->dropUnique(['tracking_token']);
            $table->dropColumn(['tracking_token', 'latitude', 'longitude', 'location_updated_at']);
        });
    }
};
