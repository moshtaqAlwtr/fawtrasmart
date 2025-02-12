<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplyOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('supply_orders', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name')->nullable(); // مسمى
            $table->string('order_number')->unique()->nullable();
            $table->date('start_date')->nullable(); // تاريخ البدء
            $table->date('end_date')->nullable(); // تاريخ النهاية
            $table->text('description')->nullable(); // الوصف

            // Client and Employee
            $table->unsignedBigInteger('client_id')->nullable(); // العميل
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('set null');

            $table->unsignedBigInteger('employee_id')->nullable(); // الموظف
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');

            // Shipping and Product Details
            $table->text('product_details')->nullable(); // بيانات المنتجات
            $table->text('shipping_address')->nullable(); // عنوان الشحن
            $table->string('tracking_number')->nullable(); // رقم التتبع
            $table->string('shipping_policy_file')->nullable(); // بوليصة الشحن

            // Financial Information
            $table->string('tag')->nullable(); // الوسم
            $table->decimal('budget', 15, 2)->nullable(); // الميزانية
            $table->tinyInteger('currency')->default(1)->nullable()->comment('1: SAR, 2: USD, 3: EUR, 4: GBP, 5: CNY'); // العملة

            // Custom Fields
            $table->json('custom_fields')->nullable(); // إعدادات الحقول المخصصة
            $table->string('attachment')->nullable();
            $table->boolean('show_employee')->default(false);
            // Status and Tracking
            $table->tinyInteger('status')->default('1')->nullable()->comment('1: Pending, 2: In Progress, 3: Completed, 4: Cancelled');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supply_orders');
    }
}
