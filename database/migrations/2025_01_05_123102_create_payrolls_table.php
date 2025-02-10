<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollsTable extends Migration
{
    public function up()
    {
        Schema::create('payrolls', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم مسير الرواتب
            $table->date('registration_date'); // تاريخ التسجيل
            $table->date('start_date'); // تاريخ البدء
            $table->date('end_date'); // تاريخ النهاية
            $table->tinyInteger('select_emp_role')->default(1)->nullable()->comment('(1=>employee) (2=>role)');
            $table->tinyInteger('receiving_cycle')->default(1)->nullable()->comment('1=>monthly, 2=>weekly, 3=>yearly , 4=>Quarterly,5=>Once a week');
            $table->boolean('attendance_check')->default(false); // التحقق من الحضور

            // إضافة أعمدة foreign key
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('jop_title_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();

            // إضافة العلاقات
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('jop_title_id')->references('id')->on('jop_titles')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payrolls');
    }
}
