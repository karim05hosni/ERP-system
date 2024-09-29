@extends('Admin.layouts.parent')
@section('title', 'Income Statement')
@section('content')
    <style>
        @import "compass/css3";

        /* Font */

        @import url(http://weloveiconfonts.com/api/?family=entypo);


        [class*="entypo-"]:before {
            font-family: 'entypo', sans-serif;
        }

        #cashicon {
            font-family: arial;
            font-weight: bold;
            font-size: 22px;
            padding-left: 19px;
            padding-right: 5px;
        }





        /* Universal Settings*/


        * {
            user-select: none;
            cursor: default;
        }

        p {
            margin: 0;
        }

        a {
            display: block;
            cursor: pointer;
        }

        .icon {
            padding-left: 15px;
            cursor: pointer;
        }

        hr {
            height: 0;
            border: 0;
            margin: 0;
            border-top: 1px solid black;
            border-bottom: 1px solid #383838;
        }

        .hrv {
            height: 70px;
            margin-bottom: -10px;
            margin-left: 20px;
            margin-right: 20px;
            border-left: 1px solid;
            display: inline-block;
        }





        /* Local */

        hr {
            margin-bottom: 4%;
        }

        .tr1 {
            transition: 0.15s;
        }

        .ptrend {
            color: #356b3d;
        }

        .ptrend:hover {
            color: green;
        }

        .ntrend {
            color: #8f4747;
        }

        .ntrend:hover {
            color: #a82b2b;
        }

        .dtrend {
            color: #5e5e5e;
        }

        .dtrend:hover {
            color: #858585;
        }

        .figure {
            float: right;
        }

        .w_item {
            display: block;
            margin-bottom: 8px;
        }

        .span22 {
            width: 22%;
            height: 90%;
            margin: 1%;
            float: left;
            display: inline;
        }

        .span50 {
            background-color: #171717;
            width: 50%;
            height: 90%;
            margin: 1%;
            float: left;
            display: inline;
        }

        .well {
            font: 22px Calibri, sans-serif;
            background: #cccccc;
            padding: 6%;
            width: 420px;
            min-width: 300px;
            transition: 0.4s;
            border-radius: 6px;
        }

        .well:hover {
            background: #212121;
        }

        .title {
            font: 23px Calibri Light, sans-serif;
            color: #5e5e5e;
        }

        .title2 {
            font: 20px Calibri Light, sans-serif;
            font-weight: bold;
            color: #5e5e5e;
            margin-bottom: 4%;
        }

        .title2:hover {
            color: #858585;
        }





        /* Other */

        .container {
            position: relative;
            height: 100%;
            width: 100%;
        }
        #date {
            font-size: 18px ;
        }
        .w1 {
            height: auto;
        }

        .w1:hover {
            .w1d {
                color: #858585;
            }
        }

        .w2:hover {
            .w2d {
                color: #858585;
            }
        }

        .w2_1:hover {
            .w2_1d {
                color: #858585;
            }
        }

        .w2_2:hover {
            .w2_2d {
                color: #858585;
            }
        }

        .w3:hover {
            .w3d {
                color: #858585;
            }
        }

        .w3_1:hover {
            .w3_1d {
                color: #858585;
            }
        }
    </style>
        <div class="span22">
            <div class="well w1">
                <p class="title w1d tr1">Income Statement </p>
                <p id="date" class="w1d tr1">from: {{$startDate}} to:{{$endDate}}</p>
                <hr />
                <div id="sales_revenue" class="w_item ptrend">
                    <span id="sales_revenue_figure" class="figure tr1">
                        {{$Sales}}
                    </span>
                    <span class="tr1 entypo-up-bold" style="display: inline;">
                        Sales Revenue:
                    </span>
                </div>
                <div id="beginningInventory" class="w_item ntrend">
                    <span id="cost_of_sales_figure" class="figure tr1">
                        {{$beginningInventory}}
                    </span>
                    <span class="tr1 entypo-down-bold" style="display: inline;">
                        Beginning Inventory:
                    </span>
                </div>
                <div id="" class="w_item ntrend">
                    <span id="cost_of_sales_figure" class="figure tr1">
                        {{$Purchases}}
                    </span>
                    <span class="tr1 entypo-down-bold" style="display: inline;">
                        Purchases:
                    </span>
                </div>
                <div id="" class="w_item ntrend">
                    <span id="cost_of_sales_figure" class="figure tr1">
                        {{$cost_of_sales}}
                    </span>
                    <span class="tr1 entypo-down-bold" style="display: inline;">
                        Cost of Sales:
                    </span>
                </div>
                <div id="sales_revenue" class="w_item ptrend">
                    <span id="sales_revenue_figure" class="figure tr1">
                        {{$grossProfit}}
                    </span>
                    <span class="tr1 entypo-up-bold" style="display: inline;">
                        Gross Profit:
                    </span>
                </div>

                <div id="" class="w_item ntrend">
                    <span id="cost_of_sales_figure" class="figure tr1">
                        {{($grossProfit*16)/100}}
                    </span>
                    <span class="tr1 entypo-down-bold" style="display: inline;">
                        operating expenses:
                    </span>
                </div>

                <div id="net_profit" class="w_item ptrend">
                    <span id="net_profit_figure" class="figure tr1">
                        {{$netProfit}}
                    </span>
                    <span class="tr1 entypo-up-bold" style="display: inline;">
                        Net Profit:
                    </span>
                </div>
                

            </div>
        </div>
@endsection