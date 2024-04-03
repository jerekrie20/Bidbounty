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
            $table->time('start_time')->index('items_start_idx');
            $table->time('end_time')->index('items_end_idx');
            $table->enum('status', ['available', 'pending', 'sold'])->index('items_status_idx')->default('available');
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
