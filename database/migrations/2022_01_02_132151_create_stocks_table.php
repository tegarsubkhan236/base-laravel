<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('code', 10);
            $table->string('name', 50);
            $table->string('sector', 50);
            $table->string('subSector', 100)->nullable();
            $table->text('summary');
            $table->string('avatar', 100)->nullable();
            $table->bigInteger('netIncome');
            $table->float('profitMargin', 10, 0);
            $table->float('operationMargin', 10, 0);
            $table->float('returnOnAsset', 10, 0);
            $table->float('returnOnEquity', 10, 0);
            $table->bigInteger('marketCap');
            $table->bigInteger('outstandingShare');
            $table->integer('actualPrice');
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();
            $table->integer('created_by')->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stocks');
    }
}
