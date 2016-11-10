@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" ><a href="{{ route('markets') }}">markets</a></li>
    <li role="presentation" class="active"><a href="{{ route('watchlist') }}">watchlist</a></li>
@stop
<style>
table {
    width: 100%;
    margin-top: 20px;
}

td, th {
    border-left: 10px;
    margin:10px;
    text-align:center;
}
}
</style>

@section('page-header')
    <h1 class="page-header">Watchlist</h1>
    <div>
    	<div>
    		<h3>Stock Portfolio</h3>
            <br>
            <input type="text" name="symbol" placeholder="enter symbol you want to add into watchlist" size="50">
            <input type="submit" name="submit" value="Add symbol">
            <div id="watchlist">
    		<table>       
    			<th><td>Symbol</td><td>Company</td><td>Last Trade</td><td>Today's Change</td></th>
    		</table>
            </div>
            
        </div>
        
    </div>
@stop
