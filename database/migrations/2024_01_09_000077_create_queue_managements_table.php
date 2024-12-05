<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('queue_managements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('queue_number', 50)->unique();
            
            $table->uuid('customer_id')->nullable();
            $table->uuid('section_id');
            
            $table->string('status', 20);
            $table->integer('total_guests')->default(1);
            
            $table->text('notes')->nullable();
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('set null');
            
            $table->foreign('section_id')
                  ->references('id')
                  ->on('sections')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('queue_managements');
    }
};
