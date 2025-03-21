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
        Schema::table('treasury_employees', function (Blueprint $table) {
            // حذف المفتاح الأجنبي أولًا
            $table->dropForeign(['treasury_id']);

            // تغيير نوع العمود treasury_id إلى integer
            $table->integer('treasury_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treasury_employees', function (Blueprint $table) {
            // إعادة العمود treasury_id إلى foreignId وربطه بجدول quotes
            $table->foreignId('treasury_id')->constrained('quotes')->onDelete('cascade')->change();
        });
    }
};
