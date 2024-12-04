<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('return_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('return_id');
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_amount', 15, 4);
            $table->text('reason')->nullable();
            $table->enum('condition', ['good', 'damaged', 'defective'])->default('good');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('return_id')->references('id')->on('returns');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('product_variant_id')->references('id')->on('product_variants');
        });
    }

    public function down()
    {
        Schema::dropIfExists('return_items');
    }
};
