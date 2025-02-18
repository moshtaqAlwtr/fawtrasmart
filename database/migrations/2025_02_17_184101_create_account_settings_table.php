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
        Schema::create('account_settings', function (Blueprint $table) {
            $table->id();
            $table->string('currency')->nullable(); // العملة       
            $table->string('negative_currency_formats')->nullable();  // تنسيقات العملات السالبة 
            $table->string('time_formula')->nullable(); //صيغة الوقت 
            $table->string('timezone')->nullable(); // المنطقة الزمنية
            $table->enum('business_type', ['products', 'services', 'both'])->default('products'); // النوع
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_settings');
    }
};
