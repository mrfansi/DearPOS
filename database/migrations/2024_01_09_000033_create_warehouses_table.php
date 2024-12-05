<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            $table->text('address')->nullable();
            $table->uuid('company_id');
            $table->boolean('is_active')->default(true);
            
            $table->foreign('company_id')
                  ->references('id')
                  ->on('companies')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
};
