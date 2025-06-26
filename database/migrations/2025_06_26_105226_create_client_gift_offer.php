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
        Schema::create('client_gift_offer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('gift_offer_id');
            $table->unsignedBigInteger('client_id');
            $table->foreign('gift_offer_id')->references('id')->on('gift_offers')->onDelete('cascade');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_gift_offer');
    }
};
