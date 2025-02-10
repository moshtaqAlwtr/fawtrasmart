<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricingRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pricing_rules', function (Blueprint $table) {
            $table->id();
            $table->string('pricingName'); // اسم قاعدة التسعير
            $table->tinyInteger('status',)->default('1')->comment('1 = active , 2 = inactive')->nullable(); // الحالة
            $table->string('currency')->default('SAR'); // العملة
            $table->integer('pricingMethod'); // طريقة التسعير كعدد صحيح (integer)
            $table->decimal('dailyPrice', 10, 2); // سعر اليوم
            $table->timestamps(); // timestamps لتخزين created_at و updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pricing_rules');
    }
}
