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
        Schema::create('inventory_transaction_items', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->uuid('transaction_id');
            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            $table->uuid('lot_id')->nullable();

            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            $table->decimal('unit_cost', 15, 4);
            $table->uuid('currency_id');

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('transaction_id')
                ->references('id')
                ->on('inventory_transactions')
                ->cascadeOnDelete();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();

            $table->foreign('variant_id')
                ->references('id')
                ->on('product_variants')
                ->cascadeOnDelete();

            $table->foreign('lot_id')
                ->references('id')
                ->on('inventory_lots')
                ->cascadeOnDelete();

            $table->foreign('unit_id')
                ->references('id')
                ->on('units_of_measures')
                ->onDelete('restrict');

            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transaction_items');
    }
};
