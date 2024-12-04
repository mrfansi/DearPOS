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
        Schema::create('storage_locations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('warehouse_id');
            $table->string('name', 100);
            $table->string('code', 20)->unique();
            
            $table->string('type', 50); // rack, shelf, bin, etc.
            $table->text('description')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->integer('capacity')->nullable(); // storage capacity units
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('warehouse_id')
                  ->references('id')
                  ->on('warehouses')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('storage_locations');
    }
};
