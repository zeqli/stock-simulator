<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hold', function(Blueprint $table){
            $table->integer('U_id')->unsigned();
            $table->string('symbol');
            $table->integer('quantity')->unsigned();
            $table->primary(['U_id','symbol']);
            
        });

        Schema::table('hold',function($table){
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
        Schema::dropIfExists('hold');
    }
}
