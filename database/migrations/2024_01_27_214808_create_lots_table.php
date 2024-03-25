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
        Schema::create('lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable()->default(null);
            $table->string('image')->nullable()->default(null);
            $table->enum('status', ['upcoming', 'live', 'pending' , 'closed'])->index('lots_status_idx')->default('upcoming');
//            $table->enum('category', ['livestock', 'equipment ', 'supplies', 'farm products', 'land', 'Other'])->index('lots_category_idx')->default('Other');
            $table->dateTime('start_date')->index('lots_start_idx');
            $table->dateTime('end_date')->index('lots_end_idx');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lots');
    }
};
