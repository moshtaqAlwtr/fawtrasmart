<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // المسمى
            $table->string('code')->unique(); // الكود
            $table->date('order_date'); // تاريخ الطلب
            $table->date('due_date')->nullable(); // تاريخ الاستحقاق
            $table->text('notes')->nullable(); // الملاحظات
            $table->string('attachments')->nullable(); // المرفقات
            $table->tinyInteger('status')->default(1)->comment('1=>pending, 2=>completed, 3=>ignored , 4=>rescheduled ');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
