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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->tinyInteger('type_of_operation')->nullable();
            $table->tinyInteger('type')->nullable();
            $table->text('comments')->nullable();
            $table->string('attachments')->nullable();
            $table->string('subaccount')->nullable();
            $table->foreignId("product_id")->references("id")->on("products")->onUpdate("cascade");
            $table->integer("purchase_order_id")->nullable();
            $table->integer("purchase_quotation_id")->nullable();
            $table->integer("duration")->nullable();
            $table->unsignedBigInteger("store_house_id")->nullable();
            $table->tinyInteger('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
