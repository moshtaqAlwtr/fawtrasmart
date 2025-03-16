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
        Schema::create('general_client_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // عمود key مع تفعيل unique
            $table->string('name'); // عمود name
            $table->integer('is_active')->default(1); // عمود is_active مع قيمة افتراضية 1 (true)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('general_client_settings');
    }
};
