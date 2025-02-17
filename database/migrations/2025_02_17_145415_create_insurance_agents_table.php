<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_agents', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(); // الاسم
            $table->string('phone')->nullable(); // الهاتف
            $table->string('email')->nullable(); // الايميل
            $table->string('location')->nullable(); // الموقع
            $table->tinyInteger('status')->nullable()->default(1)->comment('1=>active, 2=>stopped, 3=>not active'); // الحالة
            $table->string('attachments')->nullable(); // المرفقات
            $table->timestamps(); // timestamps for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insurance_agents');
    }

};
