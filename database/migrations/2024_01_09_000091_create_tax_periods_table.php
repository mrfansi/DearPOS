<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tax_periods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('name', 100);
            
            $table->date('start_date');
            $table->date('end_date');
            
            $table->enum('status', ['open', 'closed'])->default('open');
            
            $table->text('notes')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_periods');
    }
};
