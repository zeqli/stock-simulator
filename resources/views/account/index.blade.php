@extends('layout')

@section('content')

    <h1>All Users</h1>
    
    @foreach($users as $user)
        <div>
            {{ $user->name }}
        </div>
    @endforeach

@stop