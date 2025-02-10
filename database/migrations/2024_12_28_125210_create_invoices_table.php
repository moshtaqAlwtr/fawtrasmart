<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null'); // العميل
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null'); // العميل

            $table->foreignId('treasury_id')->nullable()->constrained('treasuries')->onDelete('set null'); // الخزينة
            $table->tinyInteger('payment')->nullable()->default(1)->comment('1: print, 2: send to client'); // طريقة الدفع
            $table->date('invoice_date')->nullable(); // تاريخ الفاتورة
            $table->date('issue_date')->nullable(); // تاريخ الإصدار
            $table->string('payment_terms', 100)->nullable(); // شروط الدفع
            $table->tinyInteger('payment_status')->nullable()->default(1)->comment('1: Unpaid, 2: Partially Paid, 3: Fully Paid'); // حالة الدفع
            $table->string('currency', 10)->nullable()->default('SAR'); // العملة
            $table->decimal('due_value', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable(); // المجموع الكلي
            $table->decimal('grand_total', 10, 2)->nullable(); // المجموع الكلي مع الضرائب
            $table->decimal('advance_payment', 10, 2)->nullable()->default(0); // الدفعة المقدمة
            $table->decimal('remaining_amount', 10, 2)->nullable(); // المبلغ المتبقي
            $table->boolean('is_paid')->nullable()->default(false); // هل الفاتورة مدفوعة؟
            $table->tinyInteger('payment_method')->nullable()->default(1)->comment('1: Cash, 2: Bank Transfer, 3: Credit Card, 4: Check, 5: Other'); // وسيلة الدفع
            $table->string('reference_number')->nullable(); // رقم المعرف
            $table->text('notes')->nullable(); // الملاحظات
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0); // قيمة الخصم
            $table->string('discount_type', 20)->nullable(); // نوع الخصم
            $table->decimal('shipping_cost', 10, 2)->nullable()->default(0); // تكلفة الشحن
            $table->decimal('shipping_tax', 10, 2)->nullable()->default(0); // ضريبة الشحن (الحقل الجديد)
            $table->string('tax_type', 50)->nullable(); // نوع الضريبة
            $table->decimal('tax_total', 10, 2)->nullable(); // مجموع الضريبة
            $table->string('attachments')->nullable(); // المرفقات
            $table->string('type', 50)->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users'); // المستخدم الذي أنشأ الفاتورة
            $table->foreignId('updated_by')->nullable()->constrained('users'); // المستخدم الذي قام بالتحديث
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('invoices');
        Schema::enableForeignKeyConstraints();
    }
};
