<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_positions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('department_id');
            $table->string('title', 100);
            $table->string('code', 20)->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('department_id')->references('id')->on('departments');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_positions');
    }
};
