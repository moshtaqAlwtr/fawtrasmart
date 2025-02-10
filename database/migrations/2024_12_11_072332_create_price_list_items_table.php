<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * تشغيل الترحيل.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_lists', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->string('name'); // اسم قائمة الأسعار
            $table->tinyInteger('status')->default(0)->comment(' (فعال 0/غير فعال1)'); // حالة قائمة الأسعار (فعال/غير فعال)
            $table->timestamps(); // created_at و updated_at
        });
    }

    /**
     * التراجع عن الترحيل.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_lists');
    }
};
