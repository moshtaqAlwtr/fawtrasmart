<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('serial_settings', function (Blueprint $table) {
            $table->id();
            $table->string('section')->unique(); // اسم القسم
            $table->integer('current_number')->default(0); // الرقم الحالي
            $table->integer('number_of_digits')->default(5); // عدد الأرقام
            $table->string('prefix')->nullable(); // البادئة
            $table->integer('mode')->default(0); // نمط الترقيم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('serial_settings');
    }
};
