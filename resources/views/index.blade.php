@extends('layouts.app')

@section('content')
    <div class="jumbotron">
        <div class="container">
            <h1>Welcome to Stock Simulator</h1>
            <p>This is a virtual stock exchange trading simulator, you can test drive your trading strategy easily here.</p>
            <p>Trade with a starting balance of $100,000 and zero risk!</p>
            <p><a class="btn btn-primary btn-lg" href="{{ route("profile") }}" role="button">Stock Simulator</a></p>
        </div>
    </div>
@stop


    