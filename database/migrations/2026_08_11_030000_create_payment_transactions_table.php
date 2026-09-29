<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('payment_transactions')) {
            return;
        }

        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('access_token', 80)->unique();
            $table->string('gateway', 40)->default('razorpay');
            $table->string('gateway_order_id')->nullable()->unique();
            $table->string('gateway_payment_id')->nullable()->unique();
            $table->string('gateway_signature')->nullable();
            $table->string('payment_method', 40);
            $table->string('status', 30)->default('pending');
            $table->decimal('amount', 10, 2);
            $table->integer('amount_paise');
            $table->string('currency', 3)->default('INR');
            $table->json('items_snapshot');
            $table->json('customer_details');
            $table->json('order_ids')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
