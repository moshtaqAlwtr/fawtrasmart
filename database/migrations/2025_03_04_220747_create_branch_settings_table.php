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
        Schema::create('branch_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active')->default(true);
            $table->string('name')->nullable(); // اسم الصلاحية
            $table->string('key')->unique(); // مفتاح فريد للصلاحية

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_settings');
    }
};
