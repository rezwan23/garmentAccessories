@extends('layouts.master')

@section('title', 'Print Copy')

@section('head')
    <style>
        @media print{
            .item_commercial thead tr th{
                padding:10px;
                font-size:13px;
            }
            .item_commercial tbody tr td{
                padding:4px 2px;
            }
            .raw thead tr th{
                padding:10px;
                font-size:13px;
            }
            .raw tbody tr td{
                padding:4px 2px;
            }
        }
    </style>
@endsection
@section('content')
    <a href="javascript:void(0);" onclick="print()" class="float-right btn btn-primary btn-sm">Print</a>
    <div id="print" style="width:100%;margin:0 auto;">
        <table border="0" width="100%" style="margin-top:4px">
            <th style="margin: 0 auto;"><h1 style="text-transform: uppercase;"> <center> Work Order</center></h1></th>
        </table>
        <table border="0" width="100%">
            <td width="65%">
                <h2 style="text-transform: uppercase;margin: 0;padding: 0;">{{auth()->user()->company->name}}</h2>
                <p style="text-transform: uppercase;margin: 0;padding: 0;">{{auth()->user()->company->address}}</p>
                <p style="margin: 0;padding: 0;">Phone: {{auth()->user()->company->phones}}</p>
                <p style="margin: 0;padding: 0;">E-MAIL: {{auth()->user()->company->emails}}</p>
                <p style="margin: 0;padding: 0;">Website: {{auth()->user()->company->website}}</p>
            </td>
            <td width="35%">
                <div style="width:100%; height:150px;border:2px solid #000">
                    <h2 style="text-align: center;border-bottom:2px dashed">Factory Copy</h2>
                    {{--<h3 style="text-align: center; margin:0px;">{{auth()->user()->company->name}}</h3>--}}
                    <hr>
                    <h3>Date: {{$order->order_date}}</h3>
                </div>
            </td>
        </table>
        <div style="text-align: center;">
            <h1 style="background-color: #000;padding: 10px;color:#fff;border-radius:5px;display: inline-block;">Job ID: {{$order->id}}</h1>
        </div>
        <hr>
        <table border="0" width="100%" style="margin-top:10px">
            <tr>
                <td width="25%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;text-transform:uppercase">DELIVERY TO:</h4></td>
                <td width="75%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;"><span style="border-bottom:1px solid #000;width: 100%;display: block;">{{$order->garments->name}}</span></h4></td>
            </tr>
            <tr>
                <td height="20px"></td>
            </tr>
            <tr>
                <td width="25%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;text-transform:uppercase">DELIVERY PLACE:</h4></td>
                <td width="75%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;"><span style="border-bottom:1px solid #000;width: 100%;display: block;">{{$order->garments->address}}</span></h4></td>
            </tr>
            <tr>
                <td height="20px"></td>
            </tr>
            <tr>
                <td width="25%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;text-transform:uppercase">DELIVERY DATE:</h4></td>
                <td width="75%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;"><span style="border-bottom:1px solid #000;width: 100%;display: block;">{{$order->delivery_date}}</span></h4></td>
            </tr>
            <tr>
                <td height="20px"></td>
            </tr>
            <tr>
                <td width="25%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;text-transform:uppercase">buyer name:</h4></td>
                <td width="75%"><h4 style="text-transform: uppercase;margin: 0;padding: 0;"><span style="border-bottom:1px solid #000;width: 100%;display: block;">{{$order->buyer->name}}</span></h4></td>
            </tr>
        </table>
        <div class="info" style="overflow: hidden;">
            <div style="margin-top:10px;width: 60%;margin-right: 5%; float: left;">
                {{--<h4 style="text-align: center; display: block; padding:20px; border: 2px solid #000;">Item-Commercials</h4>--}}
                <table border="1" style="width: 100%;border-collapse: collapse;" class="item_commercial">
                    <thead>
                    <tr>
                        <th width="35%">Item</th>
                        <th width="20%">Style</th>
                        <th width="10%">Quality</th>
                        <th width="20%">Color</th>
                        <th width="10%">Quantity</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{$item->item->name}} - {{$item->size}}</td>
                            <td>{{$item->style_number}}</td>
                            <td>{{$item->quality}}</td>
                            <td>{{$item->color->name}}</td>
                            <td>{{$item->quantity}} {{$item->item->unit->name}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="margin-top:10px;width: 35%; float:left; overflow: hidden;">
                @foreach($order->items as $item)
                    <table border="1" width="100%" style="border-collapse: collapse" class="raw" style="margin-bottom: 4px;">
                        <thead>
                        <tr>
                            <th colspan="2">{{$item->item->name}}</th>
                        </tr>
                        <tr>
                            <th>Raw Materials</th>
                            <th>Quantity</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($item->requirements as $requirement)
                            <tr>
                                <td>{{$requirement->accessory->name}}</td>
                                <td>{{$requirement->quantity}} {{$requirement->accessory->unit->name}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endforeach
            </div>
        </div>
        <div class="meta" style="width:100%">
            <table border="1" style="border-collapse: collapse;margin-top:10px" width="100%" class="raw">
                <thead>
                <tr>
                    <th width="80%">SWATCH/QUALITY/COLOR</th>
                    <th>DELIVERY DATE</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td style="height:125px"></td>
                    <td style="height:125px"></td>
                </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-top:50px;">
            <div style="float:left" width="120px" class="receive">
                <p style="border-top:1px solid #000">RECEIVE SIGNATURE</p>
            </div>
            <div style="float:right" width="120px" class="receive">
                <p style="border-top:1px solid #000">AUTHORIZED SIGNATURE</p>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{asset('admin/js/jquery-3.2.1.min.js')}}"></script>
    <script src="{{asset('admin/js/printThis.js')}}"></script>
    <script>
        function print()
        {
            $('#print').printThis({
                importStyle: true,
            });
        }
    </script>
    @if(request()->filled('print')&&request()->get('print')=='true')
        <script>
            print();
            setTimeout(function(){
                window.close();
            }, 2000)
        </script>
    @endif
@endsection