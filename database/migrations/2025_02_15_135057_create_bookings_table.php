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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id'); // الخدمة
            $table->unsignedBigInteger('employee_id'); // الموظف
            $table->date('appointment_date'); // التاريخ
            $table->time('start_time'); // تاريخ البدء
            $table->time('end_time'); // تاريخ النهاية
            $table->unsignedBigInteger('client_id');
            $table->enum('status', ['confirm', 'review', 'bill','cancel','done'])->default('confirm'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
