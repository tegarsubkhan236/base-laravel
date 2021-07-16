<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sell_transaction_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('transaction_id')->index('transaction_id');
            $table->integer('stock_id')->index('stock_id');
            $table->integer('qty');
            $table->date('created_at')->nullable();
            $table->date('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sell_transaction_details');
    }
}
