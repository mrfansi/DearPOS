<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('supplier_id');
            
            $table->string('address_type', 50);
            $table->string('street_address', 255);
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country', 100);
            
            $table->boolean('is_primary')->default(false);
            
            $table->text('notes')->nullable();
            
            $table->foreign('supplier_id')
                  ->references('id')
                  ->on('suppliers')
                  ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('supplier_addresses');
    }
};
