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
        Schema::create('custom_shifts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('from_date'); // من تاريخ
            $table->date('to_date');   // إلى تاريخ
            $table->unsignedBigInteger('shift_id'); // وردية
            $table->tinyInteger('use_rules')->default(1)->comment('(قواعد-1) (2-موظفين)'); // اختيار القواعد أو الموظفين
            $table->unsignedBigInteger('branch_id')->nullable(); // فرع
            $table->unsignedBigInteger('department_id')->nullable(); // قسم
            $table->unsignedBigInteger('job_title_id')->nullable(); // المسمى الوظيفي
            $table->unsignedBigInteger('shift_rule_id')->nullable(); // وردية
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('job_title_id')->references('id')->on('jop_titles')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->foreign('shift_rule_id')->references('id')->on('shifts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_shifts');
    }
};
