<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_calculations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->integer('tax_year');
            $table->decimal('gross_income', 15, 2);
            $table->decimal('taxable_income', 15, 2);
            $table->decimal('tax_deductions', 15, 2)->nullable();
            $table->decimal('tax_exemptions', 15, 2)->nullable();
            $table->decimal('calculated_tax', 15, 2);
            $table->decimal('tax_paid', 15, 2)->nullable();
            $table->decimal('tax_balance', 15, 2)->nullable();
            $table->string('tax_status')->default('pending');
            $table->date('calculation_date');
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_calculations');
    }
};
