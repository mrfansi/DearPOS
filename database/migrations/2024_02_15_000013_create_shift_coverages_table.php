<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
        });
    }

    public function down()
    {
        Schema::dropIfExists('shift_coverages');
    }
};
