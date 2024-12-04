<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table("employees", function (Blueprint $table) {
            $table->foreign("department_id")->references("id")->on("departments");
            $table->foreign("position_id")->references("id")->on("positions");
        });

        Schema::table("departments", function (Blueprint $table) {
            $table->foreign("parent_department_id")->references("id")->on("departments");
            $table->foreign("head_of_department_id")->references("id")->on("employees");
        });

        Schema::table("positions", function (Blueprint $table) {
            $table->foreign("department_id")->references("id")->on("departments");
        });

        Schema::table("job_postings", function (Blueprint $table) {
            $table->foreign('department_id')->references('id')->on('departments')->nullOnDelete();
            $table->foreign('position_id')->references('id')->on('positions')->nullOnDelete();
        });

        Schema::table('break_times', function (Blueprint $table) {
            $table->foreign('shift_id')->references('id')->on('shifts')->cascadeOnDelete();
        });

        Schema::table('shift_coverages', function (Blueprint $table) {
            $table->foreign('shift_rotation_id')->references('id')->on('shift_rotations')->nullOnDelete();
            $table->foreign('employee_id')->references('id')->on('employees')->cascadeOnDelete();
            $table->foreign('shift_id')->references('id')->on('shifts')->cascadeOnDelete();
            $table->foreign('replacement_employee_id')->references('id')->on('employees')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("employees", function (Blueprint $table) {
            $table->dropForeign(["department_id", "position_id"]);
        });

        Schema::table("departments", function (Blueprint $table) {
            $table->dropForeign(["parent_department_id", "head_of_department_id"]);
        });

        Schema::table("positions", function (Blueprint $table) {
            $table->dropForeign("department_id");
        });

        Schema::table("job_postings", function (Blueprint $table) {
            $table->dropForeign(['department_id', 'position_id']);
        });

        Schema::table('break_times', function (Blueprint $table) {
            $table->dropForeign('shift_id');
        });

        Schema::table('shift_coverages', function (Blueprint $table) {
            $table->dropForeign(['shift_rotation_id', 'employee_id', 'shift_id', 'replacement_employee_id']);
        });
    }
};
