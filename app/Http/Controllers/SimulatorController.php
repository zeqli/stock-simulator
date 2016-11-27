<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockSymbol;
use App\trade;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mylibrary\YahooStock;
use Carbon\Carbon;

class SimulatorController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    // Helper functions
    public function get_market_price($symbol){
        $objYahooStock = new YahooStock;    
        $objYahooStock->addFormat("l1");    // l1 - last trade price 
        $objYahooStock->addStock($symbol);
        $result = $objYahooStock->getQuotes();
        return $result[$symbol][0];
    }

    public function get_stocks_value($user_id){
        $query = DB::table('accounts')
                    ->where('accounts.id','=',$user_id)
                    ->join('hold','accounts.id','=','hold.U_id')
                    ->select('hold.symbol as symbol','hold.quantity as quantity')
                    ->distinct()
                    ->get();
        $hold_arr = $query->toArray();

        $stocks_with_qty = array();
        foreach ($hold_arr as $hold) {
            $key = $hold->symbol;
            $val = $hold->quantity;
            $stocks_with_qty[$key] = $val;
        }
        $objYahooStock = new YahooStock; 
        return $objYahooStock->getTotalValue($stocks_with_qty);
    }

    public function get_account_value(){
        $user = Auth::user();
        return $this->get_stocks_value($user->id) + $user->amount;
    }

    /**
    * Calculate adjusted purchase price by weighted average.
    * 
    * 
    * 
    */
    public function get_adjusted_purchase($U_id, $symbol){
        $query = DB::table('accounts')
                    ->where('accounts.id','=',$U_id)
                    ->join('trade','accounts.id','=','trade.U_id')
                    ->where('trade.symbol', '=', $symbol)
                    ->where('trade.status','=','done')
                    ->select('trade.quantity as qty', 'trade.buy_sell as bs', 'trade.price as price')
                    ->distinct()
                    ->get();
        $trade_history = $query->toArray();

        $total_amount = 0;
        $total_qty = 0;
        $modifier = 1;
        foreach ($trade_history as $trade) {
            $modifier = $trade->bs === 'buy' ? 1 : -1;
            $total_amount +=  $modifier * $trade->price * $trade->qty;   
            $total_qty += $modifier * $trade->qty;
        }
        return $total_qty === 0 ? 0 : $total_amount / $total_qty;   
    }

    // Profile Section
    public function profile_index(){
        $user = Auth::user();       
        return view('profile.profile', ['user' => $user, 'account_value' => $this->get_account_value()]);
        
    }

    
    /**
    * +-----------------------------------------+
    * |               PORTFOLIO                 |
    * +-----------------------------------------+
    *  
    * The 'Stock Portfolio' table will display the following table
    * +--------------------------------------------------------------------------------------------------------------+
    * | SYMBOL | DESCRIPTION | QTY | PURCHASE PRICE | CURRENT PRICE | TOTAL VALUE | TODAY'S CHANGE | TOTAL GAIN/LOSS |
    * +--------------------------------------------------------------------------------------------------------------+
    * 
    */
    public function portfolio_index(){
        $user = Auth::user();
        $query = DB::table('accounts')
                    ->where('accounts.id','=',$user->id)
                    ->join('hold','accounts.id','=','hold.U_id')
                    ->join('stock_symbols','hold.symbol','=','stock_symbols.symbol')
                    ->select('hold.symbol as symbol','hold.quantity as qty', 'stock_symbols.name as name')
                    ->distinct()
                    ->get();
        $hold_arr = $query->toArray();       

        $objYahooStock = new YahooStock;
        $objYahooStock->addFormat("l1c"); // 0 - last trade price only, 1 - today's change
        foreach ($hold_arr as $hold) {
            $objYahooStock->addStock($hold->symbol);
        }
        $result = $objYahooStock->getQuotes();

        $hold_entries = array();
        foreach ($hold_arr as $hold) {
            $symbol = $hold->symbol;                
            $description = $hold->name;
            $qty = $hold->qty;
            $adjusted_purchase_price = $this->get_adjusted_purchase($user->id, $symbol);
            $current_price = $result[$symbol][0];
            $total_value = $qty * $current_price;
            $today_change = $result[$symbol][1];
            $total_gainloss = $qty * ( $current_price - $adjusted_purchase_price );
            $total_gainloss_percent = $total_gainloss / ($adjusted_purchase_price * $qty);

            $hold_entries[] = [
                'symbol' => $symbol, 
                'description' => $description,
                'qty' => $qty, 
                'purchaseprice' => '$'.number_format($adjusted_purchase_price, 2),
                'currentprice' => '$'.number_format($current_price, 2),
                'totalvalue' => '$'.number_format($total_value, 2), 
                'change' => $today_change,
                'totalgainloss' => preg_replace('/^(-?)(.*)$/', '$1\$$2', number_format($total_gainloss, 2)),
                'totalgainlosspercent' => round($total_gainloss_percent * 100, 2)."%"
            ];
        }
        return view('portfolio.portf', [
                'query' => $hold_entries, 
                'acctval' => '$'.number_format($this->get_stocks_value($user->id) + $user->amount, 2), 
                'cash' => '$'.number_format($user->amount, 2)
        ]);

        
    }

    public function portfolio_history(){
        $user = Auth::user();  
        $trade_history = DB::table('trade')
                    ->select('time','buy_sell','symbol','quantity','price',
                        'account_value','commission','total_value')
                    ->where('trade.U_id','=',$user->id)
                    ->where('trade.status','=','done')
                    ->get()
                    ->toArray();

        return view('portfolio.portf_history', compact('trade_history'));
      
    }

    /**
    * +-----------------------------------------+
    * |             TRADE STOCK                 |
    * +-----------------------------------------+
    */
    public function trade_index(Request $request){
        $user = Auth::user();  

        $open_time = Carbon::createFromTime(9,30,0);
        $close_time = Carbon::createFromTime(16,30,0);
        $now = Carbon::now();
        if($now->between($open_time, $close_time) && $now->isWeekday()){
            $request->session()->forget('close');
        }
        else{
            $request->session()->put('close', 1);
        }

        return view('trade.tradestock',compact('user'));
    }

    public function trade_open(){
        $user = Auth::user();
        $trades = DB::table('trade')
                    ->where('U_id', $user->id)
                    ->where('status', 'pending')
                    ->get();
//        $message = "";
//        return view('trade.showopentrade', compact('trades','message'));
        return view('trade.showopentrade', compact('trades'));
    }

    public function trade_fail(){
        $user = Auth::user();
        $failtrades = DB::table('trade')
                        ->where('U_id', $user->id)
                        ->where('status', 'fail')
                        ->get();
        return view('trade.showfailtrade',  compact('failtrades'));
    }


	public function trade_cancel($tid){
        $user = Auth::user();
        $trade = trade::findOrFail($tid);
        $trade->status = 'Cancelled by User';
        $trade->save();
        // DB::table('trade')
        //     ->where('t_id', $tid)
        //     ->update(['status' => 'fail']);

        return redirect('simulator/trade/showopentrades')->with('message', $tid);
    }

    public function trade_preview(Request $request){
        $user = Auth::user();
        define('COMMISSION', 4.99);
        $duration = $request->input('do');
        $symbol = strtolower($request->input('sym'));
        $trans = $request->input('trans'); 
        $qty = $request->input('qty');
        $result = StockSymbol::where('symbol', $symbol)->first();
        $cash = $user->amount;

        // If symbol field is empty, or the symbol is present in our database
        // then redirect the user to symbol no found page
        if($result === null){
            return back()->withInput()->with('symbol', $symbol);
        }


        // Check if the quantity is valid
        
        $hold_shares = DB::table('hold')
                    ->select('quantity')
                    ->where([
                        ['U_id', '=', $user->id],
                        ['symbol', '=', $symbol],
                      ])
                    ->get();

        if(!ctype_digit($qty) || intval($qty) > 999999  || intval($qty) < 1){
            return back()->withInput()->with('quantity', 1);
        }


        // Two validations: 
        // 1. If user is selling some shares of stocks, the selling qty must not exceed the holding amount
        if($trans === 'sell' && (!count($hold_shares) || $hold_shares->first()->quantity < intval($qty)) ){
            return back()->withInput()->with('sell-error', 1);
        }

        // Get market price
        $market_price = $this->get_market_price($symbol);
        // Get total price
        $total = $trans === 'buy' ? $market_price * $qty + COMMISSION : $market_price * $qty - COMMISSION;
        // Calculate total value
        $value = $this->get_account_value();

        // 2. if user is buying some shares of stock, the cost must smaller than cash in accounts. 
        if ($cash < $total) {
            return back()->withInput()->with('buy-error', 1)->with('maxposit', '$'.number_format($cash,2));
        }

        $trade_data = ['symbol' => $symbol,
            'trans' => $trans,
            'stlmt' => 'n/a',
            'duration' => $duration,
            'price' => $market_price,
            'quantity' => $qty,
            'commission' => COMMISSION,
            'total' => $total,
            'value' => $value,
            'bpwr' => $cash,
            'cash' => $cash,
        ];

        // Detect market open or close
        $open_time = Carbon::createFromTime(9,30,0);
        $close_time = Carbon::createFromTime(16,30,0);
        $now = Carbon::now();
        if($now->between($open_time, $close_time) && $now->isWeekday()){
            $request->session()->forget('close');
        }
        else{
            $request->session()->put('close', 1);
        }

        // Flash session for submit order
        $request->session()->flash('trade_request', $trade_data);

        // If symbol field is not empty and the symbol is found on database, then redirect the user to quote page
        return view('trade.tradepreview', $trade_data);
    }

    public function trade_confirm(Request $request){
        if($request->session()->has('trade_request')){
            $user = Auth::user();
            $trade_request = session()->get('trade_request');
            
            // If transaction has been made, when we refresh page, it won't touch database.
            if($request->session()->has('success')){
                $request->session()->reflash();
                return view('trade.tradeconfirm', ['buy_sell' => $trade_request['trans'], 
                                               'symbol' => $trade_request['symbol']]);
            }
            
            $open_time = Carbon::createFromTime(9,30,0);
            $close_time = Carbon::createFromTime(16,30,0);
            $now = Carbon::now();
            // Make change of database table
            /**
             * 1. Get user id
             * 2. Create trade model object
             * 3. Insert transaction
             *
             */     

            $transaction = new trade;
            $transaction->U_id = $user->id;
            $transaction->symbol = $trade_request['symbol'];
            $transaction->buy_sell = $trade_request['trans'];
            $transaction->price = $trade_request['price'];
            $transaction->time = $now->toDateTimeString();
            $transaction->quantity = $trade_request['quantity'];
            $transaction->commission = $trade_request['commission'];
            $transaction->total_value = $trade_request['total'];
            $transaction->status = $now->between($open_time, $close_time) && $now->isWeekday() ? 'done' : 'pending';
            // $transaction->status = 'done';
                       

            if($transaction->status === 'done'){
                $hold = DB::table('hold')
                            ->where('U_id','=',$transaction->U_id)
                            ->where('symbol', '=', $transaction->symbol)
                            ->first();
                if ($hold === null) {
                    DB::table('hold')->insert([
                        'U_id' => $transaction->U_id, 'symbol' => $transaction->symbol, 'quantity' => '0'
                    ]);
                    $hold = DB::table('hold')
                            ->where('U_id','=',$transaction->U_id)
                            ->where('symbol', '=', $transaction->symbol)
                            ->first();
                }
                $qty = $hold->quantity;

                switch ($transaction->buy_sell) {
                    case 'buy':
                        DB::table('hold')
                            ->where('U_id','=',$transaction->U_id)
                            ->where('symbol', '=', $transaction->symbol)
                            ->update(['quantity' => $qty + $transaction->quantity]);

                        // Deduct total cost from user's buying power
                        DB::table('accounts')
                            ->where('id','=',$user->id)
                            ->update(['amount' => $user->amount - $trade_request['total']]);
                        break;
                    case 'sell':
                        // Delete record if qty reaches zero
                        if($qty - $transaction->quantity <= 0){
                            DB::table('hold')
                                ->where('U_id','=',$transaction->U_id)
                                ->where('symbol', '=', $transaction->symbol)
                                ->delete();
                        }
                        else{
                            DB::table('hold')
                                ->where('U_id','=',$transaction->U_id)
                                ->where('symbol', '=', $transaction->symbol)
                                ->update(['quantity' => $qty - $transaction->quantity]);
                        }
                        // Add to user's buying power
                        DB::table('accounts')
                            ->where('id','=',$user->id)
                            ->update(['amount' => $user->amount + $trade_request['quantity'] * $trade_request['price']]);
                        break;
                    
                    default:
                        break;
                } 
            }

            $transaction->account_value = $this->get_account_value();
            $transaction->save(); 

            $request->session()->reflash();
            $request->session()->flash('success', 1);

            // Get result
            return view('trade.tradeconfirm', ['buy_sell' => $trade_request['trans'], 
                                               'symbol' => $trade_request['symbol']]);
        }
        else{
            return redirect()->route('tradestock');
        }
    }


    /**
    * +-----------------------------------------+
    * |                 MARKET                  |
    * +-----------------------------------------+
    */
    public function markets_index(){
        $user = Auth::user();  
        return view('markets.markets',['user' => $user]);
    }

    public function markets_watchlist(){

        $objYahooStock = new YahooStock;    



        $user = Auth::user();  

        // Query user watchlist table
        $query = DB::table('accounts')
                    ->where('accounts.id','=',$user->id)
                    ->join('watchlist','accounts.id','=','watchlist.U_id')
                    ->join('stock_symbols','watchlist.symbol','=','stock_symbols.symbol')
                    ->select('watchlist.symbol as symbol','stock_symbols.name as name')
                    ->get();

        // watchlist array
        $watchlist_arr = $query->toArray();

        $objYahooStock->addFormat("snl1t1d1cvp");
        foreach ($watchlist_arr as $watchlist) {
            $objYahooStock->addStock($watchlist->symbol);
        }

        $result = $objYahooStock->getQuotes();

        $watchlist_data = array();
        foreach ($watchlist_arr as $watchlist) {
            $symbol = $watchlist->symbol;
            $watchlist_data[] = [
                'symbol' => $symbol, 
                'name' => $watchlist->name, 
                'lasttrade' => $result[$symbol][2], 
                'change' => $result[$symbol][5]
            ];
        }

        return view('markets.watchlist', ['query' => $watchlist_data]);
                                               
        
    }

    public function markets_search(Request $request){
        $symbol = strtolower($request->input('symbol'));
        $result = StockSymbol::where('symbol', $symbol)->first();

        // If symbol field is empty, or the symbol is present in our database 
        // then redirect the user to symbol no found page
        if($result === null){
            $url = route('notfound').'?symbol='.$symbol;
            return redirect($url);
        }
        
        // If symbol field is not empty and the symbol is found on database, then redirect the user to quote page
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
