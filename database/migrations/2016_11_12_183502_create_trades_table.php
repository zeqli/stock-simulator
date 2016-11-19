<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('trade', function(Blueprint $table){
            $table->increments('t_id');
            $table->integer('U_id')->unsigned();
            $table->string('symbol');
            $table->string('buy_sell');
            $table->string('price');
            $table->dateTime('time');
            $table->string('quantity');
            $table->string('status');
            
        });

        Schema::table('trade',function($table){
            $table->foreign('U_id')->references('id')->on('accounts');
            });
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('trade');
    }
}
