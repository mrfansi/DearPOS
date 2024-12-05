<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_return_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('tax_return_id');
            $table->uuid('tax_category_id');
            $table->uuid('tax_rate_id');
            
            $table->decimal('taxable_amount', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            
            $table->foreign('tax_return_id')
                  ->references('id')
                  ->on('tax_returns')
                  ->onDelete('cascade');
            
            $table->foreign('tax_category_id')
                  ->references('id')
                  ->on('tax_categories')
                  ->onDelete('restrict');
            
            $table->foreign('tax_rate_id')
                  ->references('id')
                  ->on('tax_rates')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_return_details');
    }
};
