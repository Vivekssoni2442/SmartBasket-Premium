<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->boolean('face_unlock_enabled')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->dropColumn('face_unlock_enabled');
        });
    }
};
