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
        Schema::create('received_cheques', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2); // المبلغ
            $table->date('issue_date'); // تاريخ الإصدار
            $table->date('due_date')->nullable(); // تاريخ الاستحقاق
            $table->string('cheque_number')->unique(); // رقم الشيك
            $table->unsignedBigInteger('recipient_account_id'); // الحساب المستلم
            $table->unsignedBigInteger('collection_account_id'); // الحساب التحصيل
            $table->string('payee_name'); // الاسم على الشيك
            $table->tinyInteger('endorsement')->default(0)->comment('تظهير');
            $table->string('name')->nullable()->comment('الاسم على ظهر الشيك'); // الاسم على ظهر الشيك
            $table->text('description')->nullable(); // الوصف
            $table->string('attachment')->nullable(); // المرفقات
            $table->timestamps();

            // إنشاء العلاقات
            // $table->foreign('recipient_account_id')->references('id')->on('accounts')->onDelete('cascade');
            // $table->foreign('recipient_account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_cheques');
    }
};
