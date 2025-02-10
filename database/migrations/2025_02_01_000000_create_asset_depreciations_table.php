<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_depreciations', function (Blueprint $table) {
            $table->id();

            // بيانات الأصل الأساسية
            $table->string('code')->nullable()->comment('كود الأصل'); // الكود
            $table->string('name')->nullable()->comment('اسم الأصل'); // الاسم
            $table->date('date_price')->nullable()->comment('تاريخ الشراء'); // تاريخ الشراء
            $table->date('date_service')->nullable()->comment('تاريخ بداية الخدمة'); // تاريخ بداية الخدمة
            $table->foreignId('account_id')->nullable()->constrained('accounts')->comment('الحساب المرتبط'); // الحساب
            $table->string('place')->nullable()->comment('مكان الأصل'); // المكان
            $table->integer('region_age')->nullable()->comment('العمر الانتاجي'); // العمر الانتاجي
            $table->integer('quantity')->nullable()->default(1)->comment('كمية الأصل'); // الكمية
            $table->text('description')->nullable()->comment('وصف الأصل'); // الوصف

            // بيانات التسعير
            $table->decimal('purchase_value', 15, 2)->nullable()->comment('قيمة الشراء'); // قيمة الشراء
            $table->tinyInteger('currency')->nullable()->default(1)->comment('1=ريال, 2=دولار'); // العملة
            $table->string('cash_account')->nullable()->comment('حساب النقدية'); // حساب النقدية
            $table->tinyInteger('tax1')->nullable()->default(1)->comment('1=القيمة المضافة, 2=صفرية, 3=قيمة مضافة'); // الضريبة 1
            $table->tinyInteger('tax2')->nullable()->default(1)->comment('1=القيمة المضافة, 2=صفرية, 3=قيمة مضافة'); // الضريبة 2

            // بيانات الإهلاك

            // العلاقات
            $table->foreignId('employee_id')->nullable()->constrained('employees')->comment('الموظف المسؤول');
            $table->foreignId('client_id')->nullable()->constrained('clients')->comment('العميل المرتبط');

            // المرفقات
            $table->string('attachments')->nullable()->comment('مسار ملفات المرفقات');
            $table->tinyInteger('status')->default(2)->comment('1: في الخدمة, 2: تم البيع , 3: مهلك');

            // الحقول المشتركة
            // $table->foreignId('created_by')->nullable()->constrained('users')->comment('منشئ السجل');
            // $table->foreignId('updated_by')->nullable()->constrained('users')->comment('محدث السجل');
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_depreciations');
    }
};
