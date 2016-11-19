<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockSymbol;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $objYahooStock = new YahooStock;
        $user = Auth::user();
        $query = DB::table('accounts')->where('accounts.id','=',$user->id)
                                      ->join('trade','accounts.id','=','trade.U_id')
                                      ->join('hold','accounts.id','=','hold.U_id')
                                      ->select('buy_sell','hold.symbol as symbol','hold.quantity as quantity','trade.price as price')
                                      ->get();

        $hold_arr = $query->toArray();

        $objYahooStock->addFormat("snl1t1d1cvp");
        foreach ($hold_arr as $hold) {
            $objYahooStock->addStock($hold->symbol);
        }

        $result = $objYahooStock->getQuotes();

        $hold_entries = array();
        foreach ($hold_arr as $hold) {
            $symbol = $hold->symbol;
            
            $hold_entries[] = ['buy_sell' =>$hold->buy_sell,
                            'symbol' => $symbol, 
                            'quantity' => $hold->quantity, 
                            'price' => $hold->price,
                            'lasttrade' => $result[$symbol][2], 
                            ];
        }

        return view('portfolio.portf', ['query' => $hold_entries]);

        
    }

    public function portfolio_history(){
        $user = Auth::user();  
        $query = DB::table('accounts')->where('accounts.id','=',$user->id)->join('trade','accounts.id','=','trade.U_id')->select('time','buy_sell','symbol','quantity','price','amount')->where('trade.status','=','done')->get();

        $query = $query->toArray();



        return view('portfolio.portf_history', ['query' => $query]);
      
    }

    // Trade Section
    public function trade_index(){
        $user = Auth::user();  
        return view('trade.tradestock',['user' => $user]);
    }

    public function trade_open(){
        $user = Auth::user();
        $trades = DB::table('trade')->where('U_id', $user->id)->where('status', 'pending')->get();

//        $message = "";
//        return view('trade.showopentrade', compact('trades','message'));
        return view('trade.showopentrade', compact('trades'));
    }

    public function trade_fail(){
        $user = Auth::user();
        $failtrades = DB::table('trade')->where('U_id', $user->id)->where('status', 'fail')->get();
        return view('trade.showfailtrade',  compact('failtrades'));
    }

    public function trade_cancel($tid){
        $user = Auth::user();
        $trades = DB::table('trade')->where('U_id', $user->id)->where('t_id', $tid)->update(['status' => 'fail']);
        return redirect('simulator/trade/showopentrades')->with('message', $tid);
    }

    // Market Section
    public function markets_index(){
        $user = Auth::user();  
        return view('markets.markets',['user' => $user]);
    }

    public function markets_watchlist(){

        $objYahooStock = new YahooStock;    



        $user = Auth::user();  

        // Query user watchlist table
        $query = DB::table('accounts')->where('accounts.id','=',$user->id)
                                      ->join('watchlist','accounts.id','=','watchlist.U_id')
                                      ->join('stock_symbols','watchlist.symbol','=','stock_symbols.symbol')
                                      ->select('watchlist.symbol as symbol','stock_symbols.name as name')
                                      ->get();


        // watchlist array
        $wl_arr = $query->toArray();

        $objYahooStock->addFormat("snl1t1d1cvp");
        foreach ($wl_arr as $watchlist) {
            $objYahooStock->addStock($watchlist->symbol);
        }

        $result = $objYahooStock->getQuotes();

        $watchlist_entries = array();
        foreach ($wl_arr as $watchlist) {
            $symbol = $watchlist->symbol;
            $watchlist_entries[] = ['symbol' => $symbol, 'name' => $watchlist->name, 
                        'lasttrade' => $result[$symbol][2], 'change' => $result[$symbol][5]];
        }

        return view('markets.watchlist', ['query' => $watchlist_entries]);
                                               
        
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

    public function markets_add(Request $request){
        $user = Auth::user();
        $symbol = strtolower($request->input('symbol'));
        $insert = DB::table('watchlist')->insert(
            ['U_id' => $user->id,  'symbol' => $symbol]
            );

        return redirect()->route('watchlist');
                                               
    }
}
