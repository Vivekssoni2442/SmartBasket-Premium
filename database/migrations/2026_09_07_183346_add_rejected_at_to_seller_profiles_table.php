<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('seller_profiles', 'rejected_at')) {
            Schema::table('seller_profiles', function (Blueprint $table) {
                $table->timestamp('rejected_at')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('seller_profiles', 'rejected_at')) {
            Schema::table('seller_profiles', function (Blueprint $table) {
                $table->dropColumn('rejected_at');
            });
        }
    }
};