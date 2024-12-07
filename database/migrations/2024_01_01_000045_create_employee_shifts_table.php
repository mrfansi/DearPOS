<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('employee_shifts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->uuid('shift_id');
            $table->date('shift_date');
            $table->enum('status', ['scheduled', 'worked', 'absent', 'late', 'early_leave'])->default('scheduled');
            $table->time('actual_start_time')->nullable();
            $table->time('actual_end_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('shift_id')->references('id')->on('shifts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employee_shifts');
    }
};
