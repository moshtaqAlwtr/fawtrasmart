<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_quotations_view', function (Blueprint $table) {
            // المعرف الفريد للجدول
            $table->id();

            // معرف المورد (مرتبط بجدول الموردين)
            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('restrict');

            // معرف الحساب الفرعي (مرتبط بجدول الحسابات)
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('restrict');

            // تاريخ إنشاء عرض السعر
            $table->date('date');

            $table->string('code')->unique();
            // عدد أيام صلاحية العرض (0 افتراضياً)
            $table->integer('valid_days')->default(0);

            // إجمالي الخصومات
            $table->decimal('total_discount', 10, 2)->default(0);

            // المجموع النهائي بعد الخصم والضريبة
            $table->decimal('grand_total', 10, 2)->default(0);

            // حالة العرض (1: نشط، يمكن إضافة حالات أخرى)
            $table->tinyInteger('status')->nullable()->default(1);
            // معرف المستخدم الذي أنشأ العرض
            $table->foreignId('created_by')->constrained('users');

            // معرف المستخدم الذي قام بآخر تحديث (اختياري)
            $table->foreignId('updated_by')->nullable()->constrained('users');

            // طوابع زمنية للإنشاء والتحديث
            $table->timestamps();

            // حذف ناعم (soft delete) - يحتفظ بالسجل في قاعدة البيانات
        });
    }

    public function down()
    {
        // حذف الجدول عند التراجع عن الهجرة
        Schema::dropIfExists('purchase_quotations');
    }
};
