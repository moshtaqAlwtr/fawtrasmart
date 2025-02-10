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
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // الاسم
            $table->text('description')->nullable(); // الوصف
            $table->string('color', 7); // اللون (كود HEX)
            $table->integer('max_days_per_year'); // الحد الأقصى للأيام خلال العام
            $table->integer('max_consecutive_days')->nullable(); // الحد الأقصى للأيام المتتالية
            $table->integer('applicable_after')->nullable(); // قابلة للتطبيق بعد (عدد الأيام)
            $table->boolean('replace_weekends')->default(false); // استبدال عطلة نهاية الأسبوع
            $table->boolean('requires_approval')->default(false); // يحتاج إذن
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
