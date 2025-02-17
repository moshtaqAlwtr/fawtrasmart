<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsuranceAgentCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_agent_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->nullable(); // مفتاح خارجي للتصنيف
            $table->foreignId('insurance_agent_id')->constrained('insurance_agents')->onDelete('cascade')->nullable();
            $table->string('name')->nullable();
            $table->decimal('discount')->nullable(); // الخصم
            $table->decimal('company_copayment')->default(0); // نسبة الدفع المشترك من الشركة
            $table->decimal('client_copayment')->default(0); // نسبة الدفع المشترك من العميل
            $table->decimal('max_copayment')->nullable(); // الحد الأقصى للدفع المشترك
            $table->tinyInteger('status')->nullable()->default(1);
            $table->tinyInteger('type')->nullable()->default(1);
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
        Schema::dropIfExists('insurance_agent_categories');
    }
}
