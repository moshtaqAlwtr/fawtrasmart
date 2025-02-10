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
        Schema::create('payable_cheques', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 15, 2); // المبلغ
            $table->date('issue_date'); // تاريخ الإصدار
            $table->date('due_date')->nullable(); // تاريخ الاستحقاق
            $table->unsignedBigInteger('bank_id'); // اسم البنك
            $table->unsignedBigInteger('cheque_book_id'); // رقم دفتر الشيكات
            $table->string('cheque_number')->unique(); // رقم الشيك
            $table->unsignedBigInteger('recipient_account_id'); // الحساب المستلم
            $table->string('payee_name'); // الاسم على الشيك
            $table->text('description')->nullable(); // الوصف
            $table->string('attachment')->nullable(); // المرفقات
            $table->timestamps();

            // إنشاء العلاقات
            $table->foreign('bank_id')->references('id')->on('treasuries')->onDelete('cascade');
            $table->foreign('cheque_book_id')->references('id')->on('cheque_books')->onDelete('cascade');
            // $table->foreign('recipient_account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payable_cheques');
    }
};
