<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('blocked_at')->nullable()->index();
            $table->string('block_reason', 500)->nullable();
            $table->softDeletes();
        });

        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->timestamp('blocked_at')->nullable()->index();
            $table->string('block_reason', 500)->nullable();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['blocked_at', 'block_reason']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn(['blocked_at', 'block_reason']);
        });
    }
};
