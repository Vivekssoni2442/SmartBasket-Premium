<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_partner_order_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('delivery_detail_id')->constrained('order_delivery_details')->cascadeOnDelete();
            $table->foreignId('delivery_partner_id')->constrained('delivery_partners')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->index(['delivery_partner_id', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_partner_order_notifications');
    }
};
