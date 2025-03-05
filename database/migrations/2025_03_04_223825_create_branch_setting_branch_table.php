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
        Schema::create('branch_setting_branch', function (Blueprint $table) {
             $table->id();
             $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade');
             $table->foreignId('branch_setting_id')->constrained('branch_settings')->onDelete('cascade');
             $table->boolean('status')->default(1); // مفعّل افتراضيًا
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branch_setting_branch');
    }
};
