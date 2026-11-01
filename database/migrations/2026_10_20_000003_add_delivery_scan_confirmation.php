<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_delivery_details', function (Blueprint $table) {
            $table->string('delivery_scan_code', 255)->nullable();
            $table->timestamp('delivered_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('order_delivery_details', function (Blueprint $table) {
            $table->dropColumn(['delivery_scan_code', 'delivered_at']);
        });
    }
};
