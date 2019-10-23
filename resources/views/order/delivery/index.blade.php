@extends('layouts.master')

@section('title', 'Order Delivery')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h3 class="card-header">Deliver Order</h3>
                <div class="card-body">
                    <div class="tile">
                        <div class="tile-body">
                            <form action="">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Job Id</label>
                                        <input id="job_id" value="{{request('job_id')}}" autocomplete="off" class="form-control" type="text" placeholder="Enter Job Id" name="job_id">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">Filter</label>
                                        <br>
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Job ID</th>
                                    <th>Delivery Status</th>
                                    <th>Delivery</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td>{{$loop->index+1}}</td>
                                    <td>{{$order->id}}</td>
                                    <td>
                                        <span class="badge badge-{{$order->getDeliveryStatusClass()}}">{{$order->getDeliveryStatus()}}</span>
                                    </td>
                                    {{--<td>--}}
                                        {{--@foreach($order->deliveries as $delivery)--}}
                                            {{--<a href="{{route('delivery.challan', $delivery)}}" class="badge badge-primary">Challan - {{$delivery->id}}</a>--}}
                                        {{--@endforeach--}}
                                    {{--</td>--}}
                                    <td>
                                        @if(!$order->delivery_status)
                                        <a href="{{route('delivery.create', $order)}}" class="btn btn-warning btn-sm">Delivery</a>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{route('delivery.show', $order)}}" class="btn btn-primary btn-sm">View</a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$orders->appends(request()->query())->links()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection