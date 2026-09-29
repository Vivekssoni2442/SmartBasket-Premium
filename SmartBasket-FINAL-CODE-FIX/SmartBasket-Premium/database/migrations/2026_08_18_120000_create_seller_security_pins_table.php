<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seller_security_pins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_profile_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('pin_hash');
            $table->boolean('security_enabled')->default(true);
            $table->timestamp('last_attempt_at')->nullable();
            $table->unsignedTinyInteger('failed_attempt_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_security_pins');
    }
};
