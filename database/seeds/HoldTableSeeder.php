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
        DB::table('hold')->insert([
            'U_id' => '1',
            'symbol' => 'NASDAQ',
            'quantity' => '5'
            
        ]);
        factory(App\hold::class, 50)->create();
    
    }
}
