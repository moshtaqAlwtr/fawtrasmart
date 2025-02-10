<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('treasury_employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treasury_id')->constrained('quotes')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('quotes')->onDelete('cascade');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('treasury_employees');
    }
};
