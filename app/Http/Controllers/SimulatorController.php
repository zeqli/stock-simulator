<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


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
}
