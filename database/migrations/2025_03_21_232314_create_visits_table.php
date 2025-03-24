<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsTable extends Migration
{
    public function up()
    {
        Schema::create('visits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable(); // معرف الموظف
            $table->unsignedBigInteger('client_id')->nullable(); // معرف العميل
            $table->dateTime('visit_date'); // تاريخ وتوقيت الزيارة
            $table->enum('status', ['present', 'absent'])->default('present'); // حالة الحضور
            $table->decimal('employee_latitude', 10, 8)->nullable(); // خط عرض موقع الموظف
            $table->decimal('employee_longitude', 11, 8)->nullable(); // خط طول موقع الموظف
            $table->timestamp('arrival_time')->nullable(); // وقت الوصول
            $table->timestamp('departure_time')->nullable(); // وقت المغادرة
            $table->text('notes')->nullable(); // ملاحظات حول الزيارة
            $table->decimal('client_latitude', 10, 8)->nullable(); // خط عرض موقع العميل
            $table->decimal('client_longitude', 11, 8)->nullable(); // خط طول موقع العميل
            $table->decimal('distance', 8, 2)->nullable(); // المسافة بين الموظف والعميل بالمتر
            $table->enum('recording_method', ['auto', 'manual'])->default('auto')->nullable(); // طريقة التسجيل
            $table->boolean('is_approved')->default(false)->nullable(); // هل تمت الموافقة على الزيارة
            $table->unsignedBigInteger('approved_by')->nullable(); // المسؤول الذي وافق على الزيارة

            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
