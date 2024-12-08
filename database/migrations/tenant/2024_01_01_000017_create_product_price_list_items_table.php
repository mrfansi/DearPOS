<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_price_list_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('price_list_id')->constrained('product_price_lists')->cascadeOnDelete();
            $table->foreignUuid('variant_id')->constrained('product_variants')->cascadeOnDelete();
            $table->decimal('price', 15, 4);
            $table->decimal('min_quantity', 15, 4)->default(1);
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['price_list_id', 'variant_id', 'min_quantity'], 'price_list_variant_quantity_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_price_list_items');
    }
};
