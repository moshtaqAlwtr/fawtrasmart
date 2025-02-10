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
        Schema::create('custom_shifts_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('custom_shifts_id');
            $table->unsignedBigInteger('employee_id');

            $table->foreign('custom_shifts_id')->references('id')->on('custom_shifts')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_shifts_employees');
    }
};
