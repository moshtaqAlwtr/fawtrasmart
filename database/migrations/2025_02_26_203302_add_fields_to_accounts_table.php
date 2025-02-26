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
       
        Schema::table('accounts', function (Blueprint $table) {
            $table->integer('deposit_permissions')->nullable();
            $table->integer('withdraw_permissions')->nullable();
            $table->integer('value_of_deposit_permissions')->nullable();
            $table->integer('value_of_withdraw_permissions')->nullable();
            $table->string('type_accont')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            //
        });
    }
};
