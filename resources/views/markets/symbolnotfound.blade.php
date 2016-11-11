@extends('layouts.simulator')


@section('page-header')
    <h1 class="page-header">Symbol Not Found</h1>
@stop

@section('content')
                    
<p>The symbol you are looking for cannot be found, this is either due toan incorrect symbol or because we currently have no data on the symbol you are looking for. Please use the search box below to try again</p>
<form class="form-horizontal" role="form" method="POST" action="{{ url('/simulator/markets/search/') }}">
    {{ csrf_field() }}
    <input type="text" name="symbol" placeholder="Search a symbol"/>
    <input type="submit" value="Search"/>
</form>
@stop



