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
        // تعديل الجدول الحالي
        Schema::table('branch_settings', function (Blueprint $table) {
            // إضافة الأعمدة الجديدة
            $table->string('name')->nullable(); // اسم الصلاحية
            $table->string('key')->unique(); // مفتاح فريد للصلاحية

            // حذف الأعمدة القديمة التي لا حاجة لها بعد التعديل
            $table->dropColumn([
                'share_cost_center',
                'share_customers',
                'share_products',
                'share_suppliers',
                'account_tree',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
