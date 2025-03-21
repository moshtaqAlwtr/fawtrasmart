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
        Schema::create('taxes', function (Blueprint $table) {
            $table->id(); // رقم الضريبة
            $table->string('name'); // اسم الضريبة
            $table->decimal('rate', 5, 2); // نسبة الضريبة
            $table->text('description')->nullable(); // وصف الضريبة
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
        Schema::dropIfExists('taxes');
    }
};
