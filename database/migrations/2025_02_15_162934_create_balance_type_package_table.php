<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalanceTypePackageTable extends Migration
{
    public function up()
    {
        Schema::create('balance_type_package', function (Blueprint $table) {
            $table->id();

            // Foreign key for balance types
            $table->unsignedBigInteger('balance_type_id');
            $table->foreign('balance_type_id')->references('id')->on('balance_types')->onDelete('cascade')->nullable();

            // Foreign key for packages
            $table->unsignedBigInteger('package_id');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade')->nullable();

            // Balance value
            $table->decimal('balance_value', 10, 2)->nullable();

            $table->timestamps(); // Created at and updated at timestamps
        });
    }


    public function down()
    {
        Schema::dropIfExists('balance_type_package');
    }
}
