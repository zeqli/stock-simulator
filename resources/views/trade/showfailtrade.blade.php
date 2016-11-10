@extends('layouts.simulator')


@section('nav-pills')
    <li role="presentation" ><a href="{{ route('tradestock')}} "/>Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} "/>Open Trades</a></li>
    <li role="presentation" class="active"><a href="{{ route('failtrades')}} "/>Fail Trades</a></li>
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
    <h1 class="page-header">Fail Trade</h1>
    <div>
    	<p id="failTrades"> You currently have no failed trades</p>
    	<div>
    		<table>
    			<th><td>Date</td><td>Trade Type</td><td>Stock Symbol</td><td>Quantity</td><td>Price</td><td>Total Value</td></th>
    		</table>
    	</div>
    </div>
@stop
