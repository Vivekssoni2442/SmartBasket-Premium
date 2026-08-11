<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('users', 'customer_uid')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('customer_uid', 20)->nullable()->unique()->after('id');
            });
        }

        DB::table('users')->whereNull('customer_uid')->orderBy('id')->each(function ($user) {
            do { $uid = 'CUS-'.Str::upper(Str::random(8)); }
            while (DB::table('users')->where('customer_uid', $uid)->exists());
            DB::table('users')->where('id', $user->id)->update(['customer_uid' => $uid]);
        });
    }

    public function down(): void
    {
        if (Schema::hasColumn('users', 'customer_uid')) {
            Schema::table('users', fn (Blueprint $table) => $table->dropColumn('customer_uid'));
        }
    }
};
