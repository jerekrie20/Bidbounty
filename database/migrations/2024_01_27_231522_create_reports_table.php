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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->nullableMorphs('reportable'); // Polymorphic relation (can be a user, an item, etc.)
            $table->enum('type', ['user', 'item', 'bug', 'other'])->index('reports_type_idx')->default('other');
            $table->text('message');
            $table->json('metadata')->nullable(); // Additional data, if needed
            $table->text('response')->nullable()->default(null);
            $table->enum('status', ['pending', 'reviewed', 'resolved'])->index('reports_status_idx')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
