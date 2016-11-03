@extends('layouts.simulator')


@section('nav-pills')
    <li role="presentation" ><a href="{{ route('tradestock')}} "/>Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} "/>Open Trades</a></li>
    <li role="presentation" class="active"><a href="{{ route('failtrades')}} "/>Fail Trades</a></li>
@stop



@section('page-header')
    <h1 class="page-header">Fail Trade</h1>
@stop
