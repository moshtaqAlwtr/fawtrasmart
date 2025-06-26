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
        Schema::create('gift_offers', function (Blueprint $table) {
            $table->id();
                    // اسم العرض (اختياري)
        $table->string('name')->nullable();

        // المنتج المستهدف
        $table->unsignedBigInteger('target_product_id')->nullable();
        $table->foreign('target_product_id')->references('id')->on('products')->onDelete('set null');
        
        // الكمية المطلوبة للحصول على الهدية
        $table->integer('min_quantity')->default(1);

        // المنتج الهدية
        $table->unsignedBigInteger('gift_product_id')->nullable();
        $table->foreign('gift_product_id')->references('id')->on('products')->onDelete('set null');

        // عدد الوحدات المجانية
        $table->integer('gift_quantity')->default(1);

        // التاريخ
        $table->date('start_date')->nullable();
        $table->date('end_date')->nullable();

        // تطبيق على كل العملاء أو عملاء محددين
        $table->boolean('is_for_all_clients')->default(true);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_offers');
    }
};
