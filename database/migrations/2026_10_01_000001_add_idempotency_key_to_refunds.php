<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('refunds') && ! Schema::hasColumn('refunds', 'idempotency_key')) {
            Schema::table('refunds', function (Blueprint $table) {
                $table->string('idempotency_key', 100)->nullable()->unique();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('refunds') && Schema::hasColumn('refunds', 'idempotency_key')) {
            Schema::table('refunds', function (Blueprint $table) {
                $table->dropUnique(['idempotency_key']);
                $table->dropColumn('idempotency_key');
            });
        }
    }
};