<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('seller_profiles', 'payment_upi_id')) {
                $table->string('payment_upi_id', 120)->nullable()->after('preferences');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_mobile_number')) {
                $table->string('payment_mobile_number', 20)->nullable()->after('payment_upi_id');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_business_name')) {
                $table->string('payment_business_name', 150)->nullable()->after('payment_mobile_number');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_status')) {
                $table->string('payment_status', 30)->default('disabled')->after('payment_business_name');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_provider')) {
                $table->string('payment_provider', 40)->default('upi')->after('payment_status');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_verification_status')) {
                $table->string('payment_verification_status', 30)->default('verification_pending')->after('payment_provider');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_verified_at')) {
                $table->timestamp('payment_verified_at')->nullable()->after('payment_verification_status');
            }

            if (! Schema::hasColumn('seller_profiles', 'payment_enabled')) {
                $table->boolean('payment_enabled')->default(false)->after('payment_verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            foreach (['payment_upi_id', 'payment_mobile_number', 'payment_business_name', 'payment_status', 'payment_provider', 'payment_verification_status', 'payment_verified_at', 'payment_enabled'] as $column) {
                if (Schema::hasColumn('seller_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
