<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

public function up()
{
    Schema::create('invoice_items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('cascade');
        $table->foreignId('quotation_id')->nullable()->constrained('quotes')->onDelete('cascade');
        $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade');
        $table->foreignId('store_house_id')->nullable()->constrained('store_houses')->onDelete('cascade');
        $table->foreignId('quote_id')->nullable()->constrained('quotes')->onDelete('cascade');
        $table->foreignId('credit_note_id')->nullable()->constrained('credit_notifications')->onDelete('cascade');
        $table->foreignId('periodic_invoice_id')->nullable()->constrained('periodic_invoices')->onDelete('cascade');
        $table->integer('quotes_purchase_order_id')->nullable();
        // تأكد من أن الجدول purchase_invoices موجود قبل إنشاء هذا المفتاح الخارجي
        $table->foreignId('purchase_invoice_id')->nullable()->constrained('purchase_invoices')->onDelete('cascade');
        $table->tinyInteger('purchase_invoice_id_type')->nullable()->default(1)->comment('1: Purchase Order, 2: Purchase Invoice, 3: Purchase Return, 4: Credit Note');
        $table->string('item');
        $table->text('description')->nullable();
        $table->decimal('unit_price', 10, 2)->nullable();
        $table->integer('quantity')->nullable();
        $table->decimal('discount', 10, 2)->nullable();
        $table->tinyInteger('discount_type')->default(1)->comment('1=>percentage 2=>currency');
        $table->decimal('tax_1', 5, 2)->nullable();
        $table->decimal('tax_2', 5, 2)->nullable();
        $table->decimal('total', 10, 2)->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_items');
    }
}
