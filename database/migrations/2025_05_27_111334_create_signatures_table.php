<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignaturesTable extends Migration
{
    public function up()
    {
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->string('signer_name');
            $table->string('signer_role')->nullable();
            $table->text('signature_data'); // تخزين التوقيع كـ base64
            $table->decimal('amount_paid', 15, 2)->nullable(); // المبلغ المدفوع
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('signatures');
    }
}
