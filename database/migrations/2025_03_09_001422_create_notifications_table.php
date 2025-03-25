<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(); // الحقل الأول: title
            $table->text('description')->nullable(); // الحقل الثاني: description
            $table->tinyInteger('read')->nullable()->default(0); // الحقل الثالث: read (0 أو 1)
            $table->unsignedBigInteger('user_id')->nullable(); // الحقل الرابع: user_id
            $table->string('type')->nullable(); // الحقل الرابع: type
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
