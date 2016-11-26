<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Mylibrary\YahooStock;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
             ->see('Laravel');
    }

    public function testGetTotalValue(){
        $arr = ['GOOG' => '5'];
        $objYahooStock = new YahooStock; 
        $result = $objYahooStock->getTotalValue($arr);
        $expect = 5 * 760.99;
        $this->assertEquals($expect, $result, "Wrong result:" + $result);
    }
}
