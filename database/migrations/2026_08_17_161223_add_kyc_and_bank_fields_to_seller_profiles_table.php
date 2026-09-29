<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {

            // Identity verification
            $table->string('pan_number')->nullable()->unique()->after('gst_number');
            $table->string('pan_document_path')->nullable()->after('pan_number');
            $table->timestamp('pan_document_uploaded_at')->nullable();

            // Business verification
            $table->string('udyam_number')->nullable()->after('gst_number');
            $table->string('shop_proof_path')->nullable();
            $table->timestamp('shop_proof_uploaded_at')->nullable();

            // Bank verification
            $table->string('bank_account_holder')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_ifsc')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_proof_path')->nullable();
            $table->timestamp('bank_proof_uploaded_at')->nullable();

            // Mobile verification
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('mobile_code_hash')->nullable();
            $table->timestamp('mobile_code_expires_at')->nullable();
            $table->unsignedTinyInteger('mobile_code_attempts')->default(0);
            $table->timestamp('mobile_code_sent_at')->nullable();

            // Seller onboarding progress
            $table->unsignedTinyInteger('onboarding_step')->default(1);
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'pan_number',
                'pan_document_path',
                'pan_document_uploaded_at',
                'udyam_number',
                'shop_proof_path',
                'shop_proof_uploaded_at',
                'bank_account_holder',
                'bank_account_number',
                'bank_ifsc',
                'bank_name',
                'bank_proof_path',
                'bank_proof_uploaded_at',
                'mobile_verified_at',
                'mobile_code_hash',
                'mobile_code_expires_at',
                'mobile_code_attempts',
                'mobile_code_sent_at',
                'onboarding_step',
            ]);
        });
    }
};