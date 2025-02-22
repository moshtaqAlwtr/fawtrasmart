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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم طريقة الدفع
            $table->text('description')->nullable(); // وصف طريقة الدفع
            $table->string('status')->default('active'); // الحالة (مفعلة أو معطلة)
            $table->string('is_online')->default('inactive'); // هل تعمل أونلاين أم لا
            $table->string('type')->default('normal'); // نوع وسيلة الدفع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
