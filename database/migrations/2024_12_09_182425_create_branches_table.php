<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم الفرع
            $table->string('code')->unique(); // كود الفرع
            $table->string('phone'); // الهاتف
            $table->tinyInteger('status')->comment('0 = active , 1 = inactive ')->default(0);
            $table->string('mobile'); // الجوال
            $table->string('address1'); // العنوان 1
            $table->string('address2')->nullable(); // العنوان 2 (اختياري)
            $table->string('city'); // المدينة
            $table->string('region')->nullable(); // المنطقة (اختياري)
            $table->string('country'); // البلد
            $table->text('work_hours')->nullable(); // ساعات العمل (اختياري)
            $table->text('description')->nullable(); // الوصف (اختياري)
            $table->string('location')->nullable(); // الموقع (اختياري، يمكن تخزين رابط الموقع أو إحداثيات الموقع)
            $table->timestamps(); // لتخزين تاريخ الإنشاء والتعديل
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}
