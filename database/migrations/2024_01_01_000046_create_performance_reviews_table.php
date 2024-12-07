<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->uuid('reviewer_id');
            $table->date('review_date');
            $table->enum('review_period', ['quarterly', 'semi_annual', 'annual']);
            $table->enum('overall_rating', ['needs_improvement', 'meets_expectations', 'exceeds_expectations', 'outstanding'])->nullable();
            $table->text('strengths')->nullable();
            $table->text('areas_for_improvement')->nullable();
            $table->text('goals_for_next_period')->nullable();
            $table->text('reviewer_comments')->nullable();
            $table->boolean('is_final')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('reviewer_id')->references('id')->on('employees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};
