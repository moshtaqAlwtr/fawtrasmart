<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id(); // معرف فريد للتحويل
            $table->unsignedBigInteger('from_treasury_id')->nullable(); // معرف الخزينة المصدر
            $table->unsignedBigInteger('to_treasury_id')->nullable(); // معرف الخزينة الهدف
            $table->decimal('amount', 15, 2)->nullable(); // المبلغ المحول
            $table->date('transfer_date')->nullable(); // تاريخ التحويل
            $table->text('notes')->nullable()->nullable(); // الملاحظات (اختياري)
            $table->string('attachments')->nullable(); // المرفقات (اختياري)
            $table->unsignedBigInteger('created_by')->nullable(); // المستخدم الذي أنشأ التحويل

            $table->timestamps(); // تاريخ الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfers'); // حذف الجدول عند التراجع عن الميجرشن
    }
}
