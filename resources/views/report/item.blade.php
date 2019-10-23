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
@section('title', 'Item Inventory Report')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Item Inventory Report
                    <span class="no-print float-right"><a href="#" onclick="window.print();" class="btn btn-warning btn-sm">Print</a></span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Item</th>
                                    <th>Color</th>
                                    <th>TodayIn</th>
                                    <th>TodayOut</th>
                                    <th>Unit</th>
                                    <th>Available Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $singleData)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$singleData->item->name}}</td>
                                        <td>{{$singleData->color->name}}</td>
                                        <td>{{number_format($singleData->todayInCount())}} {{$singleData->item->unit->name}}</td>
                                        <td>{{number_format($singleData->todayOutCount())}} {{$singleData->item->unit->name}}</td>
                                        <td>{{$singleData->item->unit->name}}</td>
                                        <td>{{number_format($singleData->available_quantity)}} {{$singleData->item->unit->name}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="no-print">
                            {{$data->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection