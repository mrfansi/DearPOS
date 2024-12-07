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
            $table->string('benefit_name', 100);
            $table->text('description')->nullable();
            $table->enum('benefit_type', ['health', 'dental', 'vision', 'life_insurance', 'retirement', 'other']);
            $table->decimal('employer_contribution', 10, 2)->nullable();
            $table->decimal('employee_contribution', 10, 2)->nullable();
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
