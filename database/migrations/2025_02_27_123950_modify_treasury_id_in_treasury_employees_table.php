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
            $table->dropIndex('treasury_employees_treasury_id_foreign'); // حذف المؤشر المرتبط بـ treasury_id

            // تغيير نوع العمود treasury_id ليصبح من نوع integer
            $table->integer('treasury_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treasury_employees', function (Blueprint $table) {
            $table->foreignId('treasury_id')->constrained('quotes')->onDelete('cascade')->change();
        });
    }
};
