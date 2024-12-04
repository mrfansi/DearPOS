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
        Schema::create('table_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Table References
            $table->uuid('from_table_id');
            $table->uuid('to_table_id');
            $table->uuid('sales_transaction_id')->nullable();
            $table->uuid('user_id'); // staff who performed the transfer

            // Transfer Details
            $table->text('transfer_reason')->nullable();
            $table->string('status', 50); // pending, completed, cancelled
            $table->text('notes')->nullable();

            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('from_table_id')
                ->references('id')
                ->on('tables')
                ->onDelete('restrict');

            $table->foreign('to_table_id')
                ->references('id')
                ->on('tables')
                ->onDelete('restrict');

            $table->foreign('sales_transaction_id')
                ->references('id')
                ->on('sales_transactions')
                ->nullOnDelete();

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
        Schema::dropIfExists('table_transfers');
    }
};
