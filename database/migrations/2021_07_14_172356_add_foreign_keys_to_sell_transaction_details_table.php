<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToSellTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sell_transaction_details', function (Blueprint $table) {
            $table->foreign('stock_id', 'sell_transaction_details_ibfk_1')->references('id')->on('master_stocks')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('transaction_id', 'sell_transaction_details_ibfk_2')->references('id')->on('sell_transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sell_transaction_details', function (Blueprint $table) {
            $table->dropForeign('sell_transaction_details_ibfk_1');
            $table->dropForeign('sell_transaction_details_ibfk_2');
        });
    }
}
