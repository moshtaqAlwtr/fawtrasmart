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
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->integer('sub_account')->nullable(); // حساب الفرع
            $table->integer('storehouse_id')->nullable(); // المستودع الافتراضي
            $table->integer('price_list_id')->nullable(); // قائمة الأسعار الافتراضية
            $table->tinyInteger('enable_negative_stock')->default(0); // إتاحة المخزون السالب
            $table->tinyInteger('advanced_pricing_options')->default(0); // خيارات التسعير المتقدمة
            $table->tinyInteger('enable_stock_requests')->default(0); // تفعيل الطلبات المخزنية
            $table->tinyInteger('enable_sales_stock_authorization')->default(0); // الأذون المخزنية لفواتير المبيعات
            $table->tinyInteger('enable_purchase_stock_authorization')->default(0); // الأذون المخزنية لفواتير الشراء
            $table->tinyInteger('track_products_by_serial_or_batch')->default(0); // تتبع المنتجات بالرقم المسلسل أو رقم الشحنة
            $table->tinyInteger('allow_negative_tracking_elements')->default(0); // السماح بعناصر التتبع السالبة
            $table->tinyInteger('enable_multi_units_system')->default(0); // إضافة نظام الوحدات المتعددة
            $table->tinyInteger('inventory_quantity_by_date')->default(0); // حساب كمية الجرد حسب تاريخ الجرد
            $table->tinyInteger('enable_assembly_and_compound_units')->default(0); // إضافة نظام التجميعات والوحدات المركبة
            $table->tinyInteger('show_available_quantity_in_warehouse')->default(0); // إظهار الكمية الإجمالية والمتوفرة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_settings');
    }
};
