<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('client_relations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable(); // إضافة حقل الموظف
            $table->string('status')->nullable();
            $table->string('process')->nullable();
            $table->time('time')->nullable();
            $table->date('date')->nullable();
            $table->text('description')->nullable();

            // الحقول الجديدة التي طلبتها
            $table->integer('deposit_count')->nullable()->comment('عدد العهدة الموجودة');
            $table->enum('site_type', [
                'independent_booth',
                'grocery',
                'supplies',
                'markets',
                'station'
            ])->nullable()->comment('نوع الموقع');
            $table->integer('competitor_documents')->nullable()->comment('عدد استندات المنافسين');

            // حقول المرفقات والبيانات الإضافية
            $table->json('attachments')->nullable()->comment('المرفقات');
            $table->json('additional_data')->nullable()->comment('بيانات إضافية');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_relations');
    }
};
