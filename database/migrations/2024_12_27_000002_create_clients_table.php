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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->onDelete('set null');
            $table->string('trade_name', 255);
            $table->string('first_name', 100)->nullable();
            $table->integer('user_id')->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('mobile', 50)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('region', 100)->nullable();
            $table->string('street1', 255)->nullable();
            $table->string('street2', 255)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100)->nullable();
            $table->string('tax_number', 50)->nullable();
            $table->string('verification_code', 50)->nullable();
            $table->unsignedBigInteger('classification_id')->nullable()->comment('Client classification category');
            $table->string('commercial_registration', 100)->nullable();
            $table->integer('credit_limit')->nullable();
            $table->integer('credit_period')->nullable();
            $table->tinyInteger('printing_method')->default(1)->comment('1=>printing 2=>email')->nullable();
            $table->decimal('opening_balance', 10, 2)->nullable();
            $table->date('opening_balance_date')->nullable();
            $table->integer('code')->nullable();

            $table->string('currency', 50)->nullable();
            $table->string('email', 255)->nullable();
            $table->unsignedBigInteger('status_id')->nullable();
            $table->tinyInteger('client_type')->default(1)->comment('1=> Regular Client, 2=> VIP Client')->nullable();
            $table->text('notes')->nullable();
            $table
                ->enum('status', [
                    'active', // العملاء النشطون
                    'inactive', // العملاء غير النشطين
                    'blocked', // العملاء المحظورون
                    'potential', // العملاء المحتملون
                    'archived', // العملاء المؤرشفون
                ])
                ->default('active')
                ->nullable();

            $table->text('attachments')->nullable();

            // إضافة التصنيف
            $table->string('category', 255)->nullable();

            $table->timestamps();
            // إضافة soft delete للعملاء
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('clients');
        Schema::enableForeignKeyConstraints();
    }
};
