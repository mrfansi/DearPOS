<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('queue_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('queue_id');
            $table->uuid('product_id');
            $table->uuid('variant_id')->nullable();
            
            $table->decimal('quantity', 15, 4);
            $table->uuid('unit_id');
            
            $table->text('notes')->nullable();
            
            $table->foreign('queue_id')
                  ->references('id')
                  ->on('queue_managements')
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
        Schema::dropIfExists('queue_items');
    }
};
