<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_options', function (Blueprint $table) {
            $table->id(); // معرف الخيار (Primary Key)
            $table->string('name'); // اسم خيار الشحن
            $table->tinyInteger('status')->nullable()->default(1); // الحالة (0: نشط، 1: غير نشط)
            $table->tinyInteger('tax')->nullable()->default(1)->comment('الضرائب (1: القيمة المضافة، 2: القيمة الصفرية)'); // الضرائب (1: القيمة المضافة، 2: القيمة الصفرية)
            $table->decimal('cost', 10, 2)->nullable(); // الرسوم (قيمة عشرية)
            $table->integer('display_order')->nullable(); // ترتيب العرض
            $table->unsignedBigInteger('default_account_id')->nullable(); // الحساب الافتراضي (مرتبط بجدول الحسابات)
            $table->string('description')->nullable(); // الوصف
            $table->timestamps(); // الحقول الزمنية (created_at و updated_at)

            // Foreign Key للحساب الافتراضي
            $table->foreign('default_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('set null'); // في حالة حذف الحساب، يتم تعيين الحقل إلى null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_options');
    }
}
