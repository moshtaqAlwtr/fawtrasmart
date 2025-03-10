<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionTypeToAppointmentNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('appointment_notes', function (Blueprint $table) {
            // إضافة حقل action_type من نوع string
            $table->string('action_type')->nullable()->after('note'); // يمكنك تغيير النوع حسب الحاجة
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('appointment_notes', function (Blueprint $table) {
            // حذف الحقل عند التراجع عن Migration
            $table->dropColumn('action_type');
        });
    }
}
