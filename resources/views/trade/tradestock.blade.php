@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('tradestock')}}">Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} ">Open Trades</a></li>
    <li role="presentation" ><a href="{{ route('failtrades')}} ">Fail Trades</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Trade Stock</h1>


	@if (session('symbol'))
		<div class="alert alert-warning">
			<p>{{ session('symbol') }} is not a valid symbol</p>
		</div>
	@elseif(session('quantity'))
		<div class="alert alert-warning">
			<p>The quantity needs to be a valid number from 1 to 999999.</p>
		</div>
	@endif


	<div>
		<form action="{{ route('tradepreview') }}" method="post">
			<table>
				<tr>
					<th>STOCK SYMBOL</th>
					<td><input name="sym" type="text" value="{{old('sym')}}"></td>
				</tr>
				<tr>
					<th>TRANSACTION</th>
					<td>
						<select name="trans">
							<option value="buy" {{ old("trans") == 'buy' ? "selected":"" }}>Buy</option>
							<option value="sell" {{ old("trans") == 'sell' ? "selected":"" }}>Sell</option>
							<option value="ss" {{ old("trans") == 'ss' ? "selected":"" }}>Sell Short</option>
							<option value="btc" {{ old("trans") == 'btc' ? "selected":"" }}>Buy to Cover</option>
						</select>
					</td>
				</tr>
				<tr>
					<th>QUANTITY</th>
					<td><input type="text" name="qty" value="{{old('qty')}}"></td>
				</tr>
				<tr>
					<th>PRICE</th>
					<td><input type="radio" name="price" value="mkt" checked="checked">Market</td>
				</tr>
				<tr>
					<th>DURATION</th>
					<td>
						<select name="do">
							<option value="gtc" {{ old("do") == 'gtc' ? "selected":"" }}>Good Till Cancelled</option>
							<option value="dor" {{ old("do") == 'dor' ? "selected":"" }}>Day Order</option>
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" value="Preview Order">

		</form>
	</div>
@stop


