<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            // بيانات المورد الأساسية
            $table->string('number_suply')->unique(); // رقم المورد
            $table->string('trade_name'); // الاسم التجاري
            $table->string('first_name')->nullable(); // الاسم الأول
            $table->string('last_name')->nullable(); // الاسم الأخير

            // معلومات الاتصال
            $table->string('phone')->nullable(); // الهاتف
            $table->string('mobile')->nullable(); // الجوال
            $table->string('email')->nullable(); // البريد الإلكتروني

            // العنوان
            $table->string('street1')->nullable(); // عنوان الشارع 1
            $table->string('street2')->nullable(); // عنوان الشارع 2
            $table->string('city')->nullable(); // المدينة
            $table->string('region')->nullable(); // المنطقة
            $table->string('postal_code')->nullable(); // الرمز البريدي
            $table->string('country')->default('SA'); // البلد

            // المعلومات القانونية
            $table->string('tax_number')->nullable(); // الرقم الضريبي
            $table->string('commercial_registration')->nullable(); // السجل التجاري

            // المعلومات المالية
            $table->decimal('opening_balance', 15, 2)->nullable(); // الرصيد الافتتاحي
            $table->date('opening_balance_date')->nullable(); // تاريخ الرصيد الافتتاحي
            $table->string('currency')->default('SAR')->nullable(); // العملة

            // معلومات إضافية
            $table->text('notes')->nullable(); // الملاحظات
            $table->string('attachments')->nullable(); // المرفقات
            $table->unsignedBigInteger('employee_id')->nullable();
            // التتبع
            $table->unsignedBigInteger('created_by')->nullable();

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            // العلاقات
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });

        // جدول جهات الاتصال للمورد

    }

    public function down()
    {
        Schema::dropIfExists('supplier_contacts');
        Schema::dropIfExists('suppliers');
    }
}
