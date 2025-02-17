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
        Schema::create('loyalty_sittings', function (Blueprint $table) {
            $table->id(); // مفتاح أساسي يتزايد تلقائياً
            $table->decimal('minimum_import_points', 10, 2)->nullable(); // الحد الأدنى من نقاط الاستيراد، يسمح بالقيم الكسرية
            $table->foreignId('client_credit_type_id')->constrained('balance_types')->onDelete('cascade')->nullable(); // معرف نوع رصيد العميل، يربط بجدول 'balance_types'
            $table->decimal('client_loyalty_conversion_factor', 10, 2)->nullable(); // معامل تحويل نقاط الولاء، يسمح بالقيم الكسرية
            $table->boolean('allow_decimal')->default(false)->nullable(); // السماح بالأرقام العشرية، القيمة الافتراضية هي false
            $table->timestamps(); // الطوابع الزمنية، تخزن توقيت الإنشاء والتحديث تلقائياً
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_sittings'); // حذف جدول 'loyalty_sittings' إذا كان موجوداً
    }
};
