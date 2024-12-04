<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->string('policy_type');
            $table->string('provider_name');
            $table->string('policy_number')->unique();
            $table->decimal('coverage_amount', 15, 2);
            $table->decimal('premium_amount', 15, 2);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('coverage_details')->nullable();
            $table->string('beneficiary_name')->nullable();
            $table->string('beneficiary_relationship')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('insurance_policies');
    }
};
