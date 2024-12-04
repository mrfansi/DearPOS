<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shift_coverages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('shift_rotation_id')->nullable();
            $table->uuid('employee_id');
            $table->date('date');
            $table->uuid('shift_id');
            $table->boolean('is_primary')->default(true);
            $table->boolean('is_replacement')->default(false);
            $table->uuid('replacement_employee_id')->nullable();
            $table->text('reason_for_coverage')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('shift_rotation_id')->references('id')->on('shift_rotations')->onDelete('set null');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->foreign('shift_id')->references('id')->on('shifts')->onDelete('cascade');
            $table->foreign('replacement_employee_id')->references('id')->on('employees')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('shift_coverages');
    }
};
