<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * تشغيل الهجرة.
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الوحدة
            $table->unsignedBigInteger('unit_type_id'); // ربط بنوع الوحدة
            $table->integer('priority')->nullable(); // درجة الأولوية
            $table->enum('status', ['active', 'inactive'])->default('active'); // الحالة
            $table->text('description')->nullable(); // الوصف
            $table->timestamps();

            // إنشاء العلاقة
            $table->foreign('unit_type_id')->references('id')->on('unit_types')->onDelete('cascade');
        });
    }

    /**
     * التراجع عن الهجرة.
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
