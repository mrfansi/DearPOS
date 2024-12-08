<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('order_number', 50)->unique();
            $table->uuid('supplier_id');
            $table->uuid('warehouse_id');
            $table->foreignId('currency_id')->constrained('currencies');
            $table->enum('status', ['draft', 'pending', 'approved', 'received', 'cancelled']);
            $table->date('order_date');
            $table->date('expected_date')->nullable();
            $table->decimal('total_amount', 15, 4);
            $table->decimal('tax_amount', 15, 4);
            $table->decimal('discount_amount', 15, 4);
            $table->decimal('shipping_amount', 15, 4);
            $table->decimal('grand_total', 15, 4);
            $table->text('notes')->nullable();
            $table->uuid('created_by');
            $table->uuid('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('approved_by')->references('id')->on('users');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
}
