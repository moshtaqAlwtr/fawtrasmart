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
        Schema::create('work_stations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->text('description')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('total_cost');
            $table->decimal('cost_wages', 10, 2)->nullable();
            $table->integer('account_wages')->nullable();
            $table->decimal('cost_origin', 10, 2)->nullable();
            $table->integer('origin')->nullable();
            $table->tinyInteger('automatic_depreciation')->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_stations');
    }
};
