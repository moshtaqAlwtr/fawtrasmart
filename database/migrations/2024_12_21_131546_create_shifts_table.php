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
        Schema::create('shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الوردية
            $table->tinyInteger('type')->default(1)->comment('(2أساسي1/متقدم)'); // نوع الوردية (أساسي/متقدم)

            // $table->time('start_time'); // بداية الوردية
            // $table->time('end_time'); // نهاية الوردية
            // $table->time('login_start_time'); // بداية تسجيل الدخول
            // $table->time('login_end_time'); // نهاية تسجيل الدخول
            // $table->time('logout_start_time'); // بداية تسجيل الخروج
            // $table->time('logout_end_time'); // نهاية تسجيل الخروج
            // $table->integer('grace_period')->default(15); // فترة سماح التأخير (بالدقائق)

            // $table->tinyInteger('delay_calculation')->default(1);

            // $table->tinyInteger('sunday')->default(0);
            // $table->tinyInteger('monday')->default(0);
            // $table->tinyInteger('tuesday')->default(0);
            // $table->tinyInteger('wednesday')->default(0);
            // $table->tinyInteger('thursday')->default(0);
            // $table->tinyInteger('friday')->default(0);
            // $table->tinyInteger('saturday')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
