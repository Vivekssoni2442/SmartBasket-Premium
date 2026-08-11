<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /** New orders are seller-specific; nullable preserves historical orders. */
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'seller_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('seller_id')->nullable()->index()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'seller_id')) {
            Schema::table('orders', fn (Blueprint $table) => $table->dropColumn('seller_id'));
        }
    }
};
