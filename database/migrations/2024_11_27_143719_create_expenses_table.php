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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('code')->unique()->nullable(); // رقم الكود
            $table->decimal('amount', 10, 2); // المبلغ
            // $table->string('currency', 10)->default('SAR'); // العملة
            $table->text('description')->nullable(); // الوصف
            $table->date('date'); // التاريخ
            $table->integer('unit_id')->nullable(); // الوحدة
            $table->integer('expenses_category_id')->nullable(); // التصنيف
            $table->integer('vendor_id')->nullable(); // المورد
            $table->string('seller')->nullable(); // البائع
            $table->integer('store_id')->nullable(); // الخزينة
            $table->string('sup_account')->nullable(); // الحساب الفرعي
            $table->tinyInteger('is_recurring')->default(0); // متكرر
            $table->string('recurring_frequency')->nullable(); // التكرار (مثلاً Weekly, Monthly)
            $table->date('end_date')->nullable(); // تاريخ الانتهاء
            $table->tinyInteger('tax1')->nullable(); // الضرائب
            $table->tinyInteger('tax2')->nullable(); // الضرائب
            $table->decimal('tax1_amount', 10, 2); // المبلغ
            $table->decimal('tax2_amount', 10, 2); // المبلغ
            $table->string('attachments')->nullable(); // المرفقات (file path)
            $table->tinyInteger('cost_centers_enabled')->default(0); // تعيين مراكز التكلفة
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
