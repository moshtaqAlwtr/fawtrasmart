<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTypesTable extends Migration
{
    public function up()
    {
        Schema::create('balance_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // Name of the balance
            $table->tinyInteger('status')->nullable()->default(1); // Active or inactive
            $table->string('unit')->nullable(); // Unit of measurement
            $table->boolean('allow_decimal')->default(false); // Allow decimal numbers
            $table->decimal('balance_value', 10, 2)->nullable();
            $table->text('description')->nullable(); // Description of the balance type

            $table->timestamps(); // Created at and updated at timestamps

 // Soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('balance_types');
    }
}
