<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeasonalPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seasonal_prices', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم
            $table->unsignedBigInteger('unit_type_id'); // نوع الوحدة
            $table->date('date_from'); // التاريخ من
            $table->date('date_to'); // التاريخ إلى
            $table->unsignedBigInteger('pricing_rule_id'); // قاعدة التسعير
            $table->json('working_days')->nullable(); // أيام العمل (JSON لتخزين الأيام وحالاتها)
            $table->timestamps(); // الطوابع الزمنية
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasonal_prices');
    }
}

