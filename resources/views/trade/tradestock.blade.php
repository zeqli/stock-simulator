@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('tradestock')}}">Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} ">Open Trades</a></li>
    <li role="presentation" ><a href="{{ route('failtrades')}} ">Fail Trades</a></li>
@stop

<style type="text/css">
.summry{
  width:60%;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px; 
}

.info{
  font-size: 13px;
  text-align: left;
  color: #900;
}
</style>

@section('page-header')
    <h1 class="page-header">Trade Stock</h1>

	@if( session('close'))
		<div class="summry">
	        <p class="info"><strong>Market is Currently Closed</strong></p>
	    </div>
    @endif


	@if (session('symbol'))
		<div class="alert alert-warning">
			<p>{{ strtoupper(session('symbol')) }} is not a valid symbol</p>
		</div>
	@elseif(session('quantity'))
		<div class="alert alert-warning">
			<p>The quantity needs to be a valid number from 1 to 999999.</p>
		</div>
	@elseif(session('sell-error'))
		<div class="alert alert-warning">
			<p>Invalid Trade: Insufficient quantity owned. You don't own the amount of stock your trying to sell.</p>
		</div>
	@elseif(session('buy-error'))
		<div class="alert alert-warning">
			<p>Invalid Trade: Insufficient buying power. The largest position that you can make an order with is {{session('maxposit')}}</p>
		</div>
	@endif


	<div>
		<form action="{{ route('tradepreview') }}" method="post">
			<table>
				<tr>
					<th>STOCK SYMBOL</th>
					<td><input name="sym" type="text" value="{{ request('sym') ? strtoupper(request('sym')) : old('sym')}}"></td>
				</tr>
				<tr>
					<th>TRANSACTION</th>
					<td>
						<select name="trans">
							@if(request('trans'))
								<option value="buy" {{ request("trans") == 'buy' ? "selected":"" }}>Buy</option>
								<option value="sell" {{ request("trans") == 'sell' ? "selected":"" }}>Sell</option>
							@else
								<option value="buy" {{ old("trans") == 'buy' ? "selected":"" }}>Buy</option>
								<option value="sell" {{ old("trans") == 'sell' ? "selected":"" }}>Sell</option>
	{{-- 							<option value="ss" {{ old("trans") == 'ss' ? "selected":"" }}>Sell Short</option>
								<option value="btc" {{ old("trans") == 'btc' ? "selected":"" }}>Buy to Cover</option> --}}
							@endif
						</select>
					</td>
				</tr>
				<tr>
					<th>QUANTITY</th>
					<td><input type="text" name="qty" value="{{ request('qty') ? intval(request('qty')) : old('qty')}}"></td>
				</tr>
				<tr>
					<th>PRICE</th>
					<td><input type="radio" name="price" value="mkt" checked="checked">Market</td>
				</tr>
				<tr>
					<th>DURATION</th>
					<td>
						<select name="do">
							@if(request('do'))
								<option value="dor" {{ request("do") == 'dor' ? "selected":"" }}>Day Order</option>
								<option value="gtc" {{ request("do") == 'gtc' ? "selected":"" }}>Good Till Cancelled</option>
							@else
								<option value="dor" {{ old("do") == 'dor' ? "selected":"" }}>Day Order</option>
								<option value="gtc" {{ old("do") == 'gtc' ? "selected":"" }}>Good Till Cancelled</option>
							@endif
						</select>
					</td>
				</tr>
			</table>
			<input type="submit" value="Preview Order">

		</form>
	</div>
@stop


