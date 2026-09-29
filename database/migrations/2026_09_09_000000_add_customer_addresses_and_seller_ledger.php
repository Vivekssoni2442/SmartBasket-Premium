<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('label', 50)->default('Home');
            $table->string('recipient_name');
            $table->string('phone', 20);
            $table->text('address_line');
            $table->string('city');
            $table->string('state');
            $table->string('pincode', 20);
            $table->string('country', 100)->default('India');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->index(['user_id', 'is_default']);
        });

        Schema::create('seller_earnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('seller_profiles')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('order_item_key')->nullable();
            $table->decimal('gross_amount', 12, 2);
            $table->decimal('platform_fee', 12, 2)->default(0);
            $table->decimal('net_amount', 12, 2);
            $table->string('status', 30)->default('pending');
            $table->timestamp('available_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->unique(['seller_id', 'order_id']);
            $table->index(['seller_id', 'status']);
        });

        Schema::create('seller_payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('seller_profiles')->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->string('status', 30)->default('requested');
            $table->string('reference', 255)->nullable()->unique();
            $table->text('seller_note')->nullable();
            $table->text('admin_note')->nullable();
            // Admin primary keys are strings (ADMIN-...), unlike customer/seller ids.
            $table->string('reviewed_by')->nullable()->index();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->index(['seller_id', 'status']);
        });

        Schema::table('admins', function (Blueprint $table) {
            if (! Schema::hasColumn('admins', 'notification_preferences')) {
                $table->json('notification_preferences')->nullable()->after('dark_mode');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'notification_preferences')) $table->dropColumn('notification_preferences');
        });
        Schema::dropIfExists('seller_payouts');
        Schema::dropIfExists('seller_earnings');
        Schema::dropIfExists('customer_addresses');
    }
};
