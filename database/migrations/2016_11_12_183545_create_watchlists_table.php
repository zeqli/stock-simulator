<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWatchlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('watchlist', function(Blueprint $table){
            $table->integer('U_id')->unsigned();
            $table->string('symbol');
            $table->primary(['U_id','symbol']);
            
        });

        Schema::table('watchlist',function($table){
            $table->foreign('U_id')->references('id')->on('accounts');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('watchlist');
    }
}
