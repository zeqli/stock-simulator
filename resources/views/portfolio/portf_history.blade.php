@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" ><a href="{{ route('portfolio') }}">Portfolio</a></li>
    <li role="presentation" class="active"><a href="{{ route('tradehistory') }}">Trade History</a></li>
@stop

<style>
table {
    width: 100%;
}

td, th {
    border-left: 10px;
    margin:10px;
    text-align:center;
}
}
</style>
@section('page-header')
    <h1 class="page-header">Trade History</h1>
    <div>
    	<table>
    		<tr><th><td>Date</td><td>Trade Type</td><td>Stock Symbol</td><td>Quantity</td><td>Price</td><td>Account Value</td></th></tr>
            @for($i=0;$i<count($query);$i++)
                <tr><th><td>{{$query[$i]->time}}</td><td>{{$query[$i]->buy_sell}}</td><td>{{$query[$i]->symbol}}</td><td>{{$query[$i]->quantity}}</td><td>{{$query[$i]->price}}</td><td>{{$query[$i]->amount}}</td></th></tr>
            @endfor
    	</table>
    </div>
@stop
