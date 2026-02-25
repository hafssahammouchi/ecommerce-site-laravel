<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('pending'); // pending, confirmed, shipped, delivered, cancelled
            $table->decimal('subtotal', 10, 2);
            $table->decimal('delivery_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->string('delivery_option'); // standard, express, relay
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->string('shipping_name');
            $table->string('shipping_address');
            $table->string('shipping_city');
            $table->string('shipping_postal_code');
            $table->string('shipping_country')->default('France');
            $table->decimal('shipping_lat', 10, 7)->nullable();
            $table->decimal('shipping_lng', 10, 7)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
