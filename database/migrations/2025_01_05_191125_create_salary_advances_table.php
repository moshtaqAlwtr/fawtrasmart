<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_advances', function (Blueprint $table) {
            $table->id();
            // Employee relationship (موظف)
            $table->unsignedBigInteger('employee_id')->nullable();


            // Submission date (تاريخ التقديم)
            $table->date('submission_date');

            // Amount (المبلغ)
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('currency')->nullable()->default(1)->comment('1=SAR, 2=USD, 3=EUR, 4=GBP, 5=CNY');

            // Installment amount (مبلغ القسط)
            $table->decimal('installment_amount', 10, 2);

            // Installment number (عدد القسط)
            $table->integer('total_installments');

            // Payment rate (معدل السداد)
            $table->tinyInteger('payment_rate')->nullable()->default(1)->comment('1- Monthly, 2- Weekly, 3- Daily');
            $table->integer('paid_installments')->default(0);
            // Installment start date (تاريخ بدء الأقساط)
            $table->date('installment_start_date');

            // Treasury relationship (الخزنة)
            $table->unsignedBigInteger('treasury_id');
            $table->foreign('treasury_id')->references('id')->on('treasuries');

            // Pay from salary slip (الدفع من قسيمة الراتب)
            $table->boolean('pay_from_salary')->default(false);

            // Fees (رسوم)
            $table->string('tag')->nullable();

            // Note (ملاحظة)
            $table->text('note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_advances');
    }
};
