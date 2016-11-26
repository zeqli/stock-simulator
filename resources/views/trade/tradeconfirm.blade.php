@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('tradestock')}} "/>Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} "/>Open Trades</a></li>
    <li role="presentation" ><a href="{{ route('failtrades')}} "/>Fail Trades</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Trade Confirmation</h1>
    <div>
        <p>{{ ucfirst($buy_sell)}} Market Order for {{ strtoupper($symbol)}} received. Your order has been received by our system and it will be executed. </p>
    </div>
@stop