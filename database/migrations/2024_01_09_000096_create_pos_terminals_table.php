<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pos_terminals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->uuid('branch_id');
            
            $table->string('code', 50)->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            
            $table->string('ip_address', 45)->nullable();
            $table->string('mac_address', 17)->nullable();
            
            $table->json('printer_config');
            $table->json('drawer_config');
            $table->json('display_config');
            $table->json('scanner_config');
            $table->json('scale_config');
            
            $table->boolean('is_active')->default(true);
            $table->dateTime('last_online_at')->nullable();
            
            $table->foreign('branch_id')
                  ->references('id')
                  ->on('branches')
                  ->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pos_terminals');
    }
};
