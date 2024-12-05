<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pos_layouts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('name', 100);
            $table->text('description')->nullable();
            
            $table->json('layout_data');
            
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_layouts');
    }
};
