<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->string('business_type', 100)->nullable()->after('pincode');
            $table->string('aadhaar_document_path')->nullable()->after('business_certificate_path');
            $table->timestamp('aadhaar_document_uploaded_at')->nullable()->after('business_certificate_uploaded_at');
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->dropColumn(['business_type', 'aadhaar_document_path', 'aadhaar_document_uploaded_at']);
        });
    }
};
