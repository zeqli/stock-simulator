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
        @if (count($failtrades) == 0)
    	<p id="failTrades"> You currently have no failed trades</p>
        @endif
    	<div>
    		<table>
                <tr>
                  <th>Id</th>
                  <th>Date</th>
                  <th>Trade Type</th>
                  <th>Stock Symbol</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total Value</th>
                </tr>
                @foreach ($failtrades as $trade)
                  <tr>
                    <td>{{ $trade->t_id}}</td>
                    <td>{{ $trade->time}}</td>
                    <td>{{ $trade->{'buy/sell'} }}</td> 
                    <td>{{ $trade->symbol}}</td>
                    <td>{{ $trade->quantity}}</td>
                    <td>{{ $trade->price}}</td>
                    <td>{{ $trade->price * $trade->quantity}}</td>
                  </tr>
                @endforeach
    		</table>
    	</div>
    </div>
@stop
