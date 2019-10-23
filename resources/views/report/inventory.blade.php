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
@section('title', 'Inventory Report')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Inventory Report
                    <span class="d-print-none float-right"><a href="#" onclick="window.print()" class="btn btn-warning btn-sm">Print</a></span>
                </h4>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Accessory</th>
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
                                    <td>{{$singleData->getInventoryInCount()}} {{$singleData->accessory->unit->name}}</td>
                                    <td>{{$singleData->getInventoryOutCount()}} {{$singleData->accessory->unit->name}}</td>
                                    <td>{{$singleData->accessory->unit->name}}</td>
                                    <td>{{number_format($singleData->available_quantity, 0)}} {{$singleData->accessory->unit->name}}</td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-print-none">
                            {{$data->appends(request()->query())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection