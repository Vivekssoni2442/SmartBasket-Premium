<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('security_settings', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
            ->constrained()
            ->cascadeOnDelete();

            $table->string('email');

            $table->string('pin_hash');

            $table->boolean('security_enabled')
            ->default(true);

            $table->timestamp('last_attempt_time')
            ->nullable();

            $table->integer('failed_attempt_count')
            ->default(0);

            $table->string('last_security_status')
            ->default('Safe');

            $table->timestamps();

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('security_settings');
    }
};