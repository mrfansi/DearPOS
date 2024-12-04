<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('employee_benefits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->string('benefit_type');
            $table->string('provider_name');
            $table->text('coverage_details')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('annual_cost', 15, 2)->nullable();
            $table->decimal('employee_contribution', 15, 2)->nullable();
            $table->decimal('employer_contribution', 15, 2)->nullable();
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_benefits');
    }
};
