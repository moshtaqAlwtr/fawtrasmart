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
        Schema::create('warehouse_permits', function (Blueprint $table) {
            $table->id();
            $table->integer('permission_type')->nullable();
            $table->dateTime('permission_date')->nullable();
            $table->tinyInteger('sub_account')->nullable();
            $table->string('number')->nullable();
            $table->integer('store_houses_id')->nullable();
            $table->integer('from_store_houses_id')->nullable();
            $table->integer('to_store_houses_id')->nullable();
            $table->text('details')->nullable();
            $table->text('attachments')->nullable();
            $table->decimal('grand_total', 10, 2)->nullable();
            $table->foreignId('created_by')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_permits');
    }
};
