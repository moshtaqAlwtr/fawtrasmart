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
        Schema::create('attendance_sheets_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attendance_sheets_id');
            $table->unsignedBigInteger('employee_id');

            $table->foreign('attendance_sheets_id')->references('id')->on('attendance_sheets')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_sheets_employees');
    }
};
