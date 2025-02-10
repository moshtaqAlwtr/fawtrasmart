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
        Schema::create('shift_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_id')->constrained('shifts')->onDelete('cascade');
            $table->enum('day', ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']); // اسم اليوم
            $table->tinyInteger('working_day')->default(0); // يوم عمل أو إجازة (1 أو 0)
            $table->time('start_time'); // وقت بدء الوردية
            $table->time('end_time'); // وقت انتهاء الوردية
            $table->time('login_start_time'); // وقت بداية السماح بتسجيل الدخول
            $table->time('login_end_time'); // وقت نهاية السماح بتسجيل الدخول
            $table->time('logout_start_time'); // وقت بداية السماح بتسجيل الخروج
            $table->time('logout_end_time'); // وقت نهاية السماح بتسجيل الخروج
            $table->integer('grace_period'); // فترة السماح بالدقائق
            $table->integer('delay_calculation')->default(15); // حساب التأخير (صحيح أو خطأ)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_days');
    }
};
