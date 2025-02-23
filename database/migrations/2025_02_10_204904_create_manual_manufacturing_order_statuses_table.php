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
        Schema::create('manual_manufacturing_order_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_status_id')->constrained('manufacturing_order_statuses')->onDelete('cascade');
            $table->string('name');
            $table->string('color')->default('#ffffff');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_manufacturing_order_statuses');
    }
};
