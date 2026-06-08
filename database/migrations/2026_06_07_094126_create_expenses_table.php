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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->nullable()->constrained('vendors')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('expense_category_id')->constrained('expense_categories')->noActionOnDelete();
            $table->integer('amount');
            $table->string('payment_method')->nullable();
            $table->foreignId('expense_request_type_id')->constrained('expense_request_types')->noActionOnDelete();
            $table->string('status');
            $table->longText('description')->nullable();
            $table->string('transaction_reference')->nullable();
            $table->longText('justification');
            $table->boolean('is_pre_authorized')->default(false);
            $table->date('payment_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_requests');
    }
};
