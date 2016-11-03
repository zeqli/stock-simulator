@extends('layouts.simulator')

@section('nav-bar')
    @parent
    @include('markets.markets-nav')
@endsection



@section('nav-tabs')
    <li role="presentation" class="active"><a href="{{ route('markets') }}">markets</a></li>
    <li role="presentation"><a href="{{ route('watchlist') }}">watchlist</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Watchlist</h1>
@stop
