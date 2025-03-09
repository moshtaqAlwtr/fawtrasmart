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
        Schema::table('job_roles', function (Blueprint $table) {
            $table->tinyInteger('work_cycle')->default(0); //دورة العمل
            $table->tinyInteger('templates')->default(0); // القوالب
            $table->tinyInteger('branches')->default(0); // الفروع
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_roles', function (Blueprint $table) {
            //
        });
    }
};
