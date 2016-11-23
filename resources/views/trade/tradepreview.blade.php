@extends('layouts.simulator')

<style type="text/css">
.adjust {
    width: 100%;
}

.box {
    position: relative;
}

.left {
    float: left;
}

.right {
    float: right;
}
.preview-left {
    width: 49%;
}


.title {
    margin: 0 0 12px 0;
    font-size: 22px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: grey;
    text-transform: uppercase;
    border-bottom: 1px solid #e4e5e6;
    
}

.table1 {
    border-collapse: collapse;
    width: 100%;
    margin: 0 auto;
    margin-bottom: 10px;
}

.table1 th {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 12px;
    color: grey;
    font-weight: normal;
    border-bottom: solid 1px #ddd;
}

.table2 th {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    font-size: 12px;
    color: grey;
    font-weight: normal;
}

td.num {
    text-align: right;
}

.w1 {
    width:20%;
}

.w2 {
    width:30%;
}


.w3 {
    width:15%;
}


.w4 {
    width:35%;
}

.w5 {
    width: 50%;
}


</style>

@section('nav-pills')
    <li role="presentation" class="active"><a href="{{ route('tradestock')}} "/>Trade Stock</a></li>
    <li role="presentation" ><a href="{{ route('opentrades')}} "/>Open Trades</a></li>
    <li role="presentation" ><a href="{{ route('failtrades')}} "/>Fail Trades</a></li>
@stop

@section('page-header')
    <h1 class="page-header">Trade Stock</h1>
    <!-- group box -->
    <div>
        <!-- box table left-->
        <div class="preview-left box left">
            <!-- table left -->
            <div>
                <h2 class="title">REVIEW ORDER</h2>
            </div>
            
            <div>
                <table class="table1" >
                    <tr>
                        <th class="w1" >DESCRIPTION</th>
                        <th class="w2" >TRANSACTION</th>
                        <th class="w3" >STOP/LIMIT</th>
                        <th class="w4" >DURATION(TERM)</th>
                    </tr>
                    <tr>
                        <td>{{ $symbol }}</td>
                        <td>{{ $trans }}</td>
                        <td>{{ $stlmt }}</td>
                        <td>{{ $duration }}</td>
                    </tr>
                </table>

                <table class="table1">
                    <tr>
                        <td rowspan="4" class="w5">At a price of ${{ $price }} per share, the value of this transaction is estimated at ${{$total}}, plus commission of ${{$commission}} for a total of ${{$total}}.</td>
                        <td class="w3">Price</td>
                        <td class="w4">${{ $price }}</td>
                    </tr>
                    <tr>
                        <td class="w3">Quantity</td>
                        <td class="w4">{{ $quantity }}</td>
                    </tr>
                    <tr>
                        <td class="w3">Commission</td>
                        <td class="w4">${{ $commission }}</td>
                    </tr>
                    <tr>
                        <td class="w3">Est. Total</td>
                        <td class="w4">${{ $total }}</td>
                    </tr>
                </table>
            </div>
            <br>

            <!-- Cancel, Submit, Change Order -->
            <div>
                <input type="button" value="Cancel" onclick="window.location.href='{{route('portfolio')}}'"/>
                <form action="route('tradeconfirm')">
                    <input type="submit" value="Submit Order"/>
                </form>
                <input type="button" value="Change Order" onclick="window.location.href='@php
                        echo route('tradestock')."/?sym=$symbol&trans=$trans&qty=$quantity&price=$price&do=$duration";
                        @endphp'"/>
            </div>
            

        </div>
        <!-- box table right -->
        <div class="preview-left box right">
            <!-- table right -->
            <div >
                <h2 class="title">ACCOUNT DETAILS</h2>
            </div>
            <table class="table2 adjust">
                <tr>
                    <th>VALUE (USD)</td>
                    <td class="value num">${{ $value }}</td>
                </tr>
                <tr>
                    <th>BUYING POWER</td>
                    <td class="value num">${{ $bpwr }}</td>
                </tr>
                <tr>
                    <th>CASH</td>
                    <td class="value num">${{ $cash }}</td>
                </tr>
            </table>
        </div>

        <!-- simple quotes -->
        <div>
                    
        </div>
    </div>
@stop