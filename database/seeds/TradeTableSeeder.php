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
            'symbol' => 'GOOG',
            'buy_sell' => 'buy',
            'price' => '760.99',
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'quantity' => '10',
            'commission' => '4.99',
            'total_value' => '7614.89',
            'status' => 'done',
            'account_value' => '1000000'
        ]);
        DB::table('trade')->insert([
            'U_id' => '1',
            'symbol' => 'GOOG',
            'buy_sell' => 'buy',
            'price' => '760.99',
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'quantity' => '30',
            'commission' => '4.99',
            'total_value' => '22834.69',
            'status' => 'done',
            'account_value' => '1000001'
        ]);
        DB::table('trade')->insert([
            'U_id' => '1',
            'symbol' => 'AAPL',
            'buy_sell' => 'buy',
            'price' => '111.22',
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'quantity' => '30',
            'commission' => '4.99',
            'total_value' => '3341.59',
            'status' => 'done',
            'account_value' => '1000001'
        ]);
        DB::table('trade')->insert([
            'U_id' => '1',
            'symbol' => 'AAPL',
            'buy_sell' => 'buy',
            'price' => '111.22',
            'time' => Carbon::now()->format('Y-m-d H:i:s'),
            'quantity' => '50',
            'commission' => '4.99',
            'total_value' => '5565.99',
            'status' => 'done',
            'account_value' => '1000001'
        ]);
        factory(App\trade::class, 300)->create();
    }
}
