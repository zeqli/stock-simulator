@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('tradestock')}} "/>Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} "/>Open Trades</a></li>
    <li role="presentation" ><a href="{{ route('failtrades')}} "/>Fail Trades</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Trade Stock</h1>
    <div>
    	<form>
    		<label>Stock Symbol : </label>
    		<input type="text" name="stockSymbol">
    		<br><br>
    		<label>Transaction : </label>
    		<select>
    			<option>Buy</option>
    			<option>Sell</option>
    			<option>Sell short</option>
    			<option>Buy to Cover</option>
    		</select>
    		<br><br>
    		<label>Quantity : </label>
    		<input type="text" name="quantity">
    		<br><br>
    		<label>Duration : </label>
    		<select>
    			<option>Good Till Cancelled</option>
    			<option>Day Order</option>
    		</select>
    		<br><br>
    		<input type="submit" name="submit" value="submit">

    	</form>
    </div>
@stop