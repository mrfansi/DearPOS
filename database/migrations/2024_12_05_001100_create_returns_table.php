<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('purchase_order_id')->nullable();
            $table->uuid('sales_transaction_id')->nullable();
            $table->uuid('supplier_id')->nullable();
            $table->uuid('customer_id')->nullable();
            $table->string('return_number', 50)->unique();
            $table->date('return_date');
            $table->enum('type', ['purchase', 'sales'])->default('sales');
            $table->enum('status', ['draft', 'processed', 'completed', 'cancelled'])->default('draft');
            $table->decimal('total_amount', 15, 4);
            $table->text('reason')->nullable();
            $table->uuid('created_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders');
            $table->foreign('sales_transaction_id')->references('id')->on('sales_transactions');
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::dropIfExists('returns');
    }
};
