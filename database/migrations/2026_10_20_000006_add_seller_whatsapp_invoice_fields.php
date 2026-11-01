<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('seller_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('seller_profiles', 'whatsapp_business_phone')) {
                $table->string('whatsapp_business_phone', 30)->nullable();
            }
            if (! Schema::hasColumn('seller_profiles', 'whatsapp_phone_number_id')) {
                $table->string('whatsapp_phone_number_id', 80)->nullable();
            }
            if (! Schema::hasColumn('seller_profiles', 'whatsapp_access_token')) {
                $table->text('whatsapp_access_token')->nullable();
            }
            if (! Schema::hasColumn('seller_profiles', 'whatsapp_invoice_template')) {
                $table->string('whatsapp_invoice_template', 100)->nullable();
            }
            if (! Schema::hasColumn('seller_profiles', 'whatsapp_template_language')) {
                $table->string('whatsapp_template_language', 20)->nullable();
            }
            if (! Schema::hasColumn('seller_profiles', 'whatsapp_invoice_enabled')) {
                $table->boolean('whatsapp_invoice_enabled')->default(false);
            }
        });

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'whatsapp_invoice_opt_in')) {
                $table->boolean('whatsapp_invoice_opt_in')->default(false);
            }
            if (! Schema::hasColumn('orders', 'whatsapp_invoice_status')) {
                $table->string('whatsapp_invoice_status', 30)->default('not_requested');
            }
            if (! Schema::hasColumn('orders', 'whatsapp_invoice_message_id')) {
                $table->string('whatsapp_invoice_message_id', 120)->nullable();
            }
            if (! Schema::hasColumn('orders', 'whatsapp_invoice_sent_at')) {
                $table->timestamp('whatsapp_invoice_sent_at')->nullable();
            }
            if (! Schema::hasColumn('orders', 'whatsapp_invoice_error')) {
                $table->text('whatsapp_invoice_error')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $columns = ['whatsapp_invoice_opt_in', 'whatsapp_invoice_status', 'whatsapp_invoice_message_id', 'whatsapp_invoice_sent_at', 'whatsapp_invoice_error'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
        Schema::table('seller_profiles', function (Blueprint $table) {
            $columns = ['whatsapp_business_phone', 'whatsapp_phone_number_id', 'whatsapp_access_token', 'whatsapp_invoice_template', 'whatsapp_template_language', 'whatsapp_invoice_enabled'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('seller_profiles', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
