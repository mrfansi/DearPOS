<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('code', 20)->unique();
            $table->uuid('parent_department_id')->nullable();
            $table->uuid('head_of_department_id')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_department_id')->references('id')->on('departments');
            $table->foreign('head_of_department_id')->references('id')->on('employees');
        });
    }

    public function down()
    {
        Schema::dropIfExists('departments');
    }
};
