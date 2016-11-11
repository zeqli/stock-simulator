<?php

Route::get('/', function(){
    return view('index');
});


// Simulator
// localhost/simulator/
Route::group(['prefix' => 'simulator'], function(){
    
    // Profile
    Route::get('home','SimulatorController@profile_index')->name('profile');
    Route::get('/', function(){
        return redirect()->route('profile');
    });
    
    // Portfolio
    Route::group(['prefix' => 'portfolio'], function(){
        Route::get('/', 'SimulatorController@portfolio_index')->name('portfolio');
        Route::get('trade', 'SimulatorController@portfolio_history')->name('tradehistory');
    });

    // Trade
    Route::group(['prefix' => 'trade'], function(){
        Route::get('tradestock', 'SimulatorController@trade_index')->name('tradestock');
        Route::get('/', function(){
            return redirect()->route('tradestock');
        });
        Route::get('showopentrades', 'SimulatorController@trade_open')->name('opentrades');
        Route::get('showfailtrades', 'SimulatorController@trade_fail')->name('failtrades');
    });

    // Market
    Route::group(['prefix' => 'markets'], function(){
        Route::get('/', 'SimulatorController@markets_index')->name('markets');
        Route::get('watchlist', 'SimulatorController@markets_watchlist')->name('watchlist');
        Route::match(['POST', 'GET'], 'search', 'SimulatorController@markets_search')->name('search'); 
        Route::get('stocks/{symbol}', 'SimulatorController@markets_stocks_symbol')->name('stocks');
        Route::get('symbolnotfound/', 'SimulatorController@markets_symbol_not_found')->name('notfound');   
    });
});


// Routes Partial
// foreach (File::allFiles(__DIR__.'/routes') as $partial) {
//     require_once $partial->getPathName();
// }


// Implicit Route Binding
// If optional parameter is not primary key, we will override boot function in RouteServiceProvider.php
// Route::get('users/{user}', function(APP\User $user)){
//     return $user;
// }
Auth::routes();
