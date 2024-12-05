<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('supplier_id');
            $table->uuid('product_id');
            
            $table->string('supplier_product_code', 50)->nullable();
            $table->string('supplier_product_name', 100)->nullable();
            
            $table->decimal('unit_cost', 15, 4);
            $table->decimal('minimum_order_quantity', 15, 4)->default(1);
            $table->integer('lead_time_days')->default(0);
            
            $table->boolean('is_preferred')->default(false);
            $table->text('notes')->nullable();
            
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier_products');
    }
};
