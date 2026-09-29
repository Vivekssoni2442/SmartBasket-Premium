<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->string('email')->nullable()->after('phone');
            $table->string('vehicle_type')->nullable()->after('vehicle_number');
            $table->date('delivery_date')->nullable()->after('vehicle_type');
            $table->string('expected_time')->nullable()->after('delivery_date');
            $table->text('notes')->nullable()->after('expected_time');
        });
    }

    public function down(): void
    {
        Schema::table('delivery_partners', function (Blueprint $table) {
            $table->dropColumn(['email', 'vehicle_type', 'delivery_date', 'expected_time', 'notes']);
        });
    }
};
