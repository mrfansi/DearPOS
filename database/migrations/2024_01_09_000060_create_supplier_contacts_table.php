<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('supplier_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('supplier_id');
            
            $table->string('first_name', 100);
            $table->string('last_name', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('mobile', 20)->nullable();
            
            $table->string('job_title', 100)->nullable();
            $table->string('department', 100)->nullable();
            
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
        Schema::dropIfExists('supplier_contacts');
    }
};
