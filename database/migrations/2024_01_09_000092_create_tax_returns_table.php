<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('tax_period_id');
            
            $table->string('return_number', 50)->unique();
            
            $table->date('filing_date');
            $table->date('due_date');
            
            $table->decimal('total_sales', 15, 4);
            $table->decimal('total_tax_collected', 15, 4);
            $table->decimal('total_tax_paid', 15, 4);
            $table->decimal('net_tax', 15, 4);
            
            $table->enum('status', ['draft', 'filed', 'paid'])->default('draft');
            
            $table->text('notes')->nullable();
            
            $table->foreign('tax_period_id')
                  ->references('id')
                  ->on('tax_periods')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_returns');
    }
};
