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
        Schema::create('attendance_settings_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_settings_id');
            $table->unsignedBigInteger('employee_id');
            $table->timestamps();

            $table->foreign('attendance_settings_id')->references('id')->on('attendance_settings')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_settings_employees');
    }
};
