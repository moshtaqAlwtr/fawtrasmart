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
        Schema::create('attendance_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->date('attendance_date');
            $table->enum('status', ['present', 'absent', 'late']);
            $table->time('start_shift')->nullable();
            $table->time('end_shift')->nullable();
            $table->time('login_time')->nullable();
            $table->time('logout_time')->nullable();
            $table->unsignedTinyInteger('absence_type')->nullable(); // (1: اعتيادية, 2: عرضية)
            $table->integer('absence_balance')->nullable();
            $table->text('notes')->nullable();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_days');
    }
};
