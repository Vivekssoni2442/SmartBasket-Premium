<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| AI Camera Assistant — Analysis History
|--------------------------------------------------------------------------
| Additive table for logged-in users. Does NOT modify any existing table.
| Only the analysis result (JSON) and a temporary source image reference are
| stored; raw image bytes are never persisted.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_camera_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('image_path')->nullable();
            $table->string('query')->nullable();
            $table->json('analysis')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_camera_histories');
    }
};
