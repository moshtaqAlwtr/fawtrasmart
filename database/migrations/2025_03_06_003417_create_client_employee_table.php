<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientEmployeeTable extends Migration
{
    public function up()
    {
        Schema::create('client_employee', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->string('relationship_type')->nullable(); // Optional: to define the type of relationship
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');

            // Unique constraint to prevent duplicate relationships
            $table->unique(['client_id', 'employee_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('client_employee');
    }
}
