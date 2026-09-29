<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| AI Camera Assistant — Virtual Try-On Result Image
|--------------------------------------------------------------------------
| Additive column on the existing ai_camera_histories table.
| Stores the relative path (under public storage) of a generated
| virtual try-on result image so previous results can be shown/history.
| Does NOT modify any existing column or table structure.
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ai_camera_histories', function (Blueprint $table) {
            $table->string('result_image')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('ai_camera_histories', function (Blueprint $table) {
            $table->dropColumn('result_image');
        });
    }
};
