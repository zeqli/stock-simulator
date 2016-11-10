@extends('layouts.simulator')

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('profile') }} "/>Profile</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Profile</h1>
    <div>
    	<h2>{{$user->name}}</h2>
    	<div style="background-color:#D8D8D8;width:200px;height:200px;border:3px">
    		<label>Email : </label>
    		<p>{{$user->email}}<p>
    		<label>Member since : </label>
    		<p>{{$user->created_at}}</p>
    		<label>Account Value : </label>
    	</div>
    	
   
    </div>
@stop
