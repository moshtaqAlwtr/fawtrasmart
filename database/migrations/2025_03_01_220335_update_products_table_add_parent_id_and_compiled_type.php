<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // إضافة حقل parent_id مع السماح بالقيم الفارغة (nullable)
            $table->foreignId('parent_id')->nullable()->constrained('products')->onDelete('cascade');

            // تعديل enum لإضافة النوع الجديد (compiled)
            DB::statement("ALTER TABLE products MODIFY COLUMN type ENUM('products', 'services', 'compiled') DEFAULT 'products'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
          // إزالة الحقل parent_id
          $table->dropForeign(['parent_id']);
          $table->dropColumn('parent_id');

          // إعادة enum إلى القيم القديمة
          DB::statement("ALTER TABLE products MODIFY COLUMN type ENUM('products', 'services') DEFAULT 'products'");
        });
    }
};
