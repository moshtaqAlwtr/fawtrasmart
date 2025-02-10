<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->comment('اسم العرض');
            $table->date('valid_from')->nullable()->comment('تاريخ بداية العرض');
            $table->date('valid_to')->nullable()->comment('تاريخ نهاية العرض');
            $table->tinyInteger('type')->nullable()->default(1)->comment('نوع العرض: 1 = خصم على الكمية, 2 = خصم على التصنيف');
            $table->decimal('quantity', 10, 2)->nullable()->comment('الكمية المطلوبة لتطبيق العرض');
            $table->tinyInteger('discount_type')->nullable()->default(1)->comment('نوع الخصم: 1 = خصم حقيقي, 2 = خصم نسبي');
            $table->decimal('discount_value', 10, 2)->nullable()->comment('قيمة الخصم');
            $table->string('category')->nullable()->comment('التصنيف');
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null')->comment('العميل المرتبط بالعرض');
            $table->boolean('is_active')->default(true)->comment('حالة العرض: 1 = نشط, 0 = غير نشط');
            $table->tinyInteger('unit_type')->nullable()->default(1)->comment('نوع الوحدة: 1 = منتج, 2 = تصنيف');
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('cascade')->comment('المنتج المرتبط بالعرض');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade')->comment('التصنيف المرتبط بالعرض');
            $table->tinyInteger('status')->default(1)->nullable()->comment('1=active , 2=not active');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offers');
    }
};
