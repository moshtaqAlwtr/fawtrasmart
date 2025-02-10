<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('purchase_quotation_supplier', function (Blueprint $table) {
            $table->id();

            // العلاقات
            $table->foreignId('purchase_quotation_id')->constrained('purchase_quotations')->onDelete('cascade');

            $table->foreignId('supplier_id')->constrained('suppliers')->onDelete('cascade');

            // معلومات النظام
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // تحديد اسم مخصص وقصير للـ unique index
            $table->unique(['purchase_quotation_id', 'supplier_id'], 'quote_supplier_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_quotation_supplier');
    }
};
