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
        Schema::create('compiled_products', function (Blueprint $table) {
            $table->id();
              // حقل معرف التجميع (compile_id)
              $table->integer('compile_id');
            
              // حقل معرف المنتج (product_id) الذي يربط المنتج بالتجميع
              $table->unsignedBigInteger('product_id');
              
              // حقل معرف الأب (parent_id) للمنتجات المجمعّة
              $table->unsignedBigInteger('parent_id')->nullable();
              
              // حقل الكمية (qyt) الخاصة بالمنتج المجمع
              $table->integer('qyt')->nullable();
              
              // حقل معرف المخزن (storehouse_id)
              $table->unsignedBigInteger('storehouse_id')->nullable();
              
             
              
              // إضافة تاريخ الإنشاء والتحديث
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compiled_products');
    }
};
