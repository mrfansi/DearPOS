<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_postings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('position_id');
            $table->string('title', 100);
            $table->text('description');
            $table->text('requirements');
            $table->enum('status', ['draft', 'open', 'closed', 'on_hold']);
            $table->date('posted_date');
            $table->date('closing_date')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('position_id')->references('id')->on('job_positions');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_postings');
    }
};
