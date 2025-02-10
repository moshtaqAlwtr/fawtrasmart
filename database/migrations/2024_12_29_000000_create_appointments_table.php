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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('cascade');
            $table->date('appointment_date');
            $table->time('time');
            $table->string('duration')->nullable();
            $table->text('notes')->nullable();
            $table->string('action_type');
            $table->boolean('share_with_client')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->tinyInteger('recurrence_type')->default(1)->comment('1=>weekly, 2=>bi-weekly, 3=>monthly, 4=>bi-monthly, 5=>yearly, 6=>annual');
            $table->date('recurrence_date')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1=>pending, 2=>completed, 3=>ignored , 4=>rescheduled ');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
