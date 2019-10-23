@extends('layouts.master')

@section('title', 'Yarn Received')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Job ID {{$order->id}} Materials </h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Yarn</th>
                            <th>Order Quantity</th>
                            <th>Received Quantity</th>
                            <th>Unit</th>
                            <th>Receive Date</th>
                            <th>Challan Number</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($order->items as $item)
                            @foreach($item->requirements as $material)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$material->accessory->name}}</td>
                                    <td>{{$material->quantity}}</td>
                                    <td>{{$material->getReceivedMaterialCount()}}</td>
                                    <td>{{$material->accessory->unit->name}}</td>
                                    <td>{{$material->getChallan->pluck('created_at')->map ->format('Y-m-d')->implode(', ')}}</td>
                                    <td>{{$material->getChallan->pluck('challan_number')->implode(', ')}}</td>
                                </tr>
                                @endforeach
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

