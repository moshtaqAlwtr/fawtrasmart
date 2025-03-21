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
        Schema::table('branch_settings', function (Blueprint $table) {
       
            $table->string('share_cost_center'); // مشاركة مركز التكلفة بين الفروع
            $table->string('share_customers'); // مشاركة العملاء بين الفروع
            $table->string('share_products'); // مشاركة المنتجات بين الفروع
            $table->string('share_suppliers'); // مشاركة الموردين بين الفروع
            $table->string('account_tree'); // تخصيص الحسابات لكل فرع
            $table->boolean('is_active')->default(true); // الحالة (مفعل/موقوف)
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branch_settings', function (Blueprint $table) {
            //
        });
    }
};
