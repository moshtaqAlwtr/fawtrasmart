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
        Schema::create('business_data', function (Blueprint $table) {
            $table->id();
            $table->string('business_name')->nullable();  // الاسم التجاري
            $table->string('first_name')->nullable();      // الاسم الأول
            $table->string('last_name')->nullable();      // الاسم الأخير
            $table->string('mobile', 20)->nullable();      // الجوال
            $table->string('phone', 20)->nullable();  // الهاتف (اختياري)
            $table->string('street_address_1')->nullable(); ;  // عنوان الشارع الأول
            $table->string('street_address_2')->nullable();  // عنوان الشارع 2 (اختياري)
            $table->string('city')->nullable(); ;           // المدينة
            $table->string('postal_code', 10)->nullable(); ; // الرمز البريدي
            $table->string('country')->nullable();        // البلد
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_data');
    }
};







