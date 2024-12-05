<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_prices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('product_id');
            $table->uuid('product_variant_id')->nullable();
            $table->uuid('currency_id');
            
            $table->string('price_type', 20);
            $table->decimal('price', 15, 4);
            $table->decimal('min_quantity', 15, 4)->default(1);
            
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('product_variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('cascade');
            
            $table->foreign('currency_id')
                  ->references('id')
                  ->on('currencies')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_prices');
    }
};
