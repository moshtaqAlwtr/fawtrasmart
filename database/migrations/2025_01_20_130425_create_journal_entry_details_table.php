<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('journal_entry_details', function (Blueprint $table) {
            // العمود الأساسي
            $table->id();

            // إنشاء العمود journal_entry_id
            $table->unsignedBigInteger('journal_entry_id')->nullable();

            // إنشاء العمود account_id
            $table->unsignedBigInteger('account_id')->nullable();

            // بقية الأعمدة
            $table->string('description')->nullable();
            $table->decimal('debit', 15, 2)->default(0);
            $table->decimal('credit', 15, 2)->default(0);
            $table->string('reference')->nullable(); // رقم مرجعي إضافي
            $table->string('currency')->default('SAR'); // العملة المستخدمة
            $table->boolean('is_debit')->default(true); // تحديد ما إذا كان البند مدينًا أو دائنًا
            $table->timestamps();

            // إنشاء المفاتيح الخارجية
            $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('cascade');

            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('journal_entry_details');
    }
};
