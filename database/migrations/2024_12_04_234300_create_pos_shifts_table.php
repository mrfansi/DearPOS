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
        Schema::create('pos_shifts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Shift References
            $table->uuid('pos_counter_id');
            $table->uuid('user_id'); // Cashier
            
            // Timing
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            
            // Status
            $table->string('status', 20); // active, closed, suspended
            
            // Cash Management
            $table->decimal('opening_cash_balance', 15, 4);
            $table->decimal('closing_cash_balance', 15, 4)->nullable();
            $table->decimal('cash_sales_total', 15, 4)->default(0);
            
            // Transaction Summary
            $table->integer('total_transactions')->default(0);
            
            // Additional Information
            $table->text('notes')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('pos_counter_id')
                  ->references('id')
                  ->on('pos_counters')
                  ->onDelete('restrict');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pos_shifts');
    }
};
