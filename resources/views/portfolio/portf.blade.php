@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('portfolio') }}">Portfolio</a></li>
    <li role="presentation" ><a href="{{ route('tradehistory') }}">Trade History</a></li>
@stop


@section('page-header')
    <h1 class="page-header">Portfolio Index</h1>
@stop
