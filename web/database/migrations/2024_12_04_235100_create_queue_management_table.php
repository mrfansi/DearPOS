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
        Schema::create('queue_managements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Queue Identifiers
            $table->string('queue_number')->unique();
            $table->uuid('customer_id')->nullable();
            $table->uuid('pos_counter_id');
            
            // Status and Timing
            $table->string('status', 20); // waiting, processing, completed, cancelled
            $table->integer('priority')->default(0);
            
            // Wait Time Tracking
            $table->integer('estimated_wait_time')->nullable(); // in minutes
            $table->integer('actual_wait_time')->nullable(); // in minutes
            
            // Additional Information
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');

            $table->foreign('pos_counter_id')
                  ->references('id')
                  ->on('pos_counters')
                  ->onDelete('restrict');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });

        // Queue Items Table
        Schema::create('queue_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Queue and Product References
            $table->uuid('queue_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            // Quantity and Details
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            $table->text('special_instructions')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('queue_id')
                  ->references('id')
                  ->on('queue_managements')
                  ->onDelete('cascade');

            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');

            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('set null');

            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units_of_measures')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_items');
        Schema::dropIfExists('queue_managements');
    }
};
