<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->string('aadhaar_number', 12)
                ->nullable()
                ->after('aadhaar_verified_at');
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->dropColumn('aadhaar_number');
        });
    }
};