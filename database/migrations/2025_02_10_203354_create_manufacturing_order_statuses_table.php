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
        Schema::create('manufacturing_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->comment('Activate manufacturing order statuses')->default(0); // Activate manufacturing order statuses
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manufacturing_order_statuses');
    }
};
