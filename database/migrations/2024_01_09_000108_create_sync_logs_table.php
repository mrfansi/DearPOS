<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('marketplace_store_id');
            
            $table->enum('sync_type', ['product', 'order', 'inventory', 'price']);
            $table->enum('status', ['success', 'failed']);
            
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            
            $table->integer('total_records')->default(0);
            $table->integer('success_records')->default(0);
            $table->integer('failed_records')->default(0);
            
            $table->text('error_message')->nullable();
            
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
        Schema::dropIfExists('sync_logs');
    }
};
