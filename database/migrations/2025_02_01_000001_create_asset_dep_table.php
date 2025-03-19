<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('asset_dep', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('asset_depreciations')->onDelete('cascade');

            // القيم الأساسية
            $table->decimal('salvage_value', 15, 2)->nullable()->comment('قيمة الخردة');
            $table->tinyInteger('dep_method')->nullable()->comment('1=القسط الثابت, 2=القسط المتناقص, 3=وحدات الانتاج, 4=بدون الاهلاك');

            // حقول الإهلاك المشتركة
            $table->decimal('dep_rate', 15, 2)->nullable()->comment('قيمة/نسبة الإهلاك');
            $table->integer('duration')->nullable()->comment('مدة الإهلاك');
            $table->tinyInteger('period')->nullable()->comment('1=يومي, 2=شهري, 3=سنوي');

            // حقول وحدات الإنتاج
            $table->string('unit_name')->nullable()->comment('اسم الوحدة');
            $table->integer('total_units')->nullable()->comment('إجمالي الوحدات');

            // القيم المحاسبية
            $table->decimal('acc_dep', 15, 2)->default(0)->comment('مجمع الإهلاك');
            $table->decimal('book_value', 15, 2)->default(0)->comment('القيمة الدفترية');
            $table->date('last_dep_date')->nullable()->comment('تاريخ آخر إهلاك');
            $table->date('end_date')->nullable()->comment('تاريخ انتهاء الإهلاك');

            // الحسابات
            $table->foreignId('dep_account_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete()
                ->comment('حساب مصروف الإهلاك');

            $table->foreignId('acc_dep_account_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete()
                ->comment('حساب مجمع الإهلاك');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asset_dep');
    }
};
