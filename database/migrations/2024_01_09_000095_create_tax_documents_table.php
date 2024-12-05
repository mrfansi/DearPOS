<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('tax_return_id');
            
            $table->string('document_type', 50);
            $table->string('document_number', 100)->nullable();
            
            $table->date('issue_date');
            $table->string('file_path', 255);
            
            $table->text('notes')->nullable();
            
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
        Schema::dropIfExists('tax_documents');
    }
};
