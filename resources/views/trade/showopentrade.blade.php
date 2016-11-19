@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" ><a href="{{ route('tradestock')}} "/>Trade Stock</a></li>
    <li role="presentation" class="active"><a href="{{ route('opentrades')}} "/>Open Trades</a></li>
    <li role="presentation" ><a href="{{ route('failtrades')}} "/>Fail Trades</a></li>
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

.notice {
    color: blue;

}
</style>

@section('page-header')
    <h1 class="page-header">Open Trade</h1>
    <div>
        @if (count($trades) == 0)
    	<p id="openTrades"> You currently have no open trades</p>
        @endif

        @if (Session::has('message'))
            <strong class = "notice">Trading with id {{Session::get('message', '')}} canceled </strong> 
            <br>
        @endif
    	<div>
    		<table>
                <tr>
                  <th>Id</th>
                  <th>Date</th>
                  <th>Action</th>
                  <th>Trade Type</th>
                  <th>Stock Symbol</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total Value</th>
                </tr>
                @foreach ($trades as $trade)
                  <tr>
                    <td>{{ $trade->t_id}}</td>
                    <td>{{ $trade->time}}</td>
                    <td><a href="{{ route('canceltrade', $trade->t_id )}} ">Cancel</a></td>
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