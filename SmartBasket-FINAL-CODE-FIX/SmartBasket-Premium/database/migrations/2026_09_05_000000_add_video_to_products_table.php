<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | UP
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        if (
            !Schema::hasColumn(
                'products',
                'video'
            )
        ) {
            Schema::table(
                'products',
                function (Blueprint $table) {

                    $table
                        ->string('video')
                        ->nullable()
                        ->after('image');

                }
            );
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DOWN
    |--------------------------------------------------------------------------
    */

    public function down(): void
    {
        if (
            Schema::hasColumn(
                'products',
                'video'
            )
        ) {
            Schema::table(
                'products',
                function (Blueprint $table) {

                    $table->dropColumn(
                        'video'
                    );

                }
            );
        }
    }
};