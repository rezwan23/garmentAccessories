@extends('layouts.master')

@section('title', 'Print PI')
@section('head')
    <style>
        @media print{
            #print{
                display: none;
            }
        }
    </style>
@endsection
@section('content')
    <button id="print" class="btn btn-warning btn-sm float-right" onclick="window.print();">Print</button>
    <div class="row">
        <div class="col-md-6">
            <h4 style="text-transform: uppercase;">{{auth()->user()->company->name}}</h4>
            <p>
                {!! auth()->user()->company->address !!}<br>
                Phone: {{auth()->user()->company->phones}}<br>
                E-Mail: {{auth()->user()->company->emails}}<br>
                Website: {{auth()->user()->company->website}}
            </p>
            <h6 style="text-transform: uppercase;background: #ededed;">Customer</h6>
            <p>
                {{$pi->garment->name}}<br>
                {{$pi->garment->address}}
            </p>

        </div>
        <div class="col-md-6">
            <h4 style="text-transform: uppercase;color:#000">PRO FORMA INVOICE</h4>
            <p>
                Date: {{\Carbon\Carbon::parse($pi->created_at)->format('Y-m-d')}}
                <br>
                Invoice: #{{$pi->serial_number}}
            </p>
            <h6 style="text-transform: uppercase;background: #ededed;">Buyer</h6>
            <p>
                {{implode(',', array_unique($pi->getBuyers()))}}
            </p>
        </div>
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>SL</th>
                    <th>DESCRIPTION OF GOODS</th>
                    <th>SIZE</th>
                    <th>STYLE</th>
                    <th>QTY</th>
                    <th>UNIT</th>
                    <th>UNIT PRICE</th>
                    <th>TOTAL AMOUNT</th>
                </tr>
                </thead>
                <tbody>
                @php
                $i=1;
                @endphp
                @foreach($pi->orders as $order)
                    @foreach($order->items as $item)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$item->item->name}}</td>
                        <td>{{$item->size}}</td>
                        <td>{{$item->style_number}}</td>
                        <td>{{$item->commercialDetails->quantity}}</td>
                        <td>{{$item->item->unit->name}}</td>
                        <td>{{$item->commercialDetails->unit_price}}</td>
                        <td>{{$item->commercialDetails->quantity*$item->commercialDetails->unit_price}}</td>
                    </tr>
                        @endforeach
                @endforeach
                </tbody>
            </table>
            <table style="width: 400px;" class="table table-bordered float-right">
                <tr>
                    <th>TOTAL</th>
                    <td>{{$pi->total}}</td>
                </tr>
                <tr>
                    <th>CURRENCY</th>
                    <td>USD</td>
                </tr>
            </table>
        </div>
        <div class="col-md-8">
            <div class="comments">
                <div class="card" style="text-transform: uppercase;">
                    <h6 class="card-header" style="background: #ededed;color: #000;">Terms of sale and other comments</h6>
                    <div class="card-body">
                        <p>
                            {!! auth()->user()->company->terms_conditions !!}
                        </p>
                    </div>
                </div>

            </div>
        </div>
        <div class="col-md-12">
            <h6 style="margin-top:20px;background:#ededed;text-transform: uppercase;">additional details</h6>
            <p>{{auth()->user()->company->additional_details}}</p>
        </div>
        <div class="col-md-4" style="margin-top:80px;">
            <div style="width:100%;height:1px;background:#000"></div>
            <p style="text-transform: uppercase;">authorized signature <br> {{auth()->user()->company->authorize_name}}</p>
        </div>
    </div>
@endsection