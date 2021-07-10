<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBuyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buy_transactions', function (Blueprint $table) {
            $table->foreign('user_id', 'buy_transactions_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('supplier_id', 'buy_transactions_ibfk_2')->references('id')->on('suppliers')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buy_transactions', function (Blueprint $table) {
            $table->dropForeign('buy_transactions_ibfk_1');
            $table->dropForeign('buy_transactions_ibfk_2');
        });
    }
}
