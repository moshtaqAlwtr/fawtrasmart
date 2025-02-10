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
        Schema::create('attendance_determinants', function (Blueprint $table) {
            $table->id();
            # Basic information
            $table->string('name');
            $table->tinyInteger('status')->default(0)->comment('(0 نشط) , (غير نشط 1)');

            # IP-based settings
            $table->boolean('enable_ip_verification')->default(false); // تفعيل مطابقة IP
            $table->tinyInteger('ip_investigation')->default(1)->comment('(1 مطلوب) , (اختياري 2)');
            $table->text('allowed_ips')->nullable(); // قائمة عناوين IP المسموح بها

            # Location-based settings
            $table->boolean('enable_location_verification')->default(false); // تفعيل مطابقة موقع الحضور
            $table->tinyInteger('location_investigation')->default(1)->comment('(1 مطلوب) , (اختياري 2)');
            $table->decimal('latitude', 10, 8)->nullable(); // خط العرض
            $table->decimal('longitude', 11, 8)->nullable(); // خط الطول
            $table->integer('radius')->nullable(); // نطاق التوقيع (بالمتر)
            $table->tinyInteger('radius_type')->default(1)->comment('(1 امتار) , (كيلومترات 2)');

            # Employee image verification
            $table->boolean('capture_employee_image')->default(false); // التقاط صور الموظفين
            $table->tinyInteger('image_investigation')->default(1)->comment('(1 مطلوب) , (اختياري 2)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_determinants');
    }
};
