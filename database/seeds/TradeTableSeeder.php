<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TradeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // truncate the entire table and reset the auto-incrementing ID to zero.
        #DB::table('trade')->truncate();
        DB::table('trade')->insert([
            'U_id' => '1',
            'symbol' => 'NASDAQ',
            'buy_sell' => 'buy',
            'price' => '100',
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'quantity' => '10',
            'status' => 'done'
        ]);
        factory(App\trade::class, 50)->create();
    }
}
