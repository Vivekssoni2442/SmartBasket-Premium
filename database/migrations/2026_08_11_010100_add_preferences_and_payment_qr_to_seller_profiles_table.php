<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Synchronize fields already used by the seller settings and QR flows.
        if (! Schema::hasColumn('seller_profiles', 'payment_qr')) {
            Schema::table('seller_profiles', fn (Blueprint $table) => $table->string('payment_qr')->nullable()->after('shop_logo'));
        }
        if (! Schema::hasColumn('seller_profiles', 'theme')) {
            Schema::table('seller_profiles', fn (Blueprint $table) => $table->string('theme')->nullable()->default('light'));
        }
        if (! Schema::hasColumn('seller_profiles', 'notifications_enabled')) {
            Schema::table('seller_profiles', fn (Blueprint $table) => $table->boolean('notifications_enabled')->default(true));
        }
    }
    public function down(): void
    {
        foreach (['notifications_enabled', 'theme', 'payment_qr'] as $column) {
            if (Schema::hasColumn('seller_profiles', $column)) {
                Schema::table('seller_profiles', fn (Blueprint $table) => $table->dropColumn($column));
            }
        }
    }
};
