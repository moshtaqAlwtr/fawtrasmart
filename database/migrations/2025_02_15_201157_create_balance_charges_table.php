<?php

use App\Models\BalanceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceChargesTable extends Migration
{
    public function up()
    {
        Schema::create('balance_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('balance_type_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('status')->nullable()->default(1);
            $table->text('description')->nullable();

            $table->boolean('contract_type')->nullable(); // or $table->string('contract_type'); if you prefer string
            $table->timestamps();

            // Foreign key constraints

            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('balance_type_id')->references('id')->on('balance_types')->onDelete('cascade');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('balance_charges');
    }
}
