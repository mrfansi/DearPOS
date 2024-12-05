<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('refund_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('refund_id');
            $table->uuid('return_item_id');
            
            $table->decimal('amount', 15, 4);
            
            $table->foreign('refund_id')
                  ->references('id')
                  ->on('refunds')
                  ->onDelete('cascade');
            
            $table->foreign('return_item_id')
                  ->references('id')
                  ->on('return_items')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('refund_items');
    }
};
