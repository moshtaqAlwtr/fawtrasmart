<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('purchase_quotation_supplier', function (Blueprint $table) {
            // إضافة حقل purchase_order_id
            $table->foreignId('purchase_order_id')
                ->nullable()
                ->constrained('purchase_orders')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('purchase_quotation_supplier', function (Blueprint $table) {
            // حذف الحقل في حالة التراجع
            $table->dropForeign(['purchase_order_id']);
            $table->dropColumn('purchase_order_id');
        });
    }
};
