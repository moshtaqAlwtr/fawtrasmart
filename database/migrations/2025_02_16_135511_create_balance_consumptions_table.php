<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceConsumptionsTable extends Migration
{
    public function up()
    {
        Schema::create('balance_consumptions', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي للجدول
            $table->unsignedBigInteger('client_id')->nullable(); // مفتاح خارجي يشير إلى العملاء، يمكن أن يكون فارغًا
            $table->unsignedBigInteger('balance_type_id')->nullable(); // مفتاح خارجي يشير إلى أنواع الأرصدة، يمكن أن يكون فارغًا
            $table->unsignedBigInteger('invoice_id')->nullable(); // مفتاح خارجي يشير إلى الفواتير، يمكن أن يكون فارغًا
            $table->date('consumption_date')->nullable(); // تاريخ الاستهلاك، يمكن أن يكون فارغًا
            $table->tinyInteger('status')->nullable()->default(1); // حالة استهلاك الرصيد، القيمة الافتراضية هي 1 (نشط)
            $table->decimal('used_balance', 10, 2)->nullable(); // مقدار الرصيد المستخدم، يمكن أن يكون فارغًا مع دقة

            $table->text('description')->nullable(); // وصف الاستهلاك، يمكن أن يكون فارغًا
            $table->string('contract_type')->nullable(); // نوع العقد (مثل، مدة)، يمكن أن يكون فارغًا
            $table->timestamps(); // توقيتات الإنشاء والتحديث

            // قيود المفتاح الخارجي
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('balance_type_id')->references('id')->on('balance_types')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('balance_consumptions'); // حذف الجدول إذا كان موجودًا
    }
}
