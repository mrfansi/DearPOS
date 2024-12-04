<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('inventory_audit_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('product_id');
            $table->uuid('warehouse_id');
            $table->date('audit_date');
            $table->decimal('system_quantity', 15, 4);
            $table->decimal('physical_quantity', 15, 4);
            $table->decimal('difference', 15, 4);
            $table->enum('status', ['pending', 'reconciled', 'discrepancy'])->default('pending');
            $table->text('notes')->nullable();
            $table->uuid('audited_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('audited_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('inventory_audit_logs');
    }
};
