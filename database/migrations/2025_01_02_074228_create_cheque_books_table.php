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
        Schema::create('cheque_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bank_id');
            $table->integer('cheque_book_number')->unique();
            $table->string('currency', 3); // ISO currency code (e.g., SAR)
            $table->integer('start_serial_number');
            $table->integer('end_serial_number');
            $table->tinyInteger('status')->default(0);
            $table->text('notes')->nullable();

            $table->foreign('bank_id')->references('id')->on('treasuries')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque_books');
    }
};
