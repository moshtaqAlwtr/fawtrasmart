<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('purchase_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable()->unique();

            // نوع المستند - 1: أمر شراء، 2: فاتورة شراء، 3: مرتجع شراء
            $table->tinyInteger('type')->default(1)->comment('1: Purchase Order, 2: Purchase Invoice, 3: Purchase Return, 4: Credit Note');
            // المرجع - في حالة المرتجع أو الفاتورة يمكن ربطها بأمر الشراء
            $table->foreignId('reference_id')->nullable()->constrained('purchase_invoices')->onDelete('restrict')->comment('Reference to original purchase order/invoice');
            $table->tinyInteger('Receiving status')->nullable()->default(0)->comment('0: Not Received, 1: Partially Received, 2: Received');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('restrict');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('restrict');
            $table->date('date')->nullable();
            $table->integer('terms')->nullable();


            // الحالة حسب نوع المستند
            $table->tinyInteger('status')->nullable()->default(1)->comment('
                Purchase Order: 1:Draft, 2:Pending, 3:Approved, 4:Converted to Invoice, 5:Cancelled
                Purchase Invoice: 1:Draft, 2:Pending, 3:Approved, 4:Paid, 5:Partially Paid, 6:Cancelled
                Purchase Return: 1:Draft, 2:Pending, 3:Approved, 4:Completed, 5:Cancelled
            ');

            // قسم الخصم والتسوية
            $table->decimal('discount_amount', 10, 2)->nullable()->default(0);
            $table->string('discount_percentage')->nullable();
            $table->tinyInteger('discount_type')->nullable()->default(1);

            // قسم الدفعة المقدمة
            $table->decimal('advance_payment', 10, 2)->nullable()->default(0);
            $table->tinyInteger('advance_payment_type')->nullable()->default(1);
            $table->boolean('is_paid')->nullable()->default(false);
            $table->tinyInteger('payment_method')->nullable()->default(1);
            $table->string('reference_number')->nullable();

            // قسم الشحن والضرائب
            $table->tinyInteger('tax_type')->nullable()->default(1);
            $table->decimal('shipping_cost', 10, 2)->nullable()->default(0);

            // قسم المجاميع
            $table->decimal('subtotal', 15, 2)->nullable()->default(0);
            $table->decimal('total_discount', 15, 2)->nullable()->default(0);
            $table->decimal('total_tax', 15, 2)->nullable()->default(0);
            $table->decimal('grand_total', 15, 2)->nullable()->default(0);

            // قسم الملاحظات والاستلام
            $table->text('notes')->nullable();
            $table->boolean('is_received')->nullable()->default(false);
            $table->date('received_date')->nullable();
            $table->string('attachments')->nullable();
            // معلومات التتبع
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_invoices');
    }
};
