<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('payment_transactions') && ! Schema::hasColumn('payment_transactions', 'root_transaction_id')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                $table->foreignId('root_transaction_id')
                    ->nullable()
                    ->constrained('payment_transactions')
                    ->nullOnDelete();
                $table->index(['root_transaction_id', 'attempt_number']);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('payment_transactions') && Schema::hasColumn('payment_transactions', 'root_transaction_id')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                $table->dropIndex(['root_transaction_id', 'attempt_number']);
                $table->dropConstrainedForeignId('root_transaction_id');
            });
        }
    }
};