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
        Schema::table('commissions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم العمولة
            $table->string('status');
            $table->enum('period', ['yearly', 'quarterly', 'monthly'])
                  ->default('monthly') // القيمة الافتراضية
                  ->after('column_name');
           $table->enum('commission_calculation', ['fully_paid', 'partially_paid'])
                  ->default('fully_paid')
                  ->after('column_name');
            $table->timestamps();
            $table->string('currency');
            $table->string('notes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commissions', function (Blueprint $table) {
            //
        });
    }
};
