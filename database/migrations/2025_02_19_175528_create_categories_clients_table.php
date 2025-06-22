<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_clients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique(); // اسم التصنيف
            $table->text('description')->nullable(); // وصف التصنيف (اختياري)
            $table->boolean('active')->default(true); // حالة التصنيف (نشط/غير نشط)
            $table->timestamps(); // created_at و updated_at

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories_clients');
    }
}
