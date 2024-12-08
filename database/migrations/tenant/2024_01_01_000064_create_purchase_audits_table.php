<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseAuditsTable extends Migration
{
    public function up()
    {
        Schema::create('purchase_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('auditable_type', 100);
            $table->uuid('auditable_id');
            $table->enum('event', ['created', 'updated', 'deleted', 'status_changed']);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->uuid('user_id');

            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_audits');
    }
}
