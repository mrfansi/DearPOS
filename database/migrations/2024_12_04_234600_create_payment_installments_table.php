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
        Schema::create('payment_installments', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Payment Reference
            $table->uuid('payment_id');

            // Installment Details
            $table->integer('installment_number');
            $table->decimal('amount', 15, 4);

            // Timing
            $table->date('due_date');
            $table->date('paid_date')->nullable();

            // Status
            $table->string('status', 20); // pending, paid, overdue

            // Additional Information
            $table->text('notes')->nullable();

            // Timestamps and Soft Delete
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key Constraints
            $table->foreign('payment_id')
                ->references('id')
                ->on('payments')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_installments');
    }
};
