@extends('layouts.master')
@section('head')
    <style>
        @media print{
            .no-print{
                display:none;
            }
        }
    </style>
@endsection

@section('title', 'Dyeing Yarn Inventory Report')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Dyeing Yarn Inventory Report
                    <span class="float-right no-print"><a href="#" onclick="window.print();" class="btn btn-warning btn-sm">Print</a></span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Accessory</th>
                                    <th>Color</th>
                                    <th>TodayIn</th>
                                    <th>Today Out</th>
                                    <th>Unit</th>
                                    <th>Available Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $singleData)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$singleData->accessory->name}}</td>
                                    <td>{{$singleData->color->name}}</td>
                                    <td>{{$singleData->getInventoryInCount()}} {{$singleData->accessory->unit->name}}</td>
                                    <td>{{$singleData->inventoryOutCount()}} {{$singleData->accessory->unit->name}}</td>
                                    {{--<td>--}}
                                        {{--@php--}}
                                            {{--$collection = $singleData->inventoryInsAll->pluck('receiveYarn.orders');--}}
                                        {{--@endphp--}}
                                        {{--@if($collection->isNotEmpty())--}}
                                            {{--{{ $collection[0]->pluck('id')->implode(', ') }}--}}
                                        {{--@else--}}
                                            {{--{!! 'N/A' !!}--}}
                                        {{--@endif--}}
                                    {{--</td>--}}
                                    <td>{{$singleData->accessory->unit->name}}</td>
                                    <td>{{$singleData->available_quantity}} {{$singleData->accessory->unit->name}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="no-print">
                            {{$data->appends(request()->query())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection