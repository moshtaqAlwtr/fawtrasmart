<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('taxs_invoice', function (Blueprint $table) {
            $table->id();
    $table->string('name'); // اسم الضريبة
    $table->unsignedBigInteger('invoice_id'); // معرف الفاتورة (يفضل استخدام unsignedBigInteger)
  $table->decimal('rate', 5, 2); // نسبة الضريبة (مثال: 15.00)
   $table->string('type')->default('included'); // نوع الضريبة (متضمنة أو غير متضمنة)
   $table->decimal('value', 10, 2)->nullable()->default(0); // قيمة الضريبة (قابلة للقيمة الفارغة وقيمة افتراضية 0)
            $table->timestamps();
        });
        
         $table->string('type_invoice')->nullable(); 
          $table->unsignedBigInteger('product_id')->nullable();
    
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('taxs_invoice');
    }
};
