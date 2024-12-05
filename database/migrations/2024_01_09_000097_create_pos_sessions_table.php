<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pos_sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('terminal_id');
            $table->uuid('employee_id');
            
            $table->dateTime('opening_time');
            $table->dateTime('closing_time')->nullable();
            
            $table->decimal('opening_amount', 15, 4);
            $table->decimal('expected_amount', 15, 4);
            $table->decimal('actual_amount', 15, 4)->nullable();
            $table->decimal('difference_amount', 15, 4)->nullable();
            
            $table->enum('status', ['open', 'closed']);
            
            $table->text('notes')->nullable();
            
            $table->foreign('terminal_id')
                  ->references('id')
                  ->on('pos_terminals')
                  ->onDelete('restrict');
            
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
        Schema::dropIfExists('pos_sessions');
    }
};
