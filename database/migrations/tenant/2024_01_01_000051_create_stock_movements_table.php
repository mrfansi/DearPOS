<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            $table->uuid('warehouse_id');
            $table->enum('movement_type', ['in', 'out', 'transfer', 'adjustment']);
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            $table->enum('reference_type', ['sale', 'purchase', 'transfer', 'adjustment', 'waste']);
            $table->uuid('reference_id');
            $table->string('lot_number', 50)->nullable();
            $table->date('expiry_date')->nullable();
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_variant_id')->references('id')->on('product_variants');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('unit_id')->references('id')->on('units_of_measures');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
