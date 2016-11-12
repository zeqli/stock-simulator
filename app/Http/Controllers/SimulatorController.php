<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockSymbol;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Mylibrary\YahooStock;

class SimulatorController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    // Profile Section
    public function profile_index(){
        $user = Auth::user();       

        return view('profile.profile', ['user' => $user]);
        
    }

    // Portfolio Section
    public function portfolio_index(){
        return view('portfolio.portf');
    }

    public function portfolio_history(){
        return view('portfolio.portf_history');
    }

    // Trade Section
    public function trade_index(){
        return view('trade.tradestock');
    }

    public function trade_open(){
        return view('trade.showopentrade');
    }

    public function trade_fail(){
        return view('trade.showfailtrade');
    }


    // Market Section
    public function markets_index(){
        return view('markets.markets');
    }

    public function markets_watchlist(){
        return view('markets.watchlist');
    }

    public function markets_search(Request $request){
        $symbol = strtolower($request->input('symbol'));


        // If symbol field is empty, or the symbol is present in our database 
        // then redirect the user to symbol no found page
        
        
        // If symbol field is not empty and the symbol is found on database, then redirect the user to quote page
        try{
            $result = StockSymbol::where('symbol', $symbol)->firstOrFail();
        } catch(ModelNotFoundException $e){
            $url = route('notfound').'?symbol='.$symbol;
            return redirect($url);
        }

        return redirect()->route('stocks', ['symbol' => $symbol]);
    }

    public function markets_stocks_symbol(StockSymbol $symbol){
        $objYahooStock = new YahooStock;    

        $objYahooStock->addFormat("snl1t1d1cvp"); 
        $objYahooStock->addStock($symbol->symbol);
        $result = $objYahooStock->getQuotes();

        return view('markets.stocks', ['symbol_e_obj' => $symbol, 
            'stock' => $result[$symbol->symbol]]);
    }

    public function markets_symbol_not_found(){
        return view('markets.symbolnotfound');
    }
}
