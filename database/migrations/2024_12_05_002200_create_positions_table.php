<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title', 100);
            $table->string('code', 20)->unique();
            $table->uuid('department_id');
            $table->text('job_description')->nullable();
            $table->decimal('minimum_salary', 15, 4)->nullable();
            $table->decimal('maximum_salary', 15, 4)->nullable();
            $table->boolean('is_management_position')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('positions');
    }
};
