<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('journal_entries');
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي
            $table->string('reference_number')->nullable(); // رقم مرجعي للقيد
            $table->date('date'); // تاريخ القيد
            $table->text('description')->nullable(); // وصف القيد
            $table->tinyInteger('status')->default(0)->comment('0=>pending, 1=>approved, 2=>rejected'); // حالة القيد
            $table->string('currency')->nullable(); // العملة
            $table->string('attachment')->nullable(); // مرفق
            $table->unsignedBigInteger('salary_id')->nullable();
            // المفاتيح الخارجية
            $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null'); // معرف العميل
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null'); // معرف الموظف
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->onDelete('set null'); // معرف الفاتورة
            $table->foreignId('cost_center_id')->nullable()->constrained('cost_centers')->onDelete('cascade'); // مركز التكلفة
            $table->foreignId('created_by_employee')->nullable()->constrained('employees')->onDelete('set null'); // منشئ القيد
            $table->foreignId('approved_by_employee')->nullable()->constrained('employees')->onDelete('set null'); // معتمد القيد

            $table->timestamps(); // وقت الإنشاء والتحديث
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('journal_entries');
        Schema::enableForeignKeyConstraints();
    }
};
