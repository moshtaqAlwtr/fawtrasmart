<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMachinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الماكينة
            $table->tinyInteger('status')->default(1); // الحالة (نشط/غير نشط)
            $table->string('serial_number')->nullable(); // الرقم التسلسلي
            $table->string('host_name')->nullable(); // اسم المضيف
            $table->integer('port_number')->nullable(); // رقم المنفذ
            $table->string('connection_key')->nullable(); // مفتاح الاتصال
            $table->string('machine_type')->nullable(); // نوع الماكينة
            $table->timestamps();

        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('machines');
    }
}
