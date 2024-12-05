<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('variant_attributes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('product_id');
            $table->uuid('attribute_id');
            
            $table->boolean('is_required')->default(false);
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('attribute_id')
                  ->references('id')
                  ->on('product_attributes')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('variant_attributes');
    }
};
