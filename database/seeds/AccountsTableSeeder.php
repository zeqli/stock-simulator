<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        // truncate the entire table and reset the auto-incrementing ID to zero.
        #DB::table('accounts')->truncate();
        DB::table('accounts')->insert([
            'name' => 'admin',
            'email' => 'support@admin.com',
            'password' => bcrypt('secret'),
            // 'remember_token' => str_random(10),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'amount' => '100000000'
        ]);
        factory(App\Account::class, 50)->create();
    }
}
