<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('sku', 50);
            $table->text('description')->nullable();
            $table->uuid('category_id');
            $table->uuid('base_currency_id');
            $table->uuid('base_unit_id');
            
            $table->boolean('is_managed_by_recipe')->default(false);
            $table->boolean('track_expiry')->default(false);
            $table->boolean('track_serial')->default(false);
            
            $table->foreign('category_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('restrict');
            
            $table->foreign('base_currency_id')
                  ->references('id')
                  ->on('currencies')
                  ->onDelete('restrict');
            
            $table->foreign('base_unit_id')
                  ->references('id')
                  ->on('units_of_measures')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
