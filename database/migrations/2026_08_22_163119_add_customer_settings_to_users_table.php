<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (!Schema::hasColumn('users', 'dark_mode')) {

                $table->string('dark_mode')
                    ->default('dark')
                    ->after('password');
            }


            if (!Schema::hasColumn('users', 'notifications')) {

                $table->string('notifications')
                    ->default('enabled')
                    ->after('dark_mode');
            }


            if (!Schema::hasColumn('users', 'language')) {

                $table->string('language')
                    ->default('en')
                    ->after('notifications');
            }

        });
    }


    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            if (Schema::hasColumn('users', 'dark_mode')) {
                $table->dropColumn('dark_mode');
            }

            if (Schema::hasColumn('users', 'notifications')) {
                $table->dropColumn('notifications');
            }

            if (Schema::hasColumn('users', 'language')) {
                $table->dropColumn('language');
            }

        });
    }
};