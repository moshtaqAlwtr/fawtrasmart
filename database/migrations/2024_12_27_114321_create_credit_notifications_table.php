<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('credit_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null'); // العميل
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // مسئول المبيعات
            $table->date('credit_date')->nullable(); // تاريخ  الاشعار الدائن
            $table->date('release_date')->nullable(); // تاريخ الاصدار
            $table->string('credit_number')->nullable(); // رقم الاشعار
            $table->decimal('subtotal', 10, 2)->nullable(); // المجموع الفرعي
            $table->decimal('due_value', 10, 2)->nullable();
            $table->tinyInteger('status')->nullable()->default(1)->comment('1:Draft, 2:Pending, 3:Approved, 4:Converted to Invoice, 5:Cancelled');
            $table->decimal('total_discount', 10, 2)->nullable(); // مجموع الخصومات
            $table->decimal('total_tax', 10, 2)->nullable(); // مجموع الضرائب
            $table->decimal('shipping_cost', 10, 2)->nullable(); // تكلفة الشحن
            $table->decimal('next_payment', 10, 2)->nullable(); // الدفعة القادمة
            $table->decimal('grand_total', 10, 2)->nullable(); // المجموع الكلي
            $table->text('notes')->nullable(); // الملاحظات/الشروط
            $table->string('discount_type')->nullable(); // نوع الخصم (مبلغ أو نسبة)
            $table->decimal('discount_amount', 10, 2)->nullable(); // قيمة الخصم
            $table->string('tax_type')->nullable(); // نوع الضريبة (القيمة المضافة، صفرية، معفاة)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('quotes', function (Blueprint $table) {
            $table->dropForeign(['client_id']); // حذف المفتاح الأجنبي للعميل
            $table->dropForeign(['created_by']); // حذف المفتاح الأجنبي لمسئول المبيعات
        });
        Schema::dropIfExists('quotes'); // حذف جدول العروض عند التراجع عن التهجير
    }
};
