<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('seller_profiles', 'shop_banner')) {
                $table->string('shop_banner')->nullable()->after('shop_logo');
            }

            if (! Schema::hasColumn('seller_profiles', 'preferences')) {
                $table->json('preferences')->nullable()->after('online_payments_enabled');
            }
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            if (Schema::hasColumn('seller_profiles', 'preferences')) {
                $table->dropColumn('preferences');
            }

            if (Schema::hasColumn('seller_profiles', 'shop_banner')) {
                $table->dropColumn('shop_banner');
            }
        });
    }
};