<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255); // الاسم
            $table->text('description')->nullable(); // الوصف
            $table->integer('sub_unit_id')->nullable(); // قالب الوحدة
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->nullable();
            $table->string('serial_number')->nullable(); // الرقم التسلسلي
            $table->string('brand', 100)->nullable(); // الماركة
            $table->integer('supplier_id')->nullable(); // المورد
            $table->integer('low_stock_thershold')->default(0);
            $table->string('barcode', 255)->nullable();
            $table->string('sales_cost_account', 255)->nullable();
            $table->string('sales_account', 255)->nullable(); // الباركود
            $table->tinyInteger('available_online')->default(0); // متاح أون لاين
            $table->tinyInteger('featured_product')->nullable(); // منتج مميز
            $table->tinyInteger('track_inventory')->nullable(); // تتبع المخزون
            $table->string('inventory_type')->nullable(); // نوع التتبع
            $table->tinyInteger('low_stock_alert')->nullable()->comment('(1=>الكميه) (2=>رقم الشخنه) (3=>تاريخ الانتهاء) (4_رقم الشحنه و تاريخ الانتهاء)'); // تنبيه عند انخفاض الكمية
            $table->text('Internal_notes')->nullable(); // ملاحظات
            $table->string('tags', 255)->nullable(); // الوسوم
            $table->string('images', 255)->nullable();
            $table->tinyInteger('status')->default(1)->comment('(1=>active) (2=>stopped) (3=>not active)'); // الحالة
            $table->decimal('purchase_price', 10, 2)->nullable(); // سعر الشراء
            $table->decimal('sale_price', 10, 2)->nullable(); // سعر البيع
            $table->integer('purchase_unit_id')->nullable();
            $table->integer('sales_unit_id')->nullable();
            $table->tinyInteger('tax1')->nullable(); // الضريبة الأولى
            $table->tinyInteger('tax2')->nullable(); // الضريبة الثانية
            $table->decimal('min_sale_price', 10, 2)->nullable(); // أقل سعر بيع
            $table->decimal('discount', 10, 2)->nullable(); // الخصم
            $table->tinyInteger('discount_type')->nullable()->comment('(1_percentage) (2_currency)'); // نوع الخصم   
            $table->enum('type', ['products', 'services'])->default('products'); // النوع
            $table->decimal('profit_margin', 10, 2)->nullable(); // هامش الربح
            $table->bigInteger('created_by'); // نوع هامش الربح
            $table->timestamps(); // created_at و updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
