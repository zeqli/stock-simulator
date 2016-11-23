@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" ><a href="{{ route('markets') }}">markets</a></li>
    <li role="presentation" class="active"><a href="{{ route('watchlist') }}">watchlist</a></li>
@stop
<style>
table {
    width: 100%;
    margin-top: 20px;
}

td, th {
    border-left: 10px;
    margin:10px;
    text-align:center;
}
}
</style>

@section('page-header')
    <h1 class="page-header">Watchlist</h1>
    <div>
        <p>Track stocks without adding it to your portfolio.</p>
    </div>
    <div>
    	<div>
    		<h3>Stock Portfolio</h3>
            <br>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/simulator/markets/add/') }}">
                {{ csrf_field() }}
  

                <input type="text" name="symbol" placeholder="enter symbol you want to add into watchlist" size="50">
                <input type="submit" name="submit" value="Add symbol">
            </form>
            <div id="watchlist">
    		<table>       
    			<tr>
                    <th>
                        <td>Symbol</td>
                        <td>Company</td>
                        <td>Last Trade</td>
                        <td>Today's Change</td>
                    </th>
                </tr>
                
                @foreach($query as $entry)
                    <tr>
                        <th>
                            <td>{{ $entry['symbol'] }}</td>
                            <td>{{ $entry['name'] }}</td>
                            <td>{{ $entry['lasttrade'] }}</td>
                            <td>{{ $entry['change'] }}</td>
                        </th>
                    </tr>
                @endforeach

    		</table>
            </div>
            
        </div>
        
    </div>
@stop
