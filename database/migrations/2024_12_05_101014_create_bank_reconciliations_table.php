<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_reconciliations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('account_id');
            $table->date('statement_date');
            $table->decimal('statement_balance', 15, 2);
            $table->decimal('book_balance', 15, 2);
            $table->decimal('difference', 15, 2);
            $table->string('status')->default('draft');
            $table->text('notes')->nullable();
            $table->uuid('reconciled_by')->nullable();
            $table->timestamp('reconciled_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_id')
                ->references('id')
                ->on('chart_of_accounts')
                ->onDelete('restrict');

            $table->foreign('reconciled_by')
                ->references('id')
                ->on('employees')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_reconciliations');
    }
};
