<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statuses', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name')->nullable(); // Name of the status
            $table->string('color')->nullable(); // Color associated with the status
            $table->tinyInteger('state')->default(1)->nullable(); // State of the status

             // Foreign key linking to orders table
             $table->foreignId('supply_order_id')->nullable()->constrained('supply_orders')->onDelete('set null');
             $table->foreignId('client_id')->nullable()->constrained('clients')->onDelete('set null');
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
