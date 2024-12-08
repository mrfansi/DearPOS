<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_transfer_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('transfer_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            $table->decimal('quantity_requested', 15, 4);
            $table->decimal('quantity_sent', 15, 4)->nullable();
            $table->decimal('quantity_received', 15, 4)->nullable();
            $table->uuid('unit_id');
            $table->string('lot_number', 50)->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('transfer_id')->references('id')->on('stock_transfers');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_variant_id')->references('id')->on('product_variants');
            $table->foreign('unit_id')->references('id')->on('units_of_measures');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_transfer_items');
    }
};
