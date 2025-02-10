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
        Schema::create('leave_policy_customizes', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('use_rules')->default(1)->comment('(قواعد-1) (2-موظفين)'); // اختيار القواعد أو الموظفين

            $table->unsignedBigInteger('leave_policy_id');
            $table->unsignedBigInteger('branch_id')->nullable(); // فرع
            $table->unsignedBigInteger('department_id')->nullable(); // قسم
            $table->unsignedBigInteger('job_title_id')->nullable(); // المسمى الوظيفي

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
            $table->foreign('job_title_id')->references('id')->on('jop_titles')->onDelete('cascade');
            $table->foreign('leave_policy_id')->references('id')->on('leave_policies')->onDelete('cascade');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_policy_customizes');
    }
};
