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
        Schema::create('income', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->date('date'); // Revenue Date
            $table->string('source', 255); // Revenue Source
            $table->decimal('amount', 15, 2); // Amount
            $table->text('description')->nullable(); // Description
            $table->unsignedBigInteger('account_id'); // Foreign Key to Chart of Accounts
            $table->unsignedBigInteger('treasury_id')->nullable(); // Foreign Key to Treasuries
            $table->unsignedBigInteger('bank_account_id')->nullable(); // Foreign Key to Bank Accounts
            $table->unsignedBigInteger('journal_entry_id')->nullable(); // Foreign Key to Journal Entries
            $table->string('created_by', 255)->nullable(); // User who created the revenue
            $table->timestamps();

            // Foreign Key Constraints
            $table->foreign('account_id')->references('id')->on('chart_of_accounts')->onDelete('cascade');
            $table->foreign('treasury_id')->references('id')->on('treasuries')->onDelete('set null');
            $table->foreign('bank_account_id')->references('id')->on('bank_accounts')->onDelete('set null');
            $table->foreign('journal_entry_id')->references('id')->on('journal_entries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income');
    }
};
