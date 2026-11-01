<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('refund_upi_id')->nullable();
            $table->text('refund_account_holder')->nullable();
            $table->text('refund_bank_name')->nullable();
            $table->text('refund_account_number')->nullable();
            $table->text('refund_ifsc')->nullable();
        });

        Schema::table('order_return_requests', function (Blueprint $table) {
            $table->string('refund_method', 20)->nullable();
            $table->text('refund_upi_id')->nullable();
            $table->text('refund_account_holder')->nullable();
            $table->text('refund_bank_name')->nullable();
            $table->text('refund_account_number')->nullable();
            $table->text('refund_ifsc')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('order_return_requests', function (Blueprint $table) {
            $table->dropColumn([
                'refund_method', 'refund_upi_id', 'refund_account_holder',
                'refund_bank_name', 'refund_account_number', 'refund_ifsc',
            ]);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'refund_upi_id', 'refund_account_holder', 'refund_bank_name',
                'refund_account_number', 'refund_ifsc',
            ]);
        });
    }
};
