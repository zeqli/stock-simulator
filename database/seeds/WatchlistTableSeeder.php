<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class WatchlistTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        #DB::table('trade')->truncate();
        DB::table('watchlist')->insert([
            'U_id' => '1',
            'symbol' => 'NASDAQ',
            
        ]);
        factory(App\watchlist::class, 50)->create();
    }
}
