<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_cancellation_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->unique()->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('seller_id')->nullable()->constrained('seller_profiles')->nullOnDelete();
            $table->string('status', 30)->default('refund_pending')->index();
            $table->string('reason', 500)->nullable();
            $table->decimal('refund_amount', 12, 2)->default(0);
            $table->string('refund_method', 20)->nullable();
            $table->text('upi_id')->nullable();
            $table->text('bank_account_holder')->nullable();
            $table->text('bank_name')->nullable();
            $table->text('bank_account_number')->nullable();
            $table->text('bank_ifsc')->nullable();
            $table->string('seller_transfer_reference', 120)->nullable();
            $table->text('seller_note')->nullable();
            $table->timestamp('refund_sent_at')->nullable();
            $table->timestamps();
            $table->index(['seller_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_cancellation_requests');
    }
};
