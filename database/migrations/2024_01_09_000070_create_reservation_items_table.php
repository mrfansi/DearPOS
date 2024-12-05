<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('reservation_id');
            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            
            $table->decimal('unit_price', 15, 4);
            $table->text('notes')->nullable();
            
            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
                  ->onDelete('cascade');
            
            $table->foreign('product_id')
                  ->references('id')
                  ->on('products')
                  ->onDelete('restrict');
            
            $table->foreign('variant_id')
                  ->references('id')
                  ->on('product_variants')
                  ->onDelete('set null');
            
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
        Schema::dropIfExists('reservation_items');
    }
};
