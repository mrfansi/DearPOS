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
        Schema::create('units_of_measures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Identification and Categorization
            $table->string('code', 10)->unique(); // Unique code for the unit
            $table->string('name', 50); // Full name of the unit
            $table->string('category', 20); // Category of measurement
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units_of_measures');
    }
};
