<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->after('number');
            $table->string('coupon_code')->nullable()->after('total');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('coupon_code');
            $table->timestamp('paid_at')->nullable()->after('notes');
            $table->timestamp('shipped_at')->nullable()->after('paid_at');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['invoice_number', 'coupon_code', 'discount_amount', 'paid_at', 'shipped_at']);
        });
    }
};
