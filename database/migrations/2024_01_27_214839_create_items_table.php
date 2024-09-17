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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lot_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable()->default(null);
            $table->decimal('starting_bid', 10, 2);
            $table->decimal('current_bid', 10, 2);
            $table->decimal('reserve_price', 10, 2)->nullable()->default(null);
            $table->datetime('start_time')->index('items_start_idx');
            $table->datetime('end_time')->index('items_end_idx');
            $table->enum('status', ['Available', 'Pending', 'Sold'])->index('items_status_idx')->default('available');
            $table->enum('payment_status', ['Pending Payment', 'Customer Paid', 'Payment Sent', 'Payment cancelled'])->index('items_payment_status_idx')->default('pending');
            $table->enum('shipping_status', ['Package Ready', 'Pending Shipping', 'Shipped', 'Delivered'])->index('items_shipping_status_idx')->default('pending');
            $table->json('images')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
