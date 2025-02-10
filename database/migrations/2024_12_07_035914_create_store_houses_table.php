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
        Schema::create('store_houses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('shipping_address')->nullable();
            $table->tinyInteger('status')->comment('0 = active , 1 = inactive , 2 = stopped')->default(0);
            $table->tinyInteger('major')->default(0)->comment('(1 = مستودع رئيسي)');
            $table->tinyInteger('view_permissions')->default(0)->comment('صلاحيه العرض');
            $table->tinyInteger('crate_invoices_permissions')->default(0)->comment('صلاحيه انشاء فاتورة');
            $table->tinyInteger('edit_stock_permissions')->default(0)->comment('صلاحيه تعديل المستودع');
            $table->integer('value_of_view_permissions')->nullable();
            $table->integer('value_of_edit_stock_permissions')->nullable();
            $table->integer('value_of_crate_invoices_permissions')->nullable();
            // $table->foreignId("employee_id")->references("id")->on("employees")->onUpdate("cascade");
            // $table->foreignId("functional_role_id")->references("id")->on("functional_roles")->onUpdate("cascade");
            // $table->foreignId("branch_id")->references("id")->on("branches")->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_houses');
    }
};
