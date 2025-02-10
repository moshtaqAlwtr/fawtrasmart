<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryTemplateTable extends Migration
{
    public function up()
    {
        Schema::create('salary_template', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(1)->nullable()->comment('(1=>active)  (2=>not active)');
            $table->tinyInteger('receiving_cycle')->default(1)->nullable()->comment('1=>monthly, 2=>weekly, 3=>yearly , 4=>Quarterly,5=>Once a week');
            $table->decimal('amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('salary_template');
    }
}
