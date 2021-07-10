<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToMasterStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master_stocks', function (Blueprint $table) {
            $table->foreign('item_id', 'master_stocks_ibfk_1')->references('id')->on('master_items')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master_stocks', function (Blueprint $table) {
            $table->dropForeign('master_stocks_ibfk_1');
        });
    }
}
