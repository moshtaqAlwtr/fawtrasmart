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
             $table->dropForeign('treasury_employees_employee_id_foreign');

            // تغيير نوع العمود employee_id إلى integer
            $table->integer('employee_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('treasury_employees', function (Blueprint $table) {
            $table->foreign('employee_id')->references('id')->on('quotes')->onDelete('cascade')->change();
        });
    }
};
