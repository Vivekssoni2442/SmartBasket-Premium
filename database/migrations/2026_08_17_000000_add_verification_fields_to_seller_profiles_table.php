<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->string('verification_status')->default('active')->index(); // preserves existing sellers
            $table->timestamp('email_verified_at')->nullable();
            $table->string('email_code_hash')->nullable();
            $table->timestamp('email_code_expires_at')->nullable();
            $table->unsignedTinyInteger('email_code_attempts')->default(0);
            $table->timestamp('email_code_sent_at')->nullable();
            $table->string('business_certificate_path')->nullable();
            $table->timestamp('business_certificate_uploaded_at')->nullable();
            $table->timestamp('aadhaar_verified_at')->nullable();
            $table->string('verification_reference_id')->nullable()->unique();
            $table->timestamp('verification_submitted_at')->nullable();
            $table->timestamp('admin_reviewed_at')->nullable();
            $table->foreignId('admin_reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->string('activation_code_hash')->nullable();
            $table->timestamp('activation_code_expires_at')->nullable();
            $table->unsignedTinyInteger('activation_attempts')->default(0);
            $table->timestamp('activation_code_sent_at')->nullable();
            $table->timestamp('activation_verified_at')->nullable();
        });
    }
    public function down(): void { Schema::table('seller_profiles', function (Blueprint $table) { $table->dropConstrainedForeignId('admin_reviewed_by'); $table->dropColumn(['verification_status','email_verified_at','email_code_hash','email_code_expires_at','email_code_attempts','email_code_sent_at','business_certificate_path','business_certificate_uploaded_at','aadhaar_verified_at','verification_reference_id','verification_submitted_at','admin_reviewed_at','rejection_reason','approved_at','activation_code_hash','activation_code_expires_at','activation_attempts','activation_code_sent_at','activation_verified_at']); }); }
};
