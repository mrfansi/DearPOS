<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_barcodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            
            $table->string('barcode_type', 20);
            $table->string('barcode', 100);
            
            $table->boolean('is_primary')->default(false);
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_barcodes');
    }
};
