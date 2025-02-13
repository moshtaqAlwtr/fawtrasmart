<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id(); // معرف القسط
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade'); // معرف الفاتورة
            $table->decimal('amount', 10, 2)->nullable(); // مبلغ القسط (قابل للاحتواء على قيمة فارغة)
            $table->integer('installment_number')->nullable(); // رقم القسط (قابل للاحتواء على قيمة فارغة)
            $table->date('due_date')->nullable(); // تاريخ الاستحقاق (قابل للاحتواء على قيمة فارغة)
            $table->tinyInteger('payment_rate')->nullable()->default(1); // نسبة الدفع (قابلة للاحتواء على قيمة فارغة)
            $table->tinyInteger('status')->nullable()->default(1);

            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    public function down()
    {
        Schema::dropIfExists('installments');
    }
}
