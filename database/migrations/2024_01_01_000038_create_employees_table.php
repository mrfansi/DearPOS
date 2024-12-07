<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->uuid('department_id');
            $table->uuid('position_id');
            $table->string('employee_code', 20)->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('email', 100)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            $table->date('birth_date')->nullable();
            $table->date('hire_date');
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->enum('status', ['active', 'on_leave', 'terminated', 'suspended']);
            $table->string('emergency_contact_name', 100)->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('position_id')->references('id')->on('job_positions');
        });

        // Add manager_id foreign key to departments table
        Schema::table('departments', function (Blueprint $table) {
            $table->foreign('manager_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down(): void
    {
        // Remove foreign key first
        Schema::table('departments', function (Blueprint $table) {
            $table->dropForeign(['manager_id']);
        });

        Schema::dropIfExists('employees');
    }
};
