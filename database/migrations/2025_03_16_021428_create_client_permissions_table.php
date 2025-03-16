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
        Schema::create('client_permissions', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // عمود key مع تفعيل unique
            $table->string('name'); // عمود name
            $table->boolean('is_active')->default(true); // عمود is_active مع قيمة افتراضية 1 (t
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_permissions');
    }
};
