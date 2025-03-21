<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->enum('status', [
                'active',     // العملاء النشطون
                'inactive',   // العملاء غير النشطين
                'blocked',    // العملاء المحظورون
                'potential',  // العملاء المحتملون
                'archived'    // العملاء المؤرشفون
            ])->default('active')->after('id');

            // Optional: Add an index for performance
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
