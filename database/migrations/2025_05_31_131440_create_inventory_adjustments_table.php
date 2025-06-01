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
        Schema::create('inventory_adjustments', function (Blueprint $table) {
            $table->id();
            
    // معرف الصنف
    $table->unsignedBigInteger('stock_id');
    
    // تاريخ ووقت الجرد
    $table->timestamp('inventory_time');

   
    // ملاحظات إضافية
    $table->text('note')->nullable();

    // حالة الجرد: إما "مسودة" أو "تمت التسوية"
    $table->enum('status', ['draft', 'adjusted'])->default('draft');

    // نوع الحساب: "حسب تاريخ الجرد" أو "غير مرتبط بتاريخ"
    $table->enum('calculation_type', ['dated', 'undated'])->default('dated');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};
