<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // جدول الفواتير المنشأة من الفواتير الدورية
        Schema::create('periodic_invoice_instances', function (Blueprint $table) {
            $table->id(); // معرف الفاتورة المنشأة

            $table
                ->foreignId('periodic_invoice_id')
                ->nullable() // معرف الفاتورة الدورية الأصلية
                ->constrained('periodic_invoices')
                ->onDelete('cascade'); // عند حذف الفاتورة الدورية، تحذف جميع الفواتير المرتبطة بها

            $table
                ->foreignId('invoice_id') // معرف الفاتورة التي تم إنشاؤها
                ->constrained('invoices') // مرتبط بجدول invoices
                ->onDelete('cascade'); // عند حذف الفاتورة الرئيسية، يتم حذف هذا السجل

            $table->integer('instance_number'); // رقم تسلسل الفاتورة (مثلاً: الفاتورة الثانية من أصل 10)
            $table->date('due_date'); // تاريخ استحقاق الفاتورة
            $table->tinyInteger('status')->default(1)->comment('1=>pending, 2=>generated, 3=>cancelled'); // حالة الفاتورة

            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down()
    {
        Schema::dropIfExists('periodic_invoice_instances');
    }
};
