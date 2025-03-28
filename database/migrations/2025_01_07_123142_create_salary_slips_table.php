<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalarySlipsTable extends Migration
{
    public function up()
    {
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للقسيمة

            // معرف الموظف مع علاقة مع جدول الموظفين - عند حذف الموظف تحذف كل قسائمه
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->date('slip_date'); // تاريخ إنشاء القسيمة
            $table->string('status')->nullable()->default('cancel');
            $table->date('from_date'); // تاريخ بداية فترة الراتب
            $table->date('to_date'); // تاريخ نهاية فترة الراتب
            $table->string('currency', 10); // رمز العملة المستخدمة في القسيمة
            $table->decimal('total_salary', 10, 2)->default(0); // إجمالي الراتب قبل الخصومات
            $table->decimal('total_deductions', 10, 2)->default(0); // إجمالي الخصومات
            $table->decimal('net_salary', 10, 2)->default(0); // صافي الراتب (إجمالي الراتب -
            $table->text('notes')->nullable(); // ملاحظات إضافية - يمكن أن تكون فارغة
            $table->string('attachments')->nullable(); // مسار المرفقات - يمكن أن تكون فارغة
            // طوابع زمنية للإنشاء والتحديث
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_slips'); // حذف الجدول عند التراجع عن الترحيل
    }
}
