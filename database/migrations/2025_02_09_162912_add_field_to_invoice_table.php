<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('code')->unique()->nullable()->after('id'); // إضافة unique لجعل الحقل فريدًا
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropUnique(['code']); // إزالة الـ unique عند التراجع
            $table->dropColumn('code'); // حذف الحقل
        });
    }
};
