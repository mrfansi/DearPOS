<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('table_transfers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('from_table_id');
            $table->uuid('to_table_id');
            $table->uuid('reservation_id')->nullable();
            
            $table->text('transfer_reason')->nullable();
            $table->uuid('transferred_by');
            
            $table->foreign('from_table_id')
                  ->references('id')
                  ->on('tables')
                  ->onDelete('restrict');
            
            $table->foreign('to_table_id')
                  ->references('id')
                  ->on('tables')
                  ->onDelete('restrict');
            
            $table->foreign('reservation_id')
                  ->references('id')
                  ->on('reservations')
                  ->onDelete('set null');
            
            $table->foreign('transferred_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('table_transfers');
    }
};
