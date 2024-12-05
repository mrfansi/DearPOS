<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_adjustments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('tax_return_id');
            
            $table->enum('adjustment_type', ['credit', 'debit']);
            $table->decimal('amount', 15, 4);
            
            $table->text('reason')->nullable();
            $table->string('reference_number', 100)->nullable();
            
            $table->date('adjustment_date');
            
            $table->foreign('tax_return_id')
                  ->references('id')
                  ->on('tax_returns')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_adjustments');
    }
};
