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
        Schema::create('memberships', function (Blueprint $table) {
            $table->id();
            $table->integer('client_id'); // علاقة بالعملاء
            $table->string('package_id'); // اسم الباقة
            $table->date('join_date'); // تاريخ الالتحاق
            $table->date('end_date'); // تاريخ الانتهاء
            $table->enum('status', ['active', 'deactive', 'pending'])->default('active');
            $table->text('description')->nullable(); // الوصف (يمكن أن يكون فارغًا)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memberships');
    }
};
