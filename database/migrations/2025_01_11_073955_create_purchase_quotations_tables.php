<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_quotations', function (Blueprint $table) {
            $table->id();
            // المعلومات الأساسية
            $table->string('code')->unique();
            $table->date('order_date');
            $table->date('due_date')->nullable();
            // الملاحظات والمرفقات
            $table->tinyInteger('status')->default(1)->comment('1=>pending, 2=>completed, 3=>ignored , 4=>rescheduled ');

            $table->text('notes')->nullable();
            $table->string('attachments')->nullable();

            // معلومات النظام
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // جدول تفاصيل المنتجات في عرض السعر

    }

    public function down()
    {

        Schema::dropIfExists('purchase_quotations');
    }
};
