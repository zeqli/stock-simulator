@extends('layouts.simulator')


@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('markets') }}">markets</a></li>
    <li role="presentation"><a href="{{ route('watchlist') }}">watchlist</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Stock</h1>
@stop

@section('content')
<form class="form-horizontal" role="form" method="POST" action="{{ url('/simulator/markets/search/') }}">
    {{ csrf_field() }}
    <input type="text" name="symbol" placeholder="Search a symbol"/>
    <input type="submit" value="Search"/>
</form>

<div class="container-fluid">
	<!-- TradingView Widget BEGIN -->
	<div id="tv-medium-widget-1f5b7"></div>
	<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
	<script type="text/javascript">
	new TradingView.MediumWidget({
	  "container_id": "tv-medium-widget-1f5b7",
	  "symbols": [
	    
	      "{{ $symbol_e_obj->symbol }}"
	    
	  ],
	  "gridLineColor": "#e9e9ea",
	  "fontColor": "#83888D",
	  "underLineColor": "#dbeffb",
	  "trendLineColor": "#4bafe9",
	  "width": "700px",
	  "height": "500px",
	  "locale": "en"
	});
	</script>
	<!-- TradingView Widget END -->
</div>

<div class="container-fluid">
    <h3>{{ $symbol_e_obj->symbol }} STOCK CHART</h3>
		    
		    <p>Summary: </p>
		    <p>Code: {{ $stock[0] }}</p>
		    <p>Name: {{ $stock[1] }}</p>
		    <p>Last Trade Price: {{ $stock[2] }}</p>
		    <p>Last Trade Time: {{ $stock[3] }}Eastern Time</p>
		    <p>Last Trade Date: {{ $stock[4] }}</p>
		    <p>Change and Percent Change: {{ $stock[5]}} </p>
		    <p>Volume: {{ $stock[6] }}</p>
		    <p>Previous Close: {{ $stock[7]}} </p>
</div>

<div class="container-fluid">
		<!-- TradingView Widget BEGIN -->
	<script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
	<script type="text/javascript">
	new TradingView.widget({
	  "width": 680,
	  "height": 410,
	  "symbol": "{{ $symbol_e_obj->symbol }}",
	  "interval": "D",
	  "timezone": "Etc/UTC",
	  "theme": "White",
	  "style": "1",
	  "locale": "en",
	  "toolbar_bg": "#f1f3f6",
	  "enable_publishing": false,
	  "allow_symbol_change": true,
	  "hideideas": true
	});
	</script>
	<!-- TradingView Widget END -->
</div>
@stop



