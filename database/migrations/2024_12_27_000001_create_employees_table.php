<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            # معلومات الموظف
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('nickname')->nullable();
            $table->string('employee_photo')->nullable();
            $table->text('notes')->nullable();
            $table->string('email')->unique();
            $table->tinyInteger('employee_type')->default(1)->comment('(2 مستخدم)(1 موظف)');
            $table->tinyInteger('status')->default(1)->comment('(1 نشط)(2 غير نشط)');
            $table->tinyInteger('allow_system_access')->default(0);
            $table->tinyInteger('send_credentials')->default(0);
            $table->tinyInteger('language')->default(1);
            $table->foreignId('Job_role_id')->constrained('job_roles')->onDelete('cascade');
            // $table->foreignId('access_branches_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->integer('access_branches_id')->nullable();

            # معلومات شخصية
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender')->default(1)->comment('[1-male, 2-female]');
            $table->tinyInteger('nationality_status')->default(1);
            $table->tinyInteger('country')->nullable();

            # معلومات تواصل
            $table->string('mobile_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('personal_email')->nullable();

            # العنوان الحالي
            $table->string('current_address_1')->nullable();
            $table->string('current_address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('postal_code')->nullable();

            # معلومات الوظيفة
            $table->foreignId('job_title_id')->nullable()->constrained('jop_titles')->onDelete('cascade') ;
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade') ;
            $table->foreignId('job_level_id')->nullable()->constrained('functional_levels')->onDelete('cascade');
            $table->foreignId('job_type_id')->nullable()->constrained('types_jobs')->onDelete('cascade');

            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('cascade');
            $table->foreignId('direct_manager_id')->nullable()->constrained('employees')->onDelete('cascade');

            $table->date('hire_date')->nullable();

            $table->foreignId('shift_id')->nullable()->constrained('shifts')->onDelete('cascade');

            $table->integer('created_by');

            $table->integer('custom_financial_month')->nullable();
            $table->integer('custom_financial_day')->nullable();
            $table->string('leave_policy', 100)->nullable(); // سياسة الإجازات
            $table->string('attendance_rate', 100)->nullable(); // معدلات الحضور
            $table->string('attendance_shifts', 100)->nullable(); // ورديات الحضور
            $table->string('holiday_lists', 100)->nullable(); // قوائم العطلات

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
