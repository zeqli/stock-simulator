<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()    {
        $this->call(AccountsTableSeeder::class);
        $this->call(StockSymbolTableSeeder::class);
        $this->call(TradeTableSeeder::class);
        $this->call(WatchlistTableSeeder::class);
        $this->call(HoldTableSeeder::class);
    }
}
