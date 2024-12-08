<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_benefits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->enum('benefit_type', ['health_insurance', 'life_insurance', 'meal_allowance', 'transportation', 'dental_insurance', 'retirement_plan', 'other']);
            $table->string('name');
            $table->text('description');
            $table->decimal('amount', 15, 4);
            $table->decimal('employer_contribution', 5, 2)->default(0);
            $table->decimal('employee_contribution', 5, 2)->default(0);
            $table->date('effective_date');
            $table->date('expiry_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_benefits');
    }
};
