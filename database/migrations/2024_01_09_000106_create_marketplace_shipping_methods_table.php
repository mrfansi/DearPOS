<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketplace_shipping_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('marketplace_store_id');
            
            $table->string('shipping_method_id', 100);
            $table->string('name', 100);
            $table->string('code', 50);
            
            $table->boolean('is_active')->default(true);
            
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
        Schema::dropIfExists('marketplace_shipping_methods');
    }
};
