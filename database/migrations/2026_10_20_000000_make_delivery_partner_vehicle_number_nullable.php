<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->string('vehicle_number')->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('delivery_partners')
            ->whereNull('vehicle_number')
            ->update(['vehicle_number' => '']);

        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->string('vehicle_number')->nullable(false)->change();
        });
    }
};
