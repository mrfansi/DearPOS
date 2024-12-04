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
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('transaction_type', 20);
            $table->uuid('reference_id');
            $table->string('reference_type', 50);

            $table->uuid('location_id');
            $table->timestamp('transaction_date');

            $table->text('notes')->nullable();
            $table->uuid('created_by');

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('location_id')
                ->references('id')
                ->on('locations')
                ->onDelete('restrict');

            $table->foreign('created_by')
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
        Schema::dropIfExists('inventory_transactions');
    }
};
