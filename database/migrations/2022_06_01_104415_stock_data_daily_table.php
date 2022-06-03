<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_data_daily', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_ticker_id')
                ->nullable()
                ->references('id')
                ->on('stock_tickers')
                ->onDelete('SET NULL')
                ->onUpdate('CASCADE');
            $table->dateTime('time');
            $table->float('open');
            $table->float('high');
            $table->float('low');
            $table->float('close');
            $table->bigInteger('volume');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_data_daily');
    }
};
