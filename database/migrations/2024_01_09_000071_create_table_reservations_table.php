<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('table_reservations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('reservation_id');
            $table->uuid('table_id');
            
            $table->string('status', 20);
            
            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
                  ->onDelete('cascade');
            
            $table->foreign('table_id')
                  ->references('id')
                  ->on('tables')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_reservations');
    }
};
