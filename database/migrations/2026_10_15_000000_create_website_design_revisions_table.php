<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('website_design_revisions', function (Blueprint $table) {
            $table->id();
            $table->string('page_key', 80);
            $table->string('component_key', 100);
            $table->unsignedInteger('revision');
            $table->json('settings');
            $table->string('status', 16)->default('draft');
            $table->unsignedBigInteger('base_revision_id')->nullable();
            $table->string('created_by', 64)->nullable();
            $table->string('published_by', 64)->nullable();
            $table->timestamp('published_at')->nullable();
            $table->string('change_note', 180)->nullable();
            $table->timestamps();
            $table->index(['page_key', 'component_key', 'status']);
            $table->unique(['page_key', 'component_key', 'revision']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_design_revisions');
    }
};
