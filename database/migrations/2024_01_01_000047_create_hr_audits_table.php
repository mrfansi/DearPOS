<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('hr_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('employee_id')->nullable();
            $table->uuid('user_id');
            $table->string('action', 100);
            $table->string('model_type', 255);
            $table->uuid('model_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('reason')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hr_audits');
    }
};
