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
        Schema::create('holy_day_list_customize_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('holyday_customizes_id');
            $table->unsignedBigInteger('employee_id');

            $table->foreign('holyday_customizes_id')->references('id')->on('holy_day_list_customizes')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holy_day_list_customize_employees');
    }
};
