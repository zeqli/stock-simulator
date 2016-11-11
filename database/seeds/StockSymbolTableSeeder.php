<?php

use Illuminate\Database\Seeder;

class StockSymbolTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // truncate the entire table and reset the auto-incrementing ID to zero.
        DB::table('stock_symbols')->truncate();
        
        $added = array();
        $this->seed_from_csv('companylist_NASDAQ.csv', $added);
        $this->seed_from_csv('companylist_NYSE.csv', $added);
        $this->seed_from_csv('companylist_AMEX.csv', $added);
    }

    /**
     * Populate stock_symbols table with csv files.
     *
     * @return void
     */
    private function seed_from_csv($file, &$added = null){
        
        $file = resource_path($file); 

        $csv = array_map('str_getcsv', file($file));
        $header = array_shift($csv); // shift an element off the beginning of array, remove column header 
        array_walk($csv, function(&$a) use ($csv, $header, &$added) {    
            // 'use' construct. Inheriting variables from the parent scope
            $a = array_combine($header, $a);
            unset($a['LastSale']);
            unset($a['MarketCap']);
            unset($a['Summary Quote']);
            unset($a['']);  // Delete tailing empty key value pair

            // Insert into database
            if(!array_key_exists($a['Symbol'], $added)){
                $added[$a['Symbol']] = 1;
                DB::table('stock_symbols')->insert([
                    'symbol' => $a['Symbol'],
                    'name' => $a['Name'],
                    'ipo_year' => $a['IPOyear'],
                    'sector' => $a['Sector'],
                    'industry' => $a['industry']
                ]);
            }
        });        
    }
}
