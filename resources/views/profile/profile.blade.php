@extends('layouts.simulator')

@section('nav-pills')
<li role="presentation" class="active"><a href="{{ route('profile') }} "/>Profile</a></li>
@stop

@section('page-header')
<h1 class="page-header">Profile</h1>

@stop


<style type="text/css">

.info {
    background-color:#D8D8D8;
    width:200px;
    height:200px;
    float: left;
}

.main {
    margin-left: 200px;
    width: auto;
}

.info-panel {
    margin: 10px;
}

</style>

@section('content')
    <h2>{{$user->name}}</h2>
        
        <div class="info">
            <div class="info-panel">
                <label>Email : </label>
                <p>{{$user->email}}<p>
                <label>Member since : </label>
                <p>{{$user->created_at}}</p>
                <label>Account Value : </label>
                <p>{{number_format($account_value)}}</p>
            </div>
        </div>

    <div class="main" style="padding: 0px;">
        <!-- TradingView Widget BEGIN -->
        <div id="tv-medium-widget-1f5b7"></div>
        <script type="text/javascript" src="https://d33t3vvu2t2yu5.cloudfront.net/tv.js"></script>
        <script type="text/javascript">
        new TradingView.MediumWidget({
          "container_id": "tv-medium-widget-1f5b7",
          "symbols": [
          "SPX"
          ],
          "gridLineColor": "#e9e9ea",
          "fontColor": "#83888D",
          "underLineColor": "#dbeffb",
          "trendLineColor": "#4bafe9",
          "width": "700px",
          "height": "500px",
          "locale": "en"
      });
        </script>
        <!-- TradingView Widget END -->
    </div>
    @stop