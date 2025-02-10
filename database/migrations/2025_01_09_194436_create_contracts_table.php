<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id(); // المعرف الفريد للعقد - يتم إنشاؤه تلقائياً بشكل تسلسلي

            // العلاقات الأساسية
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade'); // ربط العقد بالموظف - عند حذف الموظف يتم حذف عقوده
            $table->foreignId('job_title_id')->constrained('jop_titles')->onDelete('cascade'); // ربط العقد بالمسمى الوظيفي
            $table->foreignId('job_level_id')->constrained('functional_levels')->onDelete('cascade'); // ربط العقد بالمستوى الوظيفي
            $table->foreignId('salary_temp_id')->constrained('salary_template')->onDelete('cascade'); // ربط العقد بقالب الراتب

            // معلومات العقد الأساسية
            $table->string('code')->unique(); // رقم العقد - يجب أن يكون فريداً
            $table->string('description')->nullable(); // وصف العقد - يمكن تركه فارغاً
            $table->foreignId('parent_contract_id')->nullable()->constrained('contracts')->onDelete('set null'); // ربط العقد بعقد أساسي آخر (مثل التجديد)

            // فترة العقد
            $table->date('start_date'); // تاريخ بداية العقد
            $table->date('end_date')->nullable(); // تاريخ نهاية العقد - اختياري في حالة العقود المفتوحة

            // تفاصيل نوع ومدة العقد
            $table->tinyInteger('type_contract')->default(1)->nullable()->comment('(1=>period) (2=>end_date)'); // نوع العقد: 1 للمدة المحددة، 2 لتاريخ الانتهاء
            $table->tinyInteger('duration_unit')->nullable()->default(1)->comment('(1=>day) (2=>month) (3=>year)'); // وحدة المدة: 1 يوم، 2 شهر، 3 سنة
            $table->integer('duration')->nullable(); // قيمة المدة (العدد) حسب الوحدة المختارة

            $table->integer('amount')->nullable(); // قيمة المدة (العدد) حسب الوحدة المختارة

            // تواريخ مهمة
            $table->date('join_date'); // تاريخ مباشرة العمل الفعلي
            $table->date('probation_end_date'); // تاريخ انتهاء فترة التجربة
            $table->date('contract_date'); // تاريخ توقيع العقد

            // معلومات الراتب والدفع
            $table->tinyInteger('receiving_cycle')->default(1)->nullable()->comment('1=>monthly, 2=>weekly, 3=>yearly , 4=>Quarterly,5=>Once a week'); // دورة استلام الراتب
            $table->string('currency', 3)->default('SAR'); // عملة الراتب - افتراضياً الريال السعودي
            $table->string('attachments')->nullable(); // مسار تخزين المرفقات والمستندات المتعلقة بالعقد

            // معلومات النظام
            $table->timestamps(); // تاريخ إنشاء وتحديث السجل في قاعدة البيانات
        });
    }

    public function down()
    {
        Schema::dropIfExists('contracts'); // دالة حذف الجدول في حالة التراجع عن المايجريشن
    }
};
