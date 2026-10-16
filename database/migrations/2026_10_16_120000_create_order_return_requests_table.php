<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('order_return_requests')) {
            Schema::create('order_return_requests', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained()->restrictOnDelete();
                $table->foreignId('user_id')->constrained()->restrictOnDelete();
                $table->json('items');
                $table->string('reason', 80);
                $table->text('description')->nullable();
                $table->string('status', 40)->default('requested');
                $table->text('seller_note')->nullable();
                $table->text('decision_note')->nullable();
                $table->string('reviewed_by_admin')->nullable();
                $table->decimal('refund_amount', 12, 2)->nullable();
                $table->json('history')->nullable();
                $table->timestamp('reviewed_at')->nullable();
                $table->timestamp('cancelled_at')->nullable();
                $table->timestamps();
                $table->index(['user_id', 'status']);
                $table->index(['order_id', 'status']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_return_requests');
    }
};
