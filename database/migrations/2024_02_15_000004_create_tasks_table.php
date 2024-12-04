<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->text('description')->nullable();
            $table->uuid('assigned_to_employee_id');
            $table->uuid('created_by_employee_id');
            $table->uuid('department_id')->nullable();
            $table->string('priority')->default('medium');
            $table->string('status')->default('not_started');
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completed_date')->nullable();
            $table->decimal('estimated_hours', 8, 2)->nullable();
            $table->decimal('actual_hours', 8, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('assigned_to_employee_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->foreign('created_by_employee_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
