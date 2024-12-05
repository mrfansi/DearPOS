<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_exemptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('customer_id');
            $table->uuid('tax_category_id');
            
            $table->string('exemption_number', 100)->nullable();
            
            $table->date('start_date');
            $table->date('end_date')->nullable();
            
            $table->text('reason')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            
            $table->foreign('customer_id')
                  ->references('id')
                  ->on('customers')
                  ->onDelete('cascade');
            
            $table->foreign('tax_category_id')
                  ->references('id')
                  ->on('tax_categories')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_exemptions');
    }
};
