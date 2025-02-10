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
        Schema::create('leave_policy_customize_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('policy_customize_id');
            $table->unsignedBigInteger('employee_id');

            $table->foreign('policy_customize_id')->references('id')->on('leave_policy_customizes')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_policy_customize_employees');
    }
};
