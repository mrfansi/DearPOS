<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pre_order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('pre_order_id');
            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            $table->uuid('unit_id');
            
            $table->decimal('quantity', 15, 4);
            $table->decimal('unit_price', 15, 4);
            $table->decimal('total_price', 15, 4);
            
            $table->text('special_instructions')->nullable();
            
            $table->foreign('pre_order_id')
                  ->references('id')
                  ->on('pre_orders')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');
            
            $table->foreign('variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('restrict');
            
            $table->foreign('unit_id')
                  ->references('id')
                  ->on('units_of_measures')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pre_order_items');
    }
};
