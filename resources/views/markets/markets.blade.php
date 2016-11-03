@extends('layouts.simulator')


@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('markets') }}">markets</a></li>
    <li role="presentation"><a href="{{ route('watchlist') }}">watchlist</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Markets</h1>
@stop
