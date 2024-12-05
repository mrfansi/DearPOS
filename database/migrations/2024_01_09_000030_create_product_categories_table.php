<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->text('description')->nullable();
            $table->uuid('parent_id')->nullable();
            
            // Self-referencing foreign key for parent category
            $table->foreign('parent_id')
                  ->references('id')
                  ->on('product_categories')
                  ->onDelete('set null');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_categories');
    }
};
