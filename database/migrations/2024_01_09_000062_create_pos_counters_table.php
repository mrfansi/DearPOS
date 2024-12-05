<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pos_counters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            
            $table->uuid('company_id');
            $table->uuid('location_id')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_counters');
    }
};
