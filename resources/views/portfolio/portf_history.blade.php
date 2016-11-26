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

tr th{
  font-size: 13px;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #666;
  border-bottom: 1px solid #ccc;
}


tr td{
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 15px;
}

.notice {
    color: blue;
}
.w1 {
    width:20%;
    text-align:left;
}
.w2 {
    width:15%;
    text-align:left;
}
.w3 {
    width:5%;
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
    width:15%;
    text-align:right;
}
.w8 {
    width:15%;
    text-align:right;
}


</style>
@section('page-header')
    <h1 class="page-header">Trade History</h1>
    <div>
    	<table>
    		<tr>
                <th class="w1">DATE</th>
                <th class="w2">TRADE TYPE</th>
                <th class="w3">SYMBOL</th>
                <th class="w4">QUANTITY</th>
                <th class="w5">PRICE</th>
                <th class="w6">COMMISSION</th>
                <th class="w7">TOTAL CASH VALUE</th>
                <th class="w8">ACCOUNT VALUE</th>
            </tr>

            
            @foreach($trade_history as $record)
                <tr>
                    <td class="w1">{{  $record->time  }}</td>
                    <td class="w2">{{  $record->buy_sell  }}</td>
                    <td class="w3">
                        <a href="{{ route('stocks', ['symbol' => $record->symbol]) }}">{{ strtoupper($record->symbol)}}</a>
                    </td>
                    <td class="w4">{{  $record->quantity  }}</td>
                    <td class="w5">{{  '$'.number_format($record->price,2)  }}</td>
                    <td class="w6">{{  '$'.number_format($record->commission, 2)  }}</td>
                    <td class="w7">{{  '$'.number_format($record->total_value, 2)  }}</td>
                    <td class="w8">{{  '$'.number_format($record->account_value, 2)  }}</td>
                </tr>
            @endforeach
    	</table>
    </div>
@stop
