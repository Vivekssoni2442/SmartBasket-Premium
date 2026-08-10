<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'date_of_birth')) {
                $table->date('date_of_birth')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'gender')) {
                $table->string('gender')->nullable()->after('date_of_birth');
            }
            if (!Schema::hasColumn('users', 'house_no')) {
                $table->string('house_no')->nullable()->after('address');
            }
            if (!Schema::hasColumn('users', 'street')) {
                $table->string('street')->nullable()->after('house_no');
            }
            if (!Schema::hasColumn('users', 'area')) {
                $table->string('area')->nullable()->after('street');
            }
            if (!Schema::hasColumn('users', 'landmark')) {
                $table->string('landmark')->nullable()->after('area');
            }
            if (!Schema::hasColumn('users', 'country')) {
                $table->string('country')->nullable()->after('state');
            }
            if (!Schema::hasColumn('users', 'language')) {
                $table->string('language')->default('English')->after('country');
            }
            if (!Schema::hasColumn('users', 'dark_mode')) {
                $table->string('dark_mode')->default('light')->after('language');
            }
            if (!Schema::hasColumn('users', 'notifications')) {
                $table->string('notifications')->default('enabled')->after('dark_mode');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'date_of_birth',
                'gender',
                'house_no',
                'street',
                'area',
                'landmark',
                'country',
                'language',
                'dark_mode',
                'notifications',
            ]);
        });
    }
};
