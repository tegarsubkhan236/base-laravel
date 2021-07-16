<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBuyTransactionDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_transaction_details', function (Blueprint $table) {
            $table->foreign('stock_id', 'buy_transaction_details_ibfk_1')->references('id')->on('supplier_stocks')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('transaction_id', 'buy_transaction_details_ibfk_2')->references('id')->on('buy_transactions')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buy_transaction_details', function (Blueprint $table) {
            $table->dropForeign('buy_transaction_details_ibfk_1');
            $table->dropForeign('buy_transaction_details_ibfk_2');
        });
    }
}
