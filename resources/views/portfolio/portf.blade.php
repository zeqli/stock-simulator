@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('portfolio') }}">Portfolio</a></li>
    <li role="presentation" ><a href="{{ route('tradehistory') }}">Trade History</a></li>
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
.w1 {
    width:5%;
    text-align:center;
}
.w2 {
    width:6%;
    text-align:left;
}
.w3 {
    width:19%;
    text-align:left;
}
.desc{
    font-size: 12px;
}
.w4 {
    width:5%;
    text-align:right;
}
.w5 {
    width:14%;
    text-align:right;
}
.w6 {
    width:13%;
    text-align:right;
}
.w7 {
    width:12%;
    text-align:right;
}
.w8 {
    width:13%;
    text-align:right;
}
.w9 {
    width:13%;
    text-align:right;
}

.summry{
  width:60%;
  font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px; 
}

.info{
  font-size: 13px;
  text-align: left;
}
</style>

@section('page-header')
    <h1 class="page-header">Portfolio Index</h1>
@stop

@section('content')

    <div class="summry">
        <table>
            <td class="info"><strong>Account Value (USD)</strong> {{ $acctval }}</td>
            <td class="info"><strong>Buying Power</strong> {{$cash}}</td>
            <td class="info"><strong>Cash</strong> {{$cash}}</td>
        </table>
    </div>

    <h3>STOCK PORTFOLIO</h3>

    <div>
        <table>
            <tr>
                <th class="w1"></th>
                <th class="w2">SYMBOL</th>
                <th class="w3">DESCRIPTION</th>
                <th class="w4">QTY</th>
                <th class="w5">PURCHASE PRICE</th>
                <th class="w6">CURRENT PRICE</th>
                <th class="w7">TOTAL VALUE</th>
                <th class="w8">TODAY'S CHANGE</th>
                <th class="w9">TOTAL GAIN/LOSS</th>
            </tr> 
            
            @foreach($query as $entry)
                <tr>
                    <td class="w1"><a href="{{
                            route('tradestock').'/?sym='.$entry['symbol'].'&trans=sell'
                    }}">Sell</a>
                    </td>
                    <td class="w2">
                        <a href="{{ route('stocks', ['symbol' => $entry['symbol']]) }}">{{ strtoupper($entry['symbol'])}}</a>
                    </td> 
                    <td class="w3 desc">{{ $entry['description'] }}</td>
                    <td class="w4">{{ $entry['qty'] }}</td>
                    <td class="w5">{{ $entry['purchaseprice'] }}</td>
                    <td class="w6">{{ $entry['currentprice'] }}</td>
                    <td class="w7">{{ $entry['totalvalue'] }}</td>
                    <td class="w8">{{ $entry['change'] }}</td>
                    <td class="w9">{{ $entry['totalgainloss'] }}({{ $entry['totalgainlosspercent'] }})</td>

                    {{-- <th>
                        <td>{{ $entry['symbol'] }}</td>
                        <td>{{ $entry['quantity'] }}</td>
                        <td>{{ $entry['price'] }}</td>
                        <td>{{ $entry['lasttrade'] }}</td>
                        <td>{{ $entry['total'] }}</td>
                     </th>--}}
                </tr>
            @endforeach

        </table>
    </div>
@stop
