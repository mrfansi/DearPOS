<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketplace_stores', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('platform_id');
            
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->string('store_id', 100);
            
            $table->json('config')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->dateTime('last_sync_at')->nullable();
            
            $table->foreign('platform_id')
                  ->references('id')
                  ->on('marketplace_platforms')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketplace_stores');
    }
};
