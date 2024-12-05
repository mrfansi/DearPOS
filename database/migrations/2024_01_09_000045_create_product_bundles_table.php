<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_bundles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('bundle_product_id');
            $table->uuid('included_product_id');
            $table->decimal('quantity', 15, 4)->default(1);
            $table->boolean('is_optional')->default(false);
            
            $table->foreign('bundle_product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');
            
            $table->foreign('included_product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_bundles');
    }
};
