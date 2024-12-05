<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->string('name', 100);
            $table->string('code', 50)->unique();
            
            $table->enum('type', ['cash', 'card', 'bank_transfer', 'digital_wallet', 'other']);
            
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payment_methods');
    }
};
