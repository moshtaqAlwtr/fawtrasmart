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
        Schema::create('attendance_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('start_month'); // شهر بداية السنة المالية
            $table->unsignedTinyInteger('start_day'); // يوم بداية السنة المالية
            $table->boolean('allow_second_shift')->default(false); // إتاحة الوردية الثانية
            $table->boolean('allow_backdated_requests')->default(false); // السماح بإدخال طلبات الإجازة لتواريخ سابقة
            $table->boolean('direct_manager_approval')->default(false); // موافقة المديرين المباشرين
            $table->boolean('department_manager_approval')->default(false); // موافقة مديري الأقسام
            $table->boolean('employees_approval')->default(false); // موافقة الموظفين المخصصين
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_settings');
    }
};
