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
        Schema::create('expense_rejections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expense_id')->constrained('expenses')->noActionOnDelete();
            $table->foreignId('rejecter_id')->constrained('users')->noActionOnDelete();
            $table->foreignId('rejection_category_id')->constrained('expense_rejection_categories')->noActionOnDelete();
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
        Schema::dropIfExists('expense_rejections');
    }
};
