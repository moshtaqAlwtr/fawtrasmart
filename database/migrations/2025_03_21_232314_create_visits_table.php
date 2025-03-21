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
            $table->decimal('employee_latitude', 10, 8)->nullable(); // إحداثيات الموظف وقت الزيارة
            $table->decimal('employee_longitude', 10, 8)->nullable(); // إحداثيات الموظف وقت الزيارة
            $table->timestamps();


        });
    }

    public function down()
    {
        Schema::dropIfExists('visits');
    }
}
