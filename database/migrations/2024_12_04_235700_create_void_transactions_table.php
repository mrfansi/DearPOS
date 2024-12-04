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
        Schema::create('void_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            // Transaction References
            $table->uuid('sales_transaction_id');
            $table->uuid('pos_counter_id');
            $table->uuid('user_id'); // staff who voided the transaction
            
            // Void Details
            $table->text('void_reason')->nullable();
            $table->string('status', 50); // pending, approved, rejected
            $table->decimal('original_total_amount', 15, 4);
            $table->text('notes')->nullable();
            
            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('sales_transaction_id')
                  ->references('id')
                  ->on('sales_transactions')
                  ->onDelete('cascade');

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
        Schema::dropIfExists('void_transactions');
    }
};
