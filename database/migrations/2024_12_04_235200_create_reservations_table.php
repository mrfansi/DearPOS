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
        Schema::create('reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Reservation Identifiers
            $table->string('reservation_number')->unique();
            $table->uuid('customer_id')->nullable();
            $table->uuid('pos_counter_id');
            $table->uuid('sales_transaction_id')->nullable();
            
            // Timing and Duration
            $table->date('reservation_date');
            $table->dateTime('reservation_time');
            $table->integer('expected_duration')->nullable(); // in minutes
            
            // Status and Details
            $table->string('status', 20); // confirmed, in_progress, completed, cancelled
            $table->integer('total_guests')->default(1);
            
            // Additional Information
            $table->text('special_requests')->nullable();
            $table->decimal('deposit_amount', 15, 4)->nullable();
            $table->text('notes')->nullable();
            
            // Creator
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

            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('set null');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });

        // Reservation Items Table
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Reservation and Product References
            $table->uuid('reservation_id');
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
            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
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
        Schema::dropIfExists('reservation_items');
        Schema::dropIfExists('reservations');
    }
};
