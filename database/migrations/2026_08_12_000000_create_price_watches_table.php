<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasTable('price_watches')) {
            Schema::create('price_watches', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->decimal('tracked_price', 10, 2);
                $table->decimal('previous_price', 10, 2)->nullable();
                $table->timestamps();
                $table->unique(['user_id', 'product_id']);
            });
        }
    }

    public function down(): void { Schema::dropIfExists('price_watches'); }
};
