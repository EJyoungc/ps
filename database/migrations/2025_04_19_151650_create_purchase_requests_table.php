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
        Schema::create('purchase_requests', function (Blueprint $table) {
            $table->id();
    $table->foreignId('user_id')->constrained(); // Requester
    $table->foreignId('department_id')->constrained();
    $table->text('items');
    $table->text('specifications');
    $table->decimal('estimated_cost', 10, 2);
    $table->enum('status', ['draft', 'submitted', 'approved', 'rejected', 'completed']);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_requests');
    }
};
