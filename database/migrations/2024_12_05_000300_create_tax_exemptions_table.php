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
            $table->uuid('tax_rate_id');
            $table->string('entity_type', 100);
            $table->uuid('entity_id');
            $table->text('reason')->nullable();
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tax_rate_id')->references('id')->on('tax_rates');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tax_exemptions');
    }
};
