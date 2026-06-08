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
        Schema::create('expense_queries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->noActionOnDelete();
            $table->foreignId('requester_id')->constrained('users')->noActionOnDelete();
            $table->foreignId('expense_query_category_id')->constrained('expense_query_categories')->noActionOnDelete();
            $table->string('status');
            $table->string('remarks');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_queries');
    }
};
