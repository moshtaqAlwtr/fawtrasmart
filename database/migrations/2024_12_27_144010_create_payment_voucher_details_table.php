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
        if (!Schema::hasTable('payment_voucher_details')) {
            Schema::create('payment_voucher_details', function (Blueprint $table) {
                $table->id(); // المفتاح الأساسي
                $table->unsignedBigInteger('payment_id')->nullable(); // المفتاح الخارجي
                $table->string('unit', 100)->nullable(); // الوحدة
                $table->decimal('amount', 15, 2); // المبلغ
                $table->string('category', 255)->nullable(); // التصنيف
                $table->text('description')->nullable(); // الوصف
                $table->timestamps(); // وقت الإنشاء والتحديث

                // تعريف العلاقة
                $table->foreign('payment_id')->references('payment_id')->on('payment_vouchers')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_voucher_details');
    }
};
