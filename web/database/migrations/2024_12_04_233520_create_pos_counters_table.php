<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pos_counters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Basic Information
            $table->string('name');
            $table->string('code')->unique();
            $table->uuid('location_id');
            
            // Status and Configuration
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->string('terminal_number')->nullable();
            
            // Peripheral Configuration
            $table->string('printer_name')->nullable();
            $table->string('cash_drawer_name')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('location_id')
                  ->references('id')
                  ->on('locations')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_counters');
    }
};
