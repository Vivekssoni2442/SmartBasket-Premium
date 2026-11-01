<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->foreignId('seller_id')->nullable()->after('id')->constrained('seller_profiles')->nullOnDelete();
            $table->string('portal_token', 64)->nullable()->unique()->after('current_location');
        });
    }

    public function down(): void
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->dropUnique(['portal_token']);
            $table->dropConstrainedForeignId('seller_id');
            $table->dropColumn('portal_token');
        });
    }
};
