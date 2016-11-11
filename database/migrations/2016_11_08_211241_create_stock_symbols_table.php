<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockSymbolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_symbols', function (Blueprint $table) {
            $table->string('symbol');
            $table->string('name');
            $table->string('ipo_year');
            $table->string('sector');
            $table->string('industry');
            $table->primary('symbol');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stock_symbols');
    }
}
