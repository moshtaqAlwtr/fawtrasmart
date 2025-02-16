<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoyaltyRulesTable extends Migration
{
    /**
     * تشغيل المايجريشن.
     *
     * @return void
     */
    public function up()
    {
        // إنشاء جدول قواعد الولاء
        Schema::create('loyalty_rules', function (Blueprint $table) {
            $table->id(); // عمود معرف فريد
            $table->string('name')->nullable(); // عمود لاسم القاعدة
            $table->tinyInteger('status')->default(1)->nullable(); // عمود لحالة القاعدة (1 نشط، 2 غير نشط)
            $table->string('priority_level')->nullable(); // عمود لدرجة الأولوية
            $table->decimal('collection_factor', 10, 3)->nullable(); // عمود لمعامل جمع الرصيد
            $table->decimal('minimum_total_spent', 10, 2)->nullable(); // عمود للحد الأدنى للصرف
            $table->tinyInteger('currency_type')->nullable()->default(1); // عمود لنوع العملة
            $table->integer('period')->nullable(); // عمود لفترة صلاحية القاعدة
            $table->tinyInteger('period_unit')->nullable()->default(1); // عمود لوحدة الفترة (1 يوم، 2 شهر، 3 سنة، 4 لا تنتهي صلاحيتها)
            $table->timestamps(); // أعمدة timestamps لإنشاء وتحديث الوقت
        });

        // إنشاء جدول وسيط لربط العملاء بقواعد الولاء
        Schema::create('client_loyalty_rule', function (Blueprint $table) {
            $table->id(); // عمود معرف فريد
            $table->foreignId('client_id')->constrained()->onDelete('cascade')->nullable(); // عمود لرقم تعريف العميل مع علاقة
            $table->foreignId('loyalty_rule_id')->constrained()->onDelete('cascade')->nullable(); // عمود لرقم تعريف قاعدة الولاء مع علاقة
        });
    }

    /**
     * التراجع عن المايجريشن.
     *
     * @return void
     */
    public function down()
    {
        // حذف جدول العملاء وقواعد الولاء
        Schema::dropIfExists('client_loyalty_rule'); // حذف جدول ربط العملاء
        Schema::dropIfExists('loyalty_rules'); // حذف جدول قواعد الولاء
    }
}
