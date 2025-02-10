<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitTypesTable extends Migration
{
    /**
     * تشغيل الترحيل.
     */
    public function up()
    {
        Schema::create('unit_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الوحدة
            $table->boolean('status'); // الحالة (نشط أو غير نشط)
            $table->foreignId('pricing_rule_id')->nullable()->constrained('pricing_rules')->nullOnDelete(); // قاعدة التسعير
            $table->time('check_in_time'); // وقت الحضور
            $table->time('check_out_time'); // وقت المغادرة
            $table->decimal('tax1', 5, 2)->nullable(); // الضريبة 1
            $table->decimal('tax2', 5, 2)->nullable(); // الضريبة 2
            $table->text('description')->nullable(); // الوصف
            $table->timestamps();
        });
    }

    /**
     * التراجع عن الترحيل.
     */
    public function down()
    {
        Schema::dropIfExists('unit_types');
    }
}
