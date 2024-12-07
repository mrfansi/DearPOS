<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id');
            $table->uuid('leave_type_id');
            $table->uuid('approver_id')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('total_days', 5, 2);
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->text('reason')->nullable();
            $table->text('approver_comments')->nullable();
            $table->dateTime('approved_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('leave_type_id')->references('id')->on('leave_types');
            $table->foreign('approver_id')->references('id')->on('employees');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
