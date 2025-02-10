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
        Schema::create('template_units', function (Blueprint $table) {
            $table->id();
            $table->string('base_unit_name'); // اسم الوحدة الأساسية
            $table->string('discrimination');
            $table->string('template')->nullable(); // القالب (مثال: الوزن)
            $table->tinyInteger('status')->default(0); // حالة النشاط
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('template_units');
    }
};
