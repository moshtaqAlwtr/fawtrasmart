<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id(); // رقم الحساب البنكي
            $table->string('bank_name'); // اسم البنك
            $table->string('account_number'); // رقم الحساب البنكي
            $table->string('branch_name')->nullable(); // اسم الفرع
            $table->string('account_holder_name'); // اسم صاحب الحساب
            $table->enum('account_status', ['active', 'inactive'])->default('active'); // الحالة
            $table->string('currency', 10); // العملة
            $table->text('description')->nullable(); // وصف الحساب
            $table->enum('permissions', ['withdraw', 'deposit', 'both'])->default('both'); // الصلاحيات
            $table->decimal('balance', 15, 2)->default(0); // الرصيد الحالي
            $table->unsignedBigInteger('account_id')->nullable(); // الحساب المرتبط
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('chart_of_accounts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
