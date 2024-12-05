<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cash_drawer_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('session_id');
            $table->uuid('employee_id');
            
            $table->enum('action', ['open', 'close']);
            $table->text('reason')->nullable();
            
            $table->foreign('session_id')
                  ->references('id')
                  ->on('pos_sessions')
                  ->onDelete('cascade');
            
            $table->foreign('employee_id')
                  ->references('id')
                  ->on('employees')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cash_drawer_logs');
    }
};
