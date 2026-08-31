<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const COLUMNS = [
        'email_verification_code_hash' => ['string', null],
        'email_verification_expires_at' => ['timestamp', null],
        'email_verification_attempts' => ['unsignedTinyInteger', 0],
        'business_name' => ['string', null],
        'business_address' => ['text', null],
        'business_city' => ['string', null],
        'business_state' => ['string', null],
        'business_pincode' => ['string', null],
        'bank_account_holder_name' => ['string', null],
        'bank_branch' => ['string', null],
        'application_submitted_at' => ['timestamp', null],
    ];

    public function up(): void
    {
        foreach (self::COLUMNS as $column => [$type, $default]) {
            if (Schema::hasColumn('seller_profiles', $column)) {
                continue;
            }

            Schema::table('seller_profiles', function (Blueprint $table) use ($column, $type, $default) {
                $definition = match ($type) {
                    'text' => $table->text($column)->nullable(),
                    'timestamp' => $table->timestamp($column)->nullable(),
                    'unsignedTinyInteger' => $table->unsignedTinyInteger($column)->default($default),
                    default => $table->string($column)->nullable(),
                };
            });
        }
    }

    public function down(): void
    {
        foreach (array_keys(self::COLUMNS) as $column) {
            if (Schema::hasColumn('seller_profiles', $column)) {
                Schema::table('seller_profiles', function (Blueprint $table) use ($column) {
                    $table->dropColumn($column);
                });
            }
        }
    }
};
