<?php

use Illuminate\Database\Seeder;

class HoldTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //
        #DB::table('trade')->truncate();
        // DB::table('hold')->insert([
        //     'U_id' => '1',
        //     'symbol' => 'GOOG',
        //     'quantity' => '5'
        // ]);
        // factory(App\hold::class, 50)->create();
    
        $query = DB::table('accounts')
                    ->join('trade', 'trade.U_id', '=','accounts.id')
                    ->select('accounts.id as U_id', 'trade.symbol as symbol', DB::raw('SUM(trade.quantity) as qty'))
                    ->where('trade.status', '=' ,'done')
                    ->groupBy('accounts.id', 'trade.symbol')
                    ->get();

        $hold_arr = $query->toArray();
        foreach ($hold_arr as $entry ) {
            $hold = new App\hold;
            $hold->U_id = $entry->U_id;
            $hold->symbol = $entry->symbol;
            $hold->quantity = $entry->qty;
            $hold->save();
        }
    }
}
