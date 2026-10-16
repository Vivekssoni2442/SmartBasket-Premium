<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('products', 'video_poster')) {
            Schema::table('products', function (Blueprint $table) {
                $table->string('video_poster')->nullable()->after('video');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('products', 'video_poster')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('video_poster');
            });
        }
    }
};
