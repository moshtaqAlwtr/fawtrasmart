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
        Schema::create('manufactur_orders_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manufactur_order_id')->references('id')->on('manufactur_orders')->onDelete('cascade');
            # raw material ( all required data for raw material )
            $table->foreignId('raw_product_id')->constrained('products')->onDelete('cascade')->nullable();
            $table->foreignId('raw_production_stage_id')->constrained('production_stages')->onDelete('cascade')->nullable();
            $table->decimal('raw_unit_price', 10, 2)->nullable();
            $table->integer('raw_quantity')->nullable();
            $table->decimal('raw_total', 10, 2)->nullable();
            # expenses
            $table->foreignId('expenses_account_id')->references('id')->on('accounts')->onDelete('cascade')->nullable();
            $table->foreignId('expenses_production_stage_id')->constrained('production_stages')->onDelete('cascade')->nullable();
            $table->tinyInteger('expenses_cost_type')->default(1)->nullable();
            $table->decimal('expenses_price', 10, 2)->nullable();
            $table->string('expenses_description', 255)->nullable();
            $table->decimal('expenses_total', 10, 2)->nullable();
            # manufacturing
            $table->foreignId('workstation_id')->references('id')->on('work_stations')->onDelete('cascade')->nullable();
            $table->integer('operating_time')->nullable();
            $table->foreignId('manu_production_stage_id')->constrained('production_stages')->onDelete('cascade')->nullable();
            $table->tinyInteger('manu_cost_type')->default(1)->nullable();
            $table->decimal('manu_total_cost', 10, 2)->nullable();
            $table->string('manu_description', 255)->nullable();
            $table->decimal('manu_total', 10, 2)->nullable();
            # end life
            $table->foreignId('end_life_product_id')->references('id')->on('products')->onDelete('cascade')->nullable();
            $table->foreignId('end_life_production_stage_id')->constrained('production_stages')->onDelete('cascade')->nullable();
            $table->integer('end_life_unit_price')->nullable();
            $table->integer('end_life_quantity')->nullable();
            $table->decimal('end_life_total', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufactur_orders_items');
    }
};
