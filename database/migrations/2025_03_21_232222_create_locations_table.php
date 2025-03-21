<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationsTable extends Migration
{
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->nullable(); // معرف الموظف
            $table->unsignedBigInteger('client_id')->nullable(); // معرف العميل
            $table->decimal('latitude', 10, 8)->nullable(); // خط العرض
            $table->decimal('longitude', 10, 8)->nullable(); // خط الطول
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
