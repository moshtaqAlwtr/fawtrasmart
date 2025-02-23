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
        Schema::create('manufactur_orders', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->date('from_date');
            $table->date('to_date');
            $table->foreignId('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->foreignId('employee_id')->references('id')->on('employees')->onDelete('cascade')->nullable();
            $table->foreignId('client_id')->references('id')->on('clients')->onDelete('cascade')->nullable();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('quantity');
            $table->foreignId('production_material_id')->references('id')->on('production_materials')->onDelete('cascade')->nullable();
            $table->foreignId('production_path_id')->references('id')->on('production_paths')->onDelete('cascade')->nullable();
            $table->decimal('last_total_cost', 10, 2);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufactur_orders');
    }
};
