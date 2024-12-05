<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_marketplace_mappings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('product_id');
            $table->uuid('marketplace_store_id');
            
            $table->string('marketplace_product_id', 100);
            $table->string('marketplace_sku', 100);
            
            $table->string('marketplace_category', 255)->nullable();
            
            $table->decimal('price', 15, 4);
            $table->integer('stock_quantity');
            
            $table->boolean('is_active')->default(true);
            $table->dateTime('last_sync_at')->nullable();
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('marketplace_store_id')
                  ->references('id')
                  ->on('marketplace_stores')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_marketplace_mappings');
    }
};
