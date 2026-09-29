<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/*
|--------------------------------------------------------------------------
| AI Camera Shopping Assistant - Product Recommendation Fields
|--------------------------------------------------------------------------
| This migration ONLY ADDS nullable columns to the products table.
| It does NOT modify or delete any existing column.
| Rollback with: php artisan migrate:rollback --step=1
*/

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Body fit recommendation: slim | regular | relaxed | oversized
            $table->string('body_fit')->nullable()->after('category');

            // Style type: casual | formal | sporty | ethnic | party
            $table->string('style_type')->nullable()->after('body_fit');

            // Dominant color category: light | dark | warm | cool | neutral
            $table->string('color_category')->nullable()->after('style_type');

            // Recommended body type: inverted-triangle | pear | rectangle | hourglass | apple | any
            $table->string('recommended_for')->nullable()->after('color_category');

            // Season suitability: summer | winter | monsoon | all
            $table->string('season')->nullable()->after('recommended_for');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'body_fit',
                'style_type',
                'color_category',
                'recommended_for',
                'season',
            ]);
        });
    }
};