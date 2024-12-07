<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shifts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('duration_minutes');
            $table->text('description')->nullable();
            $table->boolean('is_night_shift')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shifts');
    }
};
