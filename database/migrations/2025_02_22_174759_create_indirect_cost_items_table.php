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
        Schema::create('indirect_cost_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indirect_costs_id')->references('id')->on('indirect_costs')->onDelete('cascade');
            $table->unsignedBigInteger('restriction_id');
            $table->decimal('restriction_total', 10, 2);
            $table->foreignId('manufacturing_order_id')->constrained('manufactur_orders')->onDelete('cascade');
            $table->decimal('manufacturing_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indirect_cost_items');
    }
};
