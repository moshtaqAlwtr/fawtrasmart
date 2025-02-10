
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_items', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم البند
            $table->tinyInteger('type')->default(1)->nullable()->comment('(1=>deduction) (2=>addition)'); // نوع البند (مستحق أو مستقطع)
            $table->tinyInteger('status')->default(1)->nullable()->comment('(1=>active)  (2=>not active)'); // الحالة (اختياري)
            $table->text('description')->nullable(); // الوصف (اختياري)
            $table->tinyInteger('salary_item_value')->default(1)->nullable()->comment('(1=>amount) (2=>calculation_formula)'); // نوع قيمة البند
            $table->decimal('amount', 10, 2)->nullable(); // المبلغ (اختياري)
            $table->string('calculation_formula')->nullable(); // الصيغة الحسابية (اختياري)
            $table->text('condition')->nullable(); // الشرط (اختياري)
            $table->unsignedBigInteger('account_id')->nullable(); // Ensure this matches the type of `id` in `accounts`
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade'); // ربط الحساب الافترا��ي

            $table->unsignedBigInteger('salary_template_id')->nullable();
            $table->unsignedBigInteger('salary_slips_id')->nullable();
            $table->unsignedBigInteger('contracts_id')->nullable();
            $table->boolean('reference_value')->default(false); // قيمة مرجعية فقط؟
            $table->timestamps(); // التاريخ والوقت
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_items');
    }
};
