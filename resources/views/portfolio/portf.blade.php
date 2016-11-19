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
}
</style>

@section('page-header')
    <h1 class="page-header">Portfolio Index</h1>
    <div>
    	<h3>Stock Portfolio</h3>
    	<table>
    		<tr><th><td>Type</td><td>Symbol</td><td>Quantity</td><td>Purchase Price</td><td>Current Price</td></th></tr>
            
            @foreach($query as $entry)
                    <tr>
                        <th>
                            <td>{{ $entry['buy_sell'] }}</td>
                            <td>{{ $entry['symbol'] }}</td>
                            <td>{{ $entry['quantity'] }}</td>
                            <td>{{ $entry['price'] }}</td>
                            <td>{{ $entry['lasttrade'] }}</td>
                           
                        </th>
                    </tr>
                @endforeach
    	</table>
    
    </div>
@stop
