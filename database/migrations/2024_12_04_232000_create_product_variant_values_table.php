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
        Schema::create('product_variant_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('variant_id');
            $table->uuid('attribute_id');
            $table->string('value', 100);
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');

            $table->foreign('attribute_id')
                  ->references('id')
                  ->on('variant_attributes')
                  ->onDelete('cascade');

            // Unique constraint to prevent duplicate variant-attribute combinations
            $table->unique(['variant_id', 'attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variant_values');
    }
};
