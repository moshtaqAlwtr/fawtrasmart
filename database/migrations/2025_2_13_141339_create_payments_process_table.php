<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('payments_process', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('cascade');
            $table->foreignId('purchases_id')->nullable()->constrained('purchase_invoices')->onDelete('cascade');
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('cascade');
            $table->foreignId('installments_id')->nullable()->constrained('installments')->onDelete('cascade');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('treasury_id')->nullable()->constrained('treasuries')->onDelete('set null');
            $table->foreignId('account_id')->nullable()->constrained('accounts')->onDelete('set null');
            $table->dateTime('payment_date')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('type');
            $table->tinyInteger('payment_status')->nullable()->default(1);
            $table->tinyInteger('Payment_method')->nullable()->default(1)->comment('1: cash, 2: check, 3: Pinky, 4:online, 5: others');
            $table->string('reference_number')->nullable();
            $table->string('payment_data')->nullable();
            $table->text('notes')->nullable();
            $table->text('attachments')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};
