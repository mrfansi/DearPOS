<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('down_payment_configs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 100);
            $table->decimal('minimum_percentage', 5, 2);
            $table->decimal('maximum_percentage', 5, 2);
            $table->decimal('default_percentage', 5, 2);
            $table->boolean('is_mandatory')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('down_payment_configs');
    }
};
