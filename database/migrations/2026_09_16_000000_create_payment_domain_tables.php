<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('gateway', 40);
            $table->string('gateway_reference', 255)->nullable()->unique();
            $table->string('payment_method', 40)->nullable();
            $table->string('status', 30)->default('pending');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('idempotency_key', 80)->nullable()->unique();
            $table->json('metadata')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('captured_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'status']);
            $table->index(['gateway', 'status']);
        });

        Schema::create('payment_order', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['payment_id', 'order_id']);
            $table->index('order_id');
        });

        if (Schema::hasTable('payment_transactions')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                if (! Schema::hasColumn('payment_transactions', 'payment_id')) {
                    $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
                }
                if (! Schema::hasColumn('payment_transactions', 'attempt_number')) {
                    $table->unsignedInteger('attempt_number')->default(1);
                }
                if (! Schema::hasColumn('payment_transactions', 'transaction_type')) {
                    $table->string('transaction_type', 30)->default('payment');
                }
                if (! Schema::hasColumn('payment_transactions', 'gateway_transaction_id')) {
                    $table->string('gateway_transaction_id', 255)->nullable();
                }
                if (! Schema::hasColumn('payment_transactions', 'request_metadata')) {
                    $table->json('request_metadata')->nullable();
                }
                if (! Schema::hasColumn('payment_transactions', 'response_metadata')) {
                    $table->json('response_metadata')->nullable();
                }
                if (! Schema::hasColumn('payment_transactions', 'initiated_at')) {
                    $table->timestamp('initiated_at')->nullable();
                }
                if (! Schema::hasColumn('payment_transactions', 'completed_at')) {
                    $table->timestamp('completed_at')->nullable();
                }
            });

            Schema::table('payment_transactions', function (Blueprint $table) {
                $table->index(['payment_id', 'status']);
                $table->index('gateway_transaction_id');
            });
        }

        Schema::create('payment_webhooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->string('gateway', 40);
            $table->string('gateway_event_id', 255)->nullable()->unique();
            $table->string('event_type', 100)->nullable();
            $table->string('status', 30)->default('received');
            $table->json('payload')->nullable();
            $table->json('headers')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();
            $table->index(['gateway', 'status']);
        });

        Schema::create('refunds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('order_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('seller_id')->nullable()->constrained('seller_profiles')->nullOnDelete();
            $table->foreignId('payment_transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->string('gateway_refund_id', 255)->nullable()->unique();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('INR');
            $table->string('status', 30)->default('requested');
            $table->string('reason', 255)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
            $table->index(['payment_id', 'status']);
            $table->index(['seller_id', 'status']);
        });

        Schema::create('payment_audit_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_transaction_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event', 100);
            $table->string('from_status', 30)->nullable();
            $table->string('to_status', 30)->nullable();
            $table->json('metadata')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 1000)->nullable();
            $table->timestamps();
            $table->index(['payment_id', 'event']);
        });

        if (Schema::hasTable('seller_earnings')) {
            Schema::table('seller_earnings', function (Blueprint $table) {
                if (! Schema::hasColumn('seller_earnings', 'payment_id')) {
                    $table->foreignId('payment_id')->nullable()->constrained()->nullOnDelete();
                }
            });
            Schema::table('seller_earnings', fn (Blueprint $table) => $table->index(['payment_id', 'status']));
        }

        Schema::create('seller_payout_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_payout_id')->constrained()->cascadeOnDelete();
            $table->foreignId('seller_earning_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->timestamps();
            $table->unique(['seller_payout_id', 'seller_earning_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seller_payout_earnings');

        if (Schema::hasTable('seller_earnings') && Schema::hasColumn('seller_earnings', 'payment_id')) {
            Schema::table('seller_earnings', fn (Blueprint $table) => $table->dropColumn('payment_id'));
        }

        Schema::dropIfExists('payment_audit_records');
        Schema::dropIfExists('refunds');
        Schema::dropIfExists('payment_webhooks');

        if (Schema::hasTable('payment_transactions')) {
            Schema::table('payment_transactions', function (Blueprint $table) {
                foreach (['payment_id', 'attempt_number', 'transaction_type', 'gateway_transaction_id', 'request_metadata', 'response_metadata', 'initiated_at', 'completed_at'] as $column) {
                    if (Schema::hasColumn('payment_transactions', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        Schema::dropIfExists('payment_order');
        Schema::dropIfExists('payments');
    }
};
