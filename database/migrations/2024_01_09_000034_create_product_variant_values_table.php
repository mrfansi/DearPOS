<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_variant_values', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('variant_id');
            $table->uuid('attribute_id');
            
            $table->string('value', 100);
            
            $table->foreign('variant_id')
                  ->references('id')
                  ->on('product_variants')
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
        Schema::dropIfExists('product_variant_values');
    }
};
