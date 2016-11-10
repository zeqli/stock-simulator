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
    		<th><td>Date</td><td>Trade Type</td><td>Stock Symbol</td><td>Quantity</td><td>Price</td><td>Total Cash Value</td><td>Account Value</td></th>
    	</table>
    </div>
@stop
