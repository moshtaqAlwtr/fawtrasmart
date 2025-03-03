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
        Schema::table('products', function (Blueprint $table) {
           // إضافة حقل storehouse_id للمخزن
           $table->unsignedBigInteger('storehouse_id')->nullable()->after('id')
           ->comment('معرف المخزن الذي يتم تخزين المنتج فيه');
     
     // إضافة حقل compile_type لنوع التجميع (فوري أو معد مسبقا)
     $table->enum('compile_type', ['Instant', 'Pre-made'])->default('Pre-made')->after('type')
           ->comment('نوع التجميع: فوري أو معد مسبقا');
     
     // إضافة حقل qyt_compile للكمية المجمعة
     $table->integer('qyt_compile')->nullable()->after('compile_type')
           ->comment('كمية المنتج المعد مسبقًا (إذا وجدت)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['storehouse_id', 'compile_type', 'qyt_compile']);
        });
    }
};
