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

tr th{
  font-size: 13px;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #666;
  border-bottom: 1px solid #ccc;
}
.w1 {
    width:8%;
    text-align:right;
}
.w2 {
    width:22%;
    text-align:right;
}
.w3 {
    width:10%;
    text-align:right;
}
.w4 {
    width:10%;
    text-align:right;
}
.w5 {
    width:10%;
    text-align:right;
}
.w6 {
    width:10%;
    text-align:right;
}
.w7 {
    width:10%;
    text-align:right;
}
.w8 {
    width:10%;
    text-align:right;
}
.w9 {
    width:10%;
    text-align:right;
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
                  <th class="w1">ORDER #</th>
                  <th class="w2">ORDER DATE & TIME</th>
                  <th class="w3"></th>
                  <th class="w4">TRANSACTION</th>
                  <th class="w5">SYMBOL</th>
                  <th class="w6">QUANTITY</th>
                  <th class="w7">ORDER PRICE</th>
                  <th class="w8">TOTAL VALUE</th>
                  <th class="w9">STATUS</th>      
                </tr>
                @foreach ($failtrades as $trade)
                  <tr>
                    <td class="w1">{{ $trade->t_id}}</td>
                    <td class="w2">{{ $trade->time}}</td>
                    <td class="w3"></td>
                    <td class="w4">{{ $trade->buy_sell }}</td> 
                    <td class="w5" style="font-family:monospace; font-size:16px;">
                      <a href="{{ route('stocks', ['symbol' => $trade->symbol]) }}">{{ strtoupper($trade->symbol)}}</a>
                    </td>
                    <td class="w6">{{ $trade->quantity}}</td>
                    <td class="w7">{{ $trade->price}}</td>
                    <td class="w8">{{ $trade->price * $trade->quantity}}</td>
                    <td class="w9">{{ $trade->status}}</td>
                  </tr>
                @endforeach
    		</table>
    	</div>
    </div>
@stop
