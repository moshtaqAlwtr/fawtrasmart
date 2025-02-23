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
        Schema::create('work_stations_costs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('work_station_id')->constrained('work_stations')->onDelete('cascade');
            $table->decimal('cost_expenses', 10, 2)->nullable();
            $table->integer('account_expenses')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_stations_costs');
    }
};
