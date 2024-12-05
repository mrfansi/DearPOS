<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sync_queue', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('marketplace_store_id');
            
            $table->enum('sync_type', ['product', 'order', 'inventory', 'price']);
            $table->uuid('reference_id');
            
            $table->integer('priority')->default(0);
            $table->enum('status', ['pending', 'processing', 'completed', 'failed']);
            
            $table->integer('retry_count')->default(0);
            $table->text('last_error')->nullable();
            
            $table->dateTime('scheduled_at');
            $table->dateTime('processed_at')->nullable();
            
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
        Schema::dropIfExists('sync_queue');
    }
};
