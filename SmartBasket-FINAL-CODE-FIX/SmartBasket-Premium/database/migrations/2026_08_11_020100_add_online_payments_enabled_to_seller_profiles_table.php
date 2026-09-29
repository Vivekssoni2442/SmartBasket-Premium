<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('seller_profiles', 'online_payments_enabled')) {
            Schema::table('seller_profiles', function (Blueprint $table) {
                $table->boolean('online_payments_enabled')->default(false);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('seller_profiles', 'online_payments_enabled')) {
            Schema::table('seller_profiles', fn (Blueprint $table) => $table->dropColumn('online_payments_enabled'));
        }
    }
};
