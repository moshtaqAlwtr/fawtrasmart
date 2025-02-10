<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // جدول الفواتير الدورية
        Schema::create('periodic_invoices', function (Blueprint $table) {
            $table->id(); // معرف الفاتورة الدورية
            $table->string('invoice_number')->unique(); // رقم الفاتورة
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade'); // عند حذف العميل، تحذف الفاتورة الدورية تلقائيًا
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null'); // مسئول المبيعات
            $table->string('details_subscription'); // تاريخ الإصدار
            $table->date('first_invoice_date'); // تاريخ أول فاتورة
            $table->integer('repeat_count'); // عدد التكرارات
            $table
                ->tinyInteger('repeat_type')
                ->default(1) // نوع التكرار
                ->comment('1=>weekly, 2=>bi-weekly, 3=>monthly, 4=>bi-monthly, 5=>yearly, 6=>annual');
            $table->integer('repeat_interval')->default(1); // التكرار كل كم فترة
            $table->integer('invoice_days_offset')->default(0); // إصدار الفاتورة قبل عدد معين من الأيام
            $table->decimal('total', 10, 2); // إجمالي قيمة الفاتورة
            $table->decimal('grand_total', 10, 2)->default(0); // الإجمالي النهائي
            $table->decimal('subtotal', 10, 2)->nullable(); // المجموع الفرعي
            $table->tinyInteger('status')->nullable()->default(1)->comment('1:Draft, 2:Pending, 3:Approved, 4:Converted to Invoice, 5:Cancelled');
            $table->decimal('total_discount', 10, 2)->nullable(); // مجموع الخصومات
            $table->decimal('total_tax', 10, 2)->nullable(); // مجموع الضرائب
            $table->decimal('shipping_cost', 10, 2)->nullable(); // تكلفة الشحن

            $table->text('notes')->nullable(); // الملاحظات/الشروط
            $table->string('discount_type')->nullable(); // نوع الخصم (مبلغ أو نسبة)
            $table->decimal('discount_amount', 10, 2)->nullable(); // قيمة الخصم
            $table->string('tax_type')->nullable(); // نوع الضريبة (القيمة المضافة، صفرية، معفاة)

            $table->boolean('is_active')->default(true); // حالة الفاتورة
            $table->boolean('auto_generate')->default(false); // إنشاء تلقائي للفواتير
            $table->boolean('show_from_to_dates')->default(false); // إظهار تواريخ من-إلى
            $table->boolean('disable_partial_payment')->default(false); // منع الدفع الجزئي
            $table->string('payment_terms')->nullable(); // شروط الدفع
            $table->timestamps(); // تاريخ الإنشاء والتحديث
            // حذف ناعم
        });
    }

    public function down()
    {
        Schema::dropIfExists('periodic_invoices');
    }
};
