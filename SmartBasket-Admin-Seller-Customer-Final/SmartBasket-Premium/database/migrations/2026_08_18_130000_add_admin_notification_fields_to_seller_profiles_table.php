<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->string('admin_notification_status', 20)->nullable()->index();
            $table->timestamp('admin_notification_sent_at')->nullable();
            $table->timestamp('admin_notification_failed_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            $table->dropColumn(['admin_notification_status', 'admin_notification_sent_at', 'admin_notification_failed_at']);
        });
    }
};
